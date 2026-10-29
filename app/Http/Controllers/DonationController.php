<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class DonationController extends Controller
{
    // 1. Menampilkan Halaman Form Donasi Saja
    public function showForm()
    {
        return view('donation-form');
    }

    // 2. Memproses Data dan Mengirim ke DOKU
    public function processPayment(Request $request)
    {
        $orderId = 'DONASI-' . time() . '-' . Str::random(5);
        $amount = $request->input('amount', 50000); 

        // Simpan data donasi ke database dengan status pending terlebih dahulu
        $donation = Donation::create([
            'order_id' => $orderId,
            'donor_name' => 'Hamba Allah',
            'amount' => $amount,
            'status' => 'pending',
        ]);

        // Ambil konfigurasi dari file .env
        $clientId = env('DOKU_CLIENT_ID'); // Brand ID (BRN-...)
        $sharedKey = env('DOKU_SHARED_KEY');
        $isProduction = filter_var(env('DOKU_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN);

        $baseUrl = $isProduction 
            ? 'https://api.doku.com' 
            : 'https://api-sandbox.doku.com';

        $targetPath = '/checkout/v1/payment';
        $fullUrl = $baseUrl . $targetPath;

        $requestId = Str::uuid()->toString();
        $requestTimestamp = gmdate("Y-m-d\TH:i:s\Z");

        // Format payload request DOKU Checkout
        $payload = [
            "order" => [
                "amount" => (int) $amount,
                "invoice_number" => $orderId,
                "currency" => "IDR",
                "callback_url" => route('donation.success', $orderId),
            ],
            "payment" => [
                "payment_due_date" => 60
            ]
        ];

        // Pastikan JSON di-encode dengan rapi tanpa spasi berlebih
        $jsonBody = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        // 1. Hitung Digest SHA-256 dari body JSON mentah
        $digestValue = base64_encode(hash('sha256', $jsonBody, true));

        // 2. Susun Component Signature sesuai urutan standar DOKU
        $componentSignature = "Client-Id:" . $clientId . "\n" .
                              "Request-Id:" . $requestId . "\n" .
                              "Request-Timestamp:" . $requestTimestamp . "\n" .
                              "Request-Target:" . $targetPath . "\n" .
                              "Digest:" . $digestValue;

        // 3. Buat HMAC-SHA256 signature menggunakan Shared Key
        $signature = base64_encode(hash_hmac('sha256', $componentSignature, $sharedKey, true));
        $finalSignature = 'HMACSHA256=' . $signature;

        $headers = [
            'Client-Id: ' . $clientId,
            'Request-Id: ' . $requestId,
            'Request-Timestamp: ' . $requestTimestamp,
            'Signature: ' . $finalSignature,
            'Content-Type: application/json'
        ];

        try {
            // Eksekusi menggunakan cURL PHP murni agar payload body tidak termodifikasi
            $ch = curl_init($fullUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

            $responseBody = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                return back()->with('error', 'Koneksi cURL gagal: ' . $curlError);
            }

            $responseData = json_decode($responseBody, true);

            if ($httpCode >= 200 && $httpCode < 300) {
                $paymentUrl = $responseData['response']['payment']['url'] ?? null;
                if ($paymentUrl) {
                    return redirect($paymentUrl);
                }
            }

            // Tangkap pesan error detail dari DOKU jika gagal
            $errorMsg = $responseData['error']['message'] ?? $responseBody ?: 'Unknown error';
            return back()->with('error', 'Gagal terhubung ke DOKU Payment Gateway (HTTP ' . $httpCode . '): ' . $errorMsg);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    // 3. Menerima Laporan Status dari DOKU (Webhook/Callback Notification)
    public function callback(Request $request)
    {
        try {
            $data = $request->json()->all();

            $orderId = $data['order']['invoice_number'] ?? $data['invoice_number'] ?? null;
            $status = $data['transaction']['status'] ?? $data['status'] ?? null;
            $customerName = $data['customer']['name'] ?? $data['customer_name'] ?? null;

            if ($orderId) {
                $donation = Donation::where('order_id', $orderId)->first();

                if ($donation) {
                    $updateData = [];

                    if (in_array(strtoupper($status), ['SUCCESS', 'SETTLED', 'PAID'])) {
                        $updateData['status'] = 'success';
                    } elseif (in_array(strtoupper($status), ['FAILED', 'EXPIRED', 'CANCELLED'])) {
                        $updateData['status'] = 'failed';
                    }

                    // Perbarui nama donatur jika dikirim oleh DOKU
                    if ($customerName && $customerName !== 'Hamba Allah') {
                        $updateData['donor_name'] = $customerName;
                    }

                    if (!empty($updateData)) {
                        $donation->update($updateData);
                    }
                }
            }

            return response()->json(['message' => 'Callback DOKU berhasil diproses']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan sistem webhook: ' . $e->getMessage()], 500);
        }
    }

    // 4. Menampilkan Halaman Sukses Donasi
    public function successPage($order_id)
    {
        $donation = Donation::where('order_id', $order_id)->firstOrFail();
        return view('donation-success', compact('donation'));
    }

    // 5. Menampilkan Halaman Dashboard / Live Feed Donasi
    public function dashboard()
    {
        $totalDonation = Donation::where('status', 'success')->sum('amount');
        $donations = Donation::where('status', 'success')->latest()->get();

        return view('donation-dashboard', compact('totalDonation', 'donations'));
    }
}