<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - Donasi Berhasil</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        burgundy: { DEFAULT: '#6b1d2f', light: '#8e2a42' },
                        olive: { DEFAULT: '#556b2f', pale: '#f4f6f0' }
                    },
                    fontFamily: { sans: ['Montserrat', 'Century Gothic', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-olive-pale flex items-center justify-center min-h-screen px-4 font-sans text-slate-800">

    <div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md text-center border border-slate-100 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-2 bg-olive"></div>

        <!-- Icon Centang (Nuansa Olive) -->
        <div class="w-20 h-20 bg-olive/10 text-olive rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner mt-2">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h2 class="text-xl font-extrabold text-burgundy mb-1">Terima Kasih, {{ $donation->donor_name }}!</h2>
        <p class="text-slate-500 text-xs mb-6">Kontribusi dan kebaikanmu telah tercatat di sistem.</p>

        <!-- Kotak Rincian Donasi -->
        <div class="bg-slate-50 rounded-2xl p-5 mb-6 text-left border border-slate-100 space-y-3 text-xs">
            <div class="flex justify-between">
                <span class="text-slate-400">ID Transaksi</span>
                <span class="font-mono font-semibold text-slate-700">{{ $donation->order_id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Nominal Donasi</span>
                <span class="font-bold text-slate-800">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-400">Status</span>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-olive/10 text-olive">
                    {{ $donation->status }}
                </span>
            </div>
        </div>

        <a href="{{ url('/') }}" class="block bg-burgundy hover:bg-burgundy-light text-white font-bold py-3.5 px-4 rounded-2xl transition-all shadow-md text-xs tracking-wide">
            Kembali ke Beranda
        </a>
    </div>

</body>
</html>