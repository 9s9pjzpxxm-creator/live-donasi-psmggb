<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi Pra-Kompetisi - PSM Gema Gita Bahana</title>
    <!-- Memanggil Font Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        burgundy: {
                            DEFAULT: '#6b1d2f',
                            dark: '#501321',
                            light: '#8e2a42',
                        },
                        olive: {
                            DEFAULT: '#556b2f',
                            dark: '#3f5023',
                            light: '#70883d',
                            pale: '#f4f6f0',
                        }
                    },
                    fontFamily: {
                        sans: ['Montserrat', 'Century Gothic', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Auto refresh halaman setiap 10 detik agar total dana & live feed terupdate otomatis -->
    <meta http-equiv="refresh" content="10">
</head>
<body class="bg-olive-pale min-h-screen flex items-center justify-center p-2 lg:p-4 font-sans text-slate-800">

    <!-- Diubah dari max-w-7xl menjadi max-w-full dengan margin horizontal yang sangat minimal (nyaris full screen) -->
    <div class="w-full max-w-[98%] xl:max-w-[96%] bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[92vh]">
        
        <!-- ================= SISI KIRI: TOTAL DANA & LIVE FEED DONATUR (7 Kolom) ================= -->
        <div class="lg:col-span-7 p-6 lg:p-10 xl:p-12 flex flex-col justify-between border-b lg:border-b-0 lg:border-r border-slate-100">
            <div>
                <!-- Header Title -->
                <div class="mb-6 lg:mb-8">
                    <span class="text-xs font-bold bg-burgundy/10 text-burgundy px-3.5 py-1 rounded-full uppercase tracking-wider">PSM Gema Gita Bahana</span>
                    <h1 class="text-3xl lg:text-4xl font-black text-slate-900 mt-3 tracking-tight">Konser Pra-Kompetisi</h1>
                    <p class="text-slate-500 text-sm lg:text-base mt-1">Dukung perjalanan dan perjuangan tim paduan suara kami.</p>
                </div>

                <!-- Kartu Akumulasi Total Donasi -->
                <div class="bg-gradient-to-br from-burgundy to-burgundy-dark p-8 lg:p-10 rounded-3xl shadow-xl text-white relative overflow-hidden mb-8">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-xl"></div>
                    <p class="text-xs lg:text-sm uppercase tracking-widest font-semibold text-rose-200 mb-2">Total Dana Terkumpul</p>
                    <h2 class="text-5xl lg:text-6xl xl:text-7xl font-black tracking-tight break-words">Rp {{ number_format($totalDonation, 0, ',', '.') }}</h2>
                    <div class="mt-4 flex items-center space-x-2">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs lg:text-sm text-rose-100 font-medium">Sistem Transparan & Real-time</span>
                    </div>
                </div>

                <!-- Kotak Riwayat Donatur (Live Feed) -->
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                    <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-4 flex items-center justify-between">
                        <span>Riwayat Donatur Sukses</span>
                        <span class="text-[10px] font-bold bg-olive-pale text-olive px-2.5 py-1 rounded-full border border-olive/20">Live Feed</span>
                    </h3>

                    <div class="space-y-3 max-h-72 overflow-y-auto pr-1">
                        @forelse($donations as $donation)
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-white border border-slate-100 shadow-sm">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-burgundy/10 text-burgundy font-extrabold flex items-center justify-center text-sm shadow-sm">
                                        {{ strtoupper(substr($donation->donor_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800">{{ $donation->donor_name }}</h4>
                                        <p class="text-[11px] text-slate-400 font-medium">{{ $donation->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-extrabold text-olive">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-slate-400 text-xs py-6">Belum ada data donasi yang sukses tercatat.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-8 text-xs text-slate-400 text-center lg:text-left">
                &copy; {{ date('Y') }} PSM Gema Gita Bahana. All rights reserved.
            </div>
        </div>

        <!-- ================= SISI KANAN: QR CODE BESAR & AJAKAN DONASI (5 Kolom) ================= -->
        <div class="lg:col-span-5 p-8 lg:p-12 xl:p-16 bg-gradient-to-br from-burgundy-dark via-burgundy to-olive-dark text-white flex flex-col items-center justify-center text-center relative overflow-hidden">
            
            <div class="absolute -left-16 -top-16 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 w-full max-w-md flex flex-col items-center">
                <span class="text-xs lg:text-sm font-bold uppercase tracking-widest text-rose-200 mb-3 bg-white/10 px-4 py-1.5 rounded-full">Scan & Berkontribusi</span>
                <h3 class="text-3xl lg:text-4xl font-black mb-6 lg:mb-8 text-white tracking-tight">Donasi Sekarang</h3>
                
                <!-- Kotak QR Code Diperbesar Maksimal -->
                <div class="bg-white p-5 lg:p-6 rounded-3xl shadow-2xl border-4 border-olive-light/40 inline-block mb-6 lg:mb-8 transform transition duration-300 hover:scale-105">
                    <!-- Pastikan file gambar QR DOKU ada di public/images/qr-doku.png -->
                    <img src="{{ asset('images/qr-doku.png') }}" alt="QR Code DOKU" class="w-72 h-72 lg:w-80 lg:h-80 xl:w-96 xl:h-96 object-contain mx-auto">
                </div>

                <div class="space-y-2 max-w-sm">
                    <p class="text-xs lg:text-sm font-semibold text-rose-100">
                        Buka aplikasi m-Banking atau E-Wallet (QRIS) pilihanmu.
                    </p>
                    <p class="text-[11px] lg:text-xs text-rose-200/80 leading-relaxed">
                        Arahkan kamera ke QR Code di atas untuk mengisi nominal dan menyelesaikan pembayaran secara aman melalui DOKU.
                    </p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>