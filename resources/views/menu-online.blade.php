<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Menu Online - Smart Kasir</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scroll-bar-width: none; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen pb-24">

    <header class="bg-gradient-to-r from-[#1B5E20] to-[#43A047] text-white p-5 rounded-b-3xl shadow-md">
        <div class="max-w-md mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-lg font-black tracking-tight flex items-center gap-2">
                    <i class="fa-solid fa-store text-emerald-200"></i> Smart Cafe & Resto
                </h1>
                <p class="text-xs text-emerald-100 mt-0.5 font-medium">Silakan pilih menu & pesan langsung dari meja</p>
            </div>
            <div class="bg-white/20 px-3 py-1.5 rounded-full text-xs font-bold border border-white/10 backdrop-blur-xs">
                📍 Meja Online
            </div>
        </div>
    </header>

    <main class="max-w-md mx-auto p-4 space-y-4">
        <div class="space-y-2 sticky top-0 bg-slate-50 py-2 z-40">
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest pl-1 block">Pilih Kategori</span>
            <div class="flex gap-2 overflow-x-auto no-scrollbar pb-1 w-full snap-x">
                <button onclick="filterKategori('semua')" id="btn-cat-semua" class="cat-btn snap-center shrink-0 text-xs font-bold bg-[#1B5E20] text-white px-4 py-2.5 rounded-full shadow-xs border border-emerald-800/20 transition-all cursor-pointer">
                    ✨ Semua Menu
                </button>
                @php $kategoriUnik = $produks->pluck('category')->unique('id')->filter(); @endphp
                @foreach($kategoriUnik as $kat)
                    <button onclick="filterKategori('{{ $kat->id }}')" id="btn-cat-{{ $kat->id }}" class="cat-btn snap-center shrink-0 text-xs font-bold bg-white text-slate-500 hover:text-slate-800 px-4 py-2.5 rounded-full shadow-xs border border-gray-100 transition-all cursor-pointer">
                        <i class="fa-solid {{ $kat->ikon ?? 'fa-tags' }} mr-1.5 text-slate-400"></i>{{ $kat->nama }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="space-y-3 mt-2">
            <h3 class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest pl-1">Daftar Menu Tersedia</h3>
            @forelse($produks as $produk)
                <div class="product-card bg-white p-4 rounded-2xl border border-gray-100 shadow-xs flex gap-4 items-center {{ ($produk->stok ?? 0) <= 0 || !$produk->tersedia ? 'opacity-65' : '' }}" data-kategori="{{ $produk->kategori_id }}">
                    <div class="w-20 h-20 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 border border-gray-100 relative">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Menu" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 text-xl"><i class="fa-solid fa-utensils"></i></div>
                        @endif
                        @if(($produk->stok ?? 0) <= 0 || !$produk->tersedia)
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <span class="text-[10px] font-black text-white bg-red-600 px-1.5 py-0.5 rounded-sm uppercase tracking-wider">Kosong</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow space-y-1">
                        <span class="text-[9px] font-black bg-[#E8F5E9] text-[#43A047] px-2 py-0.5 rounded-sm uppercase tracking-wide">{{ $produk->category ? $produk->category->nama : 'Menu' }}</span>
                        <h4 class="font-extrabold text-slate-800 text-xs sm:text-sm tracking-tight mt-1">{{ $produk->nama }}</h4>
                        <p class="text-[10px] text-gray-400 line-clamp-1 font-medium">{{ $produk->deskripsi ?? 'Menu lezat siap saji hangat.' }}</p>
                        <div class="flex justify-between items-center pt-1">
                            <span class="text-xs font-black text-[#1B5E20]">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</span>
                            <div class="flex items-center">
                                @if(($produk->stok ?? 0) > 0 && $produk->tersedia)
                                    <button onclick="ubahPorsi('{{ $produk->id }}', -1, {{ $produk->harga_jual ?? 0 }}, {{ $produk->stok }})" id="btn-minus-{{ $produk->id }}" class="hidden w-7 h-7 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg items-center justify-center cursor-pointer"><i class="fa-solid fa-minus text-[10px]"></i></button>
                                    <span id="qty-{{ $produk->id }}" class="hidden px-2.5 text-xs font-extrabold text-slate-800 min-w-6 text-center">0</span>
                                    <button onclick="ubahPorsi('{{ $produk->id }}', 1, {{ $produk->harga_jual ?? 0 }}, {{ $produk->stok }})" id="btn-add-{{ $produk->id }}" class="text-[11px] font-extrabold bg-[#E8F5E9] text-[#43A047] hover:bg-[#43A047] hover:text-white px-3 py-1 rounded-xl border border-emerald-100 cursor-pointer"><i class="fa-solid fa-plus mr-1"></i>Tambah</button>
                                @else
                                    <span class="text-[10px] font-bold bg-slate-100 text-slate-400 border border-slate-200 px-3 py-1 rounded-xl cursor-not-allowed">❌ Habis</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 rounded-2xl border border-gray-100 text-center text-gray-400">
                    <i class="fa-solid fa-mug-hot text-2xl mb-2 text-slate-200 block"></i>
                    <span class="text-xs font-medium">Belum ada menu masakan.</span>
                </div>
            @endforelse
        </div>
    </main>

    <div class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-gray-100 px-5 py-3.5 shadow-xl z-40">
        <div class="max-w-md mx-auto flex justify-between items-center">
            <div class="text-left">
                <span class="text-[9px] text-gray-400 font-extrabold uppercase tracking-widest block">Total Pembayaran</span>
                <span id="total-items-label" class="text-xs font-medium text-slate-500 block">0 Porsi Menu</span>
                <span id="total-price-label" class="text-sm font-black text-[#1B5E20]">Rp 0</span>
            </div>
            <button onclick="prosesCheckoutAkhir()" id="btn-checkout" class="bg-gray-300 text-gray-500 text-xs font-extrabold py-3 px-6 rounded-xl shadow-xs transition-all duration-200 active:scale-95 inline-flex items-center justify-center min-w-[140px]">
                <span id="btn-content" class="inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-basket-shopping"></i> Lanjut Bayar
                </span>
            </button>
        </div>
    </div>

    <script>
        let globalTotalQty = 0; let globalTotalPrice = 0; const keranjangMenu = {};

        function resetTombol() {
            const btn = document.getElementById('btn-checkout');
            const btnContent = document.getElementById('btn-content');
            btn.disabled = false;
            btn.classList.remove('opacity-80');
            btnContent.innerHTML = '<i class="fa-solid fa-basket-shopping"></i> Lanjut Bayar';
        }

        function ubahPorsi(produkId, arah, harga, maxStok) {
            if (!keranjangMenu[produkId]) keranjangMenu[produkId] = 0;
            if (arah === 1 && keranjangMenu[produkId] >= maxStok) {
                alert(`Maaf, stok hanya tersisa ${maxStok} porsi.`);
                return;
            }
            keranjangMenu[produkId] += arah;
            const currentQty = keranjangMenu[produkId];

            const btnAdd = document.getElementById('btn-add-' + produkId);
            const btnMinus = document.getElementById('btn-minus-' + produkId);
            const spanQty = document.getElementById('qty-' + produkId);

            if (currentQty > 0) {
                btnAdd.innerHTML = "<i class='fa-solid fa-plus text-[10px]'></i>";
                btnMinus.classList.remove('hidden'); btnMinus.classList.add('flex');
                spanQty.classList.remove('hidden'); spanQty.innerText = currentQty;
            } else {
                delete keranjangMenu[produkId];
                btnMinus.classList.add('hidden');
                spanQty.classList.add('hidden');
                btnAdd.innerHTML = "<i class='fa-solid fa-plus mr-1'></i>Tambah";
            }

            globalTotalQty += arah;
            globalTotalPrice += (arah * harga);
            document.getElementById('total-items-label').innerText = globalTotalQty + " Porsi Menu Terpilih";
            document.getElementById('total-price-label').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(globalTotalPrice);

            const btnCheckout = document.getElementById('btn-checkout');
            if (globalTotalQty > 0) {
                btnCheckout.classList.remove('bg-gray-300', 'text-gray-500');
                btnCheckout.classList.add('bg-gradient-to-r', 'from-[#1B5E20]', 'to-[#43A047]', 'text-white', 'shadow-md');
            } else {
                btnCheckout.classList.add('bg-gray-300', 'text-gray-500');
                btnCheckout.classList.remove('bg-gradient-to-r', 'from-[#1B5E20]', 'to-[#43A047]', 'text-white', 'shadow-md');
            }
        }

        function filterKategori(kategoriId) {
            document.querySelectorAll('.cat-btn').forEach(btn => {
                btn.classList.remove('bg-[#1B5E20]', 'text-white');
                btn.classList.add('bg-white', 'text-slate-500');
            });
            const activeBtn = document.getElementById('btn-cat-' + kategoriId);
            if (activeBtn) {
                activeBtn.classList.remove('bg-white', 'text-slate-500');
                activeBtn.classList.add('bg-[#1B5E20]', 'text-white');
            }
            document.querySelectorAll('.product-card').forEach(card => {
                card.style.display = (kategoriId === 'semua' || card.getAttribute('data-kategori') === kategoriId) ? 'flex' : 'none';
            });
        }

        function prosesCheckoutAkhir() {
            if (globalTotalPrice <= 0) { alert("Silakan pilih menu terlebih dahulu!"); return; }

            const btn = document.getElementById('btn-checkout');
            const btnContent = document.getElementById('btn-content');
            
            btn.disabled = true; 
            btn.classList.add('opacity-80');
            btnContent.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

            fetch(window.location.origin + "/menu/checkout-sistem", {
                method: "POST",
                headers: { 
                    "Content-Type": "application/json", 
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content 
                },
                body: JSON.stringify({ 
                    total_harga: globalTotalPrice, 
                    items: keranjangMenu 
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: () => window.location.href = window.location.origin + "/pesanan/struk/" + data.order_id_real,
                        onPending: () => { alert("Menunggu pembayaran!"); resetTombol(); },
                        onError: () => { alert("Pembayaran Gagal!"); resetTombol(); },
                        onClose: () => { alert("Pembayaran dibatalkan."); resetTombol(); }
                    });
                } else {
                    alert("Error: " + data.message);
                    resetTombol();
                }
            })
            .catch(err => {
                console.error(err);
                alert("Kesalahan koneksi! Pastikan server aktif.");
                resetTombol();
            });
        }
    </script>
</body>
</html>