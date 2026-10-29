<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi - Gema Gita Bahana</title>
    <!-- Memanggil Font Century Gothic / Montserrat sebagai alternatif web -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
</head>
<body class="bg-olive-pale min-h-screen py-12 px-4 flex flex-col items-center justify-center font-sans text-slate-800">
    
    <div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md border border-slate-100 relative overflow-hidden">
        <!-- Aksen Warna Burgundy di atas card -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-burgundy"></div>

        <div class="text-center mb-6 mt-2">
            <h2 class="text-2xl font-extrabold text-burgundy tracking-wide">Dukung Perjalanan Kami</h2>
            <p class="text-slate-500 text-xs mt-1">Ulurkan tangan terbaikmu untuk kesuksesan bersama.</p>
        </div>
        
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl relative mb-4 text-xs font-medium">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('donation.process') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="donor_name" class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">Nama Donatur (Opsional)</label>
                <input type="text" name="donor_name" id="donor_name" placeholder="Hamba Allah" class="bg-slate-50 border border-slate-200 rounded-2xl w-full py-3 px-4 text-slate-700 leading-tight focus:outline-none focus:ring-2 focus:ring-burgundy focus:border-transparent transition-all text-sm">
            </div>

            <div class="mb-6">
                <label for="amount" class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">Nominal Donasi (Min. Rp 1.000)</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-slate-400 font-bold text-xs">Rp</span>
                    <input type="number" name="amount" id="amount" min="1000" required placeholder="50000" class="bg-slate-50 border border-slate-200 rounded-2xl w-full py-3 pl-12 pr-4 text-slate-700 leading-tight focus:outline-none focus:ring-2 focus:ring-burgundy focus:border-transparent transition-all text-sm">
                </div>
            </div>

            <button type="submit" class="bg-burgundy hover:bg-burgundy-light text-white font-bold py-3.5 px-4 rounded-2xl w-full transition-all shadow-md text-sm tracking-wide mb-4">
                Lanjutkan Pembayaran
            </button>

            <div class="text-center pt-2">
                <a href="{{ route('donation.dashboard') }}" class="text-xs text-olive hover:text-olive-light font-bold transition-colors">
                    Lihat Dashboard & Daftar Donatur &rarr;
                </a>
            </div>
        </form>
    </div>

</body>
</html>