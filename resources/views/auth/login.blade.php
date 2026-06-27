<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Dapur Digital') }} — Masuk</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">

  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

  <style>
    :root {
      --ember: #C84B31;
      --gold:  #D4A853;
      --espresso: #1e110a;
      --cream: #F9F4EC;
    }
    body {
      font-family: 'Outfit', sans-serif;
      min-height: 100svh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f5f0e8;
      background-image:
        radial-gradient(ellipse 60% 50% at 15% 20%, rgba(200,75,49,.07) 0%, transparent 60%),
        radial-gradient(ellipse 50% 60% at 85% 80%, rgba(212,168,83,.07) 0%, transparent 55%);
      padding: 24px 16px;
    }
    .auth-card {
      display: flex;
      width: min(820px, 100%);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 24px 60px rgba(0,0,0,.14), 0 0 0 1px rgba(0,0,0,.06);
      background: #fff;
    }

    /* ── KIRI ── */
    .panel-form {
      flex: 1;
      padding: 40px 44px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .logo-wrap {
      display: flex; align-items: center; gap: 10px;
      margin-bottom: 28px;
    }
    .logo-icon {
      width: 34px; height: 34px; border-radius: 9px;
      background: var(--ember);
      display: flex; align-items: center; justify-content: center;
    }
    .logo-icon i { color: #fff; font-size: 17px; }
    .logo-text {
      font-family: 'Playfair Display', Georgia, serif;
      font-size: 18px; font-weight: 700;
      color: var(--espresso);
    }
    .logo-text span { color: var(--ember); }

    .tab-bar {
      display: flex;
      border: 1px solid #e5ddd5;
      border-radius: 9px;
      overflow: hidden;
      width: fit-content;
      margin-bottom: 24px;
    }
    .tab-btn {
      padding: 7px 22px;
      font-size: 12.5px; font-weight: 500;
      cursor: pointer; border: none;
      font-family: 'Outfit', sans-serif;
      transition: background .15s, color .15s;
    }
    .tab-btn.active { background: var(--espresso); color: var(--gold); }
    .tab-btn:not(.active) { background: transparent; color: #9a8478; }

    .form-title {
      font-family: 'Playfair Display', Georgia, serif;
      font-size: 28px; font-weight: 700; line-height: 1.2;
      color: var(--espresso); margin: 0 0 5px;
    }
    .form-title em { color: var(--ember); font-style: italic; }
    .form-sub {
      font-size: 12.5px; color: #9a8478;
      margin: 0 0 22px; line-height: 1.6;
    }

    .field-label {
      font-size: 10.5px; font-weight: 600;
      letter-spacing: .07em; text-transform: uppercase;
      color: #7a6a60; margin-bottom: 5px; display: block;
    }
    .field-wrap { position: relative; margin-bottom: 14px; }
    .field-input {
      width: 100%; padding: 10px 38px 10px 13px;
      border: 1.5px solid #e5ddd5;
      border-radius: 9px;
      font-size: 13.5px; font-family: 'Outfit', sans-serif;
      color: var(--espresso);
      background: #faf7f4;
      outline: none; transition: border-color .15s, box-shadow .15s;
      box-sizing: border-box;
    }
    .field-input::placeholder { color: #c0b3a8; }
    .field-input:focus {
      border-color: var(--ember);
      box-shadow: 0 0 0 3px rgba(200,75,49,.09);
      background: #fff;
    }
    .field-ico {
      position: absolute; right: 12px; top: 50%;
      transform: translateY(-50%);
      font-size: 16px; color: #c0b3a8; pointer-events: none;
    }

    .form-row {
      display: flex; justify-content: space-between;
      align-items: center; margin-bottom: 5px;
    }
    .forgot-link {
      font-size: 12px; color: var(--ember);
      font-weight: 500; text-decoration: none;
    }
    .forgot-link:hover { text-decoration: underline; }

    .check-row { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
    .check-row input { accent-color: var(--ember); width: 15px; height: 15px; }
    .check-row label { font-size: 12px; color: #9a8478; cursor: pointer; }

    .btn-primary {
      width: 100%; padding: 12px;
      border: none; border-radius: 9px;
      background: var(--espresso); color: var(--gold);
      font-family: 'Outfit', sans-serif;
      font-size: 13.5px; font-weight: 600;
      letter-spacing: .04em; cursor: pointer;
      transition: background .18s, transform .15s, box-shadow .18s;
      display: flex; align-items: center; justify-content: center; gap: 7px;
      margin-top: 8px;
    }
    .btn-primary:hover {
      background: var(--ember); color: #fff;
      box-shadow: 0 6px 18px rgba(200,75,49,.3);
      transform: translateY(-1px);
    }
    .btn-primary:active { transform: translateY(0); }

    .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    .field-select {
      width: 100%; padding: 10px 13px;
      border: 1.5px solid #e5ddd5; border-radius: 9px;
      font-size: 13.5px; font-family: 'Outfit', sans-serif;
      color: var(--espresso); background: #faf7f4;
      outline: none; box-sizing: border-box;
      margin-bottom: 14px;
    }
    .field-select:focus {
      border-color: var(--ember);
      box-shadow: 0 0 0 3px rgba(200,75,49,.09);
    }

    /* Error */
    .error-box {
      background: rgba(200,75,49,.07);
      border: 1px solid rgba(200,75,49,.25);
      border-radius: 8px; padding: 9px 13px;
      font-size: 12.5px; color: var(--ember);
      margin-bottom: 10px;
    }

    /* ── KANAN ── */
    .panel-hero {
      width: 310px; flex-shrink: 0;
      background: var(--espresso);
      padding: 32px 28px;
      display: flex; flex-direction: column;
      justify-content: space-between;
      position: relative; overflow: hidden;
      border-left: 1px solid rgba(255,255,255,.04);
    }
    .panel-hero::before {
      content: '';
      position: absolute; top: -90px; right: -90px;
      width: 260px; height: 260px; border-radius: 50%;
      background: rgba(200,75,49,.2); pointer-events: none;
    }
    .panel-hero::after {
      content: '';
      position: absolute; bottom: -70px; left: -70px;
      width: 220px; height: 220px; border-radius: 50%;
      background: rgba(212,168,83,.1); pointer-events: none;
    }

    .live-badge {
      display: inline-flex; align-items: center; gap: 6px;
      border: 1px solid rgba(212,168,83,.3);
      border-radius: 20px; padding: 4px 11px;
      font-size: 9.5px; font-weight: 700; letter-spacing: .1em;
      text-transform: uppercase; color: var(--gold);
      margin-bottom: 16px; width: fit-content;
    }
    .live-dot {
      width: 5px; height: 5px; border-radius: 50%; background: #4ade80;
      animation: pdot 1.5s ease-in-out infinite;
    }
    @keyframes pdot { 0%,100%{opacity:1} 50%{opacity:.25} }

    .hero-title {
      font-family: 'Playfair Display', Georgia, serif;
      font-size: 23px; font-weight: 700; line-height: 1.3;
      color: var(--cream); margin: 0 0 9px;
    }
    .hero-title em { color: var(--gold); font-style: italic; }
    .hero-desc {
      font-size: 12px; line-height: 1.7;
      color: rgba(249,244,236,.42); margin: 0;
    }

    .dish-art {
      text-align: center;
      animation: flt 3.5s ease-in-out infinite;
      position: relative; z-index: 1; margin: 4px 0;
      display: flex; justify-content: center;
    }
    @keyframes flt { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }

    .stats-grid {
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 8px; position: relative; z-index: 1;
    }
    .stat-card {
      background: rgba(255,255,255,.055);
      border: 1px solid rgba(255,255,255,.08);
      border-radius: 11px; padding: 10px 12px;
    }
    .stat-lbl {
      font-size: 9px; color: rgba(249,244,236,.35);
      text-transform: uppercase; letter-spacing: .06em; margin-bottom: 4px;
    }
    .stat-val {
      font-family: 'Playfair Display', Georgia, serif;
      font-size: 17px; font-weight: 700; color: var(--cream);
    }
    .stat-val.gold   { color: var(--gold); }
    .stat-val.orange { color: #fb923c; }
    .stat-note { font-size: 9.5px; color: rgba(249,244,236,.28); margin-top: 2px; }
    .stat-note.green  { color: #4ade80; }
    .stat-note.orange { color: #fb923c; }

    .hero-footer {
      display: flex; justify-content: space-between;
      padding-top: 12px; border-top: 1px solid rgba(255,255,255,.06);
      font-size: 10px; color: rgba(249,244,236,.22);
      position: relative; z-index: 1;
    }

    /* Dark mode */
    @media (prefers-color-scheme: dark) {
      body         { background: #141010; }
      .auth-card   { background: #1c1310; box-shadow: 0 24px 60px rgba(0,0,0,.4), 0 0 0 1px rgba(255,255,255,.05); }
      .panel-form  { background: #1c1310; }
      .tab-bar     { border-color: rgba(255,255,255,.08); }
      .tab-btn:not(.active) { color: #7a6a60; }
      .field-input, .field-select { background: #261a14; border-color: rgba(255,255,255,.1); color: var(--cream); }
      .field-input::placeholder { color: #5a4a40; }
      .form-title  { color: var(--cream); }
      .field-label { color: #9a8478; }
    }

    /* Mobile */
    @media (max-width: 680px) {
      .panel-hero  { display: none; }
      .panel-form  { padding: 36px 28px; }
      .auth-card   { border-radius: 20px; }
    }
  </style>
</head>
<body>

<div class="auth-card">

  <!-- PANEL KIRI -->
  <div class="panel-form">

    <div class="logo-wrap">
      <div class="logo-icon"><i class="ti ti-chef-hat"></i></div>
      <span class="logo-text">Dapur<span>Digital</span></span>
    </div>

    <div class="tab-bar">
      <button class="tab-btn active" id="btn-login" onclick="switchTab('login')">Masuk</button>
      <button class="tab-btn"        id="btn-reg"   onclick="switchTab('reg')">Daftar Baru</button>
    </div>

    <!-- FORM LOGIN -->
    <div id="form-login">
      <h1 class="form-title">Selamat Datang<br><em>Kembali</em></h1>
      <p class="form-sub">Masuk untuk mengelola operasional restoran Anda.</p>

      @if ($errors->any())
      <div class="error-box"><i class="ti ti-alert-circle"></i> {{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <label class="field-label">Alamat Email</label>
        <div class="field-wrap">
          <input type="email" name="email" class="field-input"
                 value="{{ old('email') }}" placeholder="chef@rumahmakanku.com" required>
          <i class="ti ti-mail field-ico"></i>
        </div>

        <div class="form-row">
          <label class="field-label" style="margin:0;">Kata Sandi</label>
          <a href="{{ route('password.request') }}" class="forgot-link">Lupa sandi?</a>
        </div>
        <div class="field-wrap" style="margin-top:5px;">
          <input type="password" name="password" id="pwd-in" class="field-input"
                 placeholder="••••••••" required>
          <i class="ti ti-eye field-ico" style="pointer-events:auto;cursor:pointer;"
             onclick="var i=document.getElementById('pwd-in');i.type=i.type==='password'?'text':'password';"></i>
        </div>

        <div class="check-row">
          <input type="checkbox" name="remember" id="remember">
          <label for="remember">Ingat saya di perangkat ini</label>
        </div>

        <button type="submit" class="btn-primary">
          <i class="ti ti-login"></i> Masuk ke Dashboard
        </button>
      </form>
    </div>

    <!-- FORM REGISTER -->
    <div id="form-reg" style="display:none;">
      <h1 class="form-title">Buat Akun<br><em>Baru</em></h1>
      <p class="form-sub">Daftarkan kasir, koki, atau manajer baru.</p>

      @if ($errors->any())
      <div class="error-box"><i class="ti ti-alert-circle"></i> {{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="grid2">
          <div>
            <label class="field-label">Nama Lengkap</label>
            <div class="field-wrap">
              <input type="text" name="name" class="field-input"
                     value="{{ old('name') }}" placeholder="Nama Anda" required>
              <i class="ti ti-user field-ico"></i>
            </div>
          </div>
          <div>
            <label class="field-label">Alamat Email</label>
            <div class="field-wrap">
              <input type="email" name="email" class="field-input"
                     value="{{ old('email') }}" placeholder="email@toko.com" required>
              <i class="ti ti-mail field-ico"></i>
            </div>
          </div>
          <div>
            <label class="field-label">Kata Sandi</label>
            <div class="field-wrap">
              <input type="password" name="password" class="field-input"
                     placeholder="Min. 8 karakter" style="padding-right:13px;" required>
            </div>
          </div>
          <div>
            <label class="field-label">Konfirmasi</label>
            <div class="field-wrap">
              <input type="password" name="password_confirmation" class="field-input"
                     placeholder="Ulangi sandi" style="padding-right:13px;" required>
            </div>
          </div>
        </div>

        <label class="field-label">Peran Akun</label>
        <select name="role" class="field-select">
          <option value="kasir">Kasir</option>
          <option value="koki">Koki / Dapur</option>
          <option value="manajer">Manajer</option>
          <option value="owner">Pemilik</option>
        </select>

        <button type="submit" class="btn-primary" style="background:var(--ember);color:#fff;">
          <i class="ti ti-user-plus"></i> Daftarkan Akun
        </button>
      </form>
    </div>

  </div>

  <!-- PANEL KANAN -->
  <div class="panel-hero">
    <div style="position:relative;z-index:1;">
      <div class="live-badge"><span class="live-dot"></span> Live Monitor</div>
      <h2 class="hero-title">Kendali Penuh<br><em>Rumah Makan</em><br>di Satu Layar</h2>
      <p class="hero-desc">Pesanan, stok bahan, dan laporan pendapatan secara real-time.</p>
    </div>

    <div class="dish-art">
      <svg width="90" height="110" viewBox="0 0 90 115" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi tumpeng nusantara">
        <!-- piring -->
        <ellipse cx="45" cy="97" rx="42" ry="9" fill="#4a2e14" opacity=".5"/>
        <ellipse cx="45" cy="95" rx="42" ry="9" fill="#6b4228"/>
        <ellipse cx="45" cy="93" rx="38" ry="7" fill="#7d5030"/>
        <!-- nasi kuning kerucut -->
        <polygon points="45,8 8,90 82,90" fill="#F5C842"/>
        <!-- bayangan sisi kerucut -->
        <polygon points="45,8 8,90 24,90" fill="#D4A820" opacity=".4"/>
        <!-- lauk kiri: ayam goreng -->
        <ellipse cx="20" cy="87" rx="11" ry="7" fill="#C87234"/>
        <ellipse cx="20" cy="84" rx="8" ry="5" fill="#D98040"/>
        <!-- lauk kanan: telur balado -->
        <ellipse cx="70" cy="87" rx="11" ry="7" fill="#E24040"/>
        <ellipse cx="70" cy="84" rx="8" ry="5" fill="#F06050"/>
        <!-- lauk tengah: tempe -->
        <rect x="35" y="83" width="20" height="9" rx="3" fill="#C49A40"/>
        <!-- hiasan daun pandan di puncak -->
        <ellipse cx="37" cy="11" rx="7" ry="3" fill="#3d8a28" transform="rotate(-30,37,11)"/>
        <ellipse cx="53" cy="11" rx="7" ry="3" fill="#4da030" transform="rotate(30,53,11)"/>
        <circle cx="45" cy="7" r="4.5" fill="#C83030"/>
        <circle cx="45" cy="7" r="2" fill="#E05050"/>
      </svg>
    </div>

    <div style="position:relative;z-index:1;">
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-lbl">Omzet Hari Ini</div>
          <div class="stat-val gold">Rp 4,8Jt</div>
          <div class="stat-note green">↑ 12% vs kemarin</div>
        </div>
        <div class="stat-card">
          <div class="stat-lbl">Pesanan Aktif</div>
          <div class="stat-val">24 Meja</div>
          <div class="stat-note orange">3 antrian dapur</div>
        </div>
        <div class="stat-card">
          <div class="stat-lbl">Stok Menipis</div>
          <div class="stat-val orange">7 Bahan</div>
          <div class="stat-note">Perlu restock segera</div>
        </div>
        <div class="stat-card">
          <div class="stat-lbl">Rating Hari Ini</div>
          <div class="stat-val gold">4.9 ★</div>
          <div class="stat-note">dari 47 ulasan</div>
        </div>
      </div>
      <div class="hero-footer">
        <span>Laravel 12 · MySQL</span>
        <span>v1.0.0</span>
      </div>
    </div>
  </div>

</div>

<script>
function switchTab(tab) {
  document.getElementById('form-login').style.display = tab === 'login' ? '' : 'none';
  document.getElementById('form-reg').style.display   = tab === 'reg'   ? '' : 'none';
  document.getElementById('btn-login').className = 'tab-btn ' + (tab === 'login' ? 'active' : '');
  document.getElementById('btn-reg').className   = 'tab-btn ' + (tab === 'reg'   ? 'active' : '');
}
@if(old('_form') === 'register' || $errors->has('name'))
  switchTab('reg');
@endif
</script>
</body>
</html>