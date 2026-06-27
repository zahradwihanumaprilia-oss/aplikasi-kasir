<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Smart Kasir</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        <div class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between border-r border-slate-800">
            <div>
                <div class="p-5 text-xl font-bold text-white bg-slate-950 border-b border-slate-800 flex items-center">
                    <i class="fa-solid fa-cash-register mr-3 text-orange-500"></i>Smart Kasir
                </div>
                
                <nav class="p-4 space-y-1.5">
                    @if(Auth::user()->hasAnyRole(['admin', 'pimpinan']))
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white shadow-md shadow-orange-500/10' : 'hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-chart-pie w-6"></i>Dashboard Utama
                        </a>
                    @endif

                    @role('kasir')
                        <a href="{{ route('kasir.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 font-medium {{ request()->routeIs('kasir.dashboard') ? 'bg-orange-500 text-white shadow-md shadow-orange-500/10' : 'hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-chart-pie w-6"></i>Dashboard Kasir
                        </a>
                    @endrole

                    <div class="pt-4 pb-2 text-[10px] font-black text-slate-500 uppercase tracking-widest pl-4">Operasional</div>
                    <a href="{{ route('admin.produk.index') }}" class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 font-medium {{ request()->routeIs('admin.produk.*') ? 'bg-orange-500 text-white' : 'hover:bg-slate-800' }}">
                        <i class="fa-solid fa-box w-6"></i>Kelola Produk
                    </a>
                    <a href="{{ route('admin.pesanan.index') }}" class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 font-medium {{ request()->routeIs('admin.pesanan.*') ? 'bg-orange-500 text-white' : 'hover:bg-slate-800' }}">
                        <i class="fa-solid fa-clock-rotate-left w-6"></i>Riwayat Pesanan
                    </a>
                    <a href="{{ route('menu.index') }}" target="_blank" class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 font-medium text-orange-400 hover:bg-slate-800 border border-dashed border-orange-500/20">
                        <i class="fa-solid fa-qrcode w-6"></i>Menu Online
                    </a>

                    @if(Auth::user()->hasAnyRole(['admin', 'pimpinan']))
                        <div class="pt-4 pb-2 text-[10px] font-black text-slate-500 uppercase tracking-widest pl-4">Manajemen Sistem</div>
                        <a href="{{ route('admin.kategori.index') }}" class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 font-medium {{ request()->routeIs('admin.kategori.*') ? 'bg-orange-500 text-white' : 'hover:bg-slate-800' }}">
                            <i class="fa-solid fa-tags w-6"></i>Kelola Kategori
                        </a>
                        <a href="{{ route('admin.laporan.index') }}" class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 font-medium {{ request()->routeIs('admin.laporan.*') ? 'bg-orange-500 text-white' : 'hover:bg-slate-800' }}">
                            <i class="fa-solid fa-chart-line w-6"></i>Laporan Keuangan
                        </a>
                        <a href="{{ route('admin.user.index') }}" class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 font-medium {{ request()->routeIs('admin.user.*') ? 'bg-orange-500 text-white' : 'hover:bg-slate-800' }}">
                            <i class="fa-solid fa-users w-6"></i>Kelola User
                        </a>
                    @endif

                    @role('kasir')
                        <div class="pt-4 pb-2 text-[10px] font-black text-slate-500 uppercase tracking-widest pl-4">Antrian</div>
                        <a href="{{ route('kasir.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 font-medium {{ request()->routeIs('kasir.dashboard') ? 'bg-orange-500 text-white' : 'hover:bg-slate-800' }}">
                            <i class="fa-solid fa-receipt w-6"></i>Antrian Kasir
                        </a>
                    @endrole
                </nav>
            </div>

            <div class="p-4 bg-slate-950 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-400 hover:text-red-300 font-semibold text-sm flex items-center px-4 py-2 rounded-lg hover:bg-red-950/30 transition-all duration-200 cursor-pointer">
                        <i class="fa-solid fa-right-from-bracket w-6"></i>Keluar
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-grow flex flex-col overflow-y-auto">
            <header class="bg-white shadow-xs px-6 py-4 flex justify-between items-center border-b border-gray-100 sticky top-0 z-50">
                <h2 class="font-bold text-lg text-slate-800">@yield('header_title')</h2>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-700 leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mt-0.5">{{ Auth::user()->roles->first()?->name ?? 'User' }}</p>
                    </div>
                    <div class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                </div>
            </header>

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>