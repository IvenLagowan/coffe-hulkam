<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna — Hulkam Caffe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--bg:#F7EAD9;--bg-sec:#F0DCC8;--surface:#fff;--primary:#E8935A;--primary-dark:#D07A42;--sage:#7C8A5C;--brown:#3A2A1D;--text:#2A2119;--muted:#7A6355;--border:rgba(42,33,25,0.10);--shadow:0 10px 40px rgba(42,33,25,0.1);--pill:9999px;--card:24px;--trans:all 0.3s cubic-bezier(0.4,0,0.2,1);}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);}
        a{text-decoration:none;color:inherit;}
        /* NAV */
        .top-nav{background:var(--brown);padding:0 24px;position:sticky;top:0;z-index:50;}
        .top-nav-inner{max-width:900px;margin-inline:auto;height:62px;display:flex;align-items:center;justify-content:space-between;}
        .nav-brand{font-family:'Playfair Display',serif;font-weight:700;font-size:18px;color:#F7EAD9;display:flex;align-items:center;gap:10px;}
        .nav-brand .bi{width:30px;height:30px;background:var(--primary);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;}
        .nav-links{display:flex;gap:6px;}
        .nav-links a{font-size:13px;font-weight:500;color:rgba(247,234,217,0.7);padding:7px 14px;border-radius:8px;transition:var(--trans);}
        .nav-links a:hover{color:#F7EAD9;background:rgba(255,255,255,0.08);}
        /* HERO */
        .profil-hero{background:linear-gradient(to bottom,var(--brown) 0%,rgba(58,42,29,0.95) 100%);color:#F7EAD9;padding:60px 24px 80px;text-align:center;}
        .profil-title{font-family:'Playfair Display',serif;font-size:32px;font-weight:700;margin-bottom:8px;}
        .profil-sub{font-size:14px;color:rgba(247,234,217,0.6);}
        /* CARD */
        .profil-wrap{max-width:600px;margin-inline:auto;padding:0 24px;margin-top:-40px;}
        .profil-card{background:var(--surface);border-radius:var(--card);padding:40px;border:1px solid var(--border);box-shadow:var(--shadow);text-align:center;}
        .avatar{width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;font-size:32px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;box-shadow:0 8px 24px rgba(232,147,90,0.3);}
        .user-name{font-family:'Playfair Display',serif;font-size:24px;font-weight:700;color:var(--brown);margin-bottom:4px;}
        .user-email{font-size:14px;color:var(--muted);margin-bottom:24px;}
        /* INFO LIST */
        .info-list{text-align:left;border-top:1px dashed var(--border);padding-top:24px;}
        .info-item{display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid rgba(42,33,25,0.05);}
        .info-item:last-child{border-bottom:none;}
        .info-label{font-size:13px;font-weight:600;color:var(--muted);}
        .info-val{font-size:14px;font-weight:600;color:var(--brown);}
        .role-badge{background:rgba(124,138,92,0.12);color:var(--sage);padding:4px 12px;border-radius:var(--pill);font-size:12px;text-transform:uppercase;letter-spacing:0.05em;}
        /* ACTIONS */
        .actions{margin-top:32px;display:flex;flex-direction:column;gap:12px;}
        .btn-logout{width:100%;padding:14px;background:rgba(200,80,60,0.08);color:#b84030;border:1px solid rgba(200,80,60,0.2);border-radius:var(--pill);font-size:14px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;transition:var(--trans);display:flex;align-items:center;justify-content:center;gap:8px;}
        .btn-logout:hover{background:#b84030;color:#fff;}
        /* FOOTER */
        .footer{background:var(--brown);color:rgba(247,234,217,0.5);text-align:center;padding:32px 24px;font-size:13px;margin-top:80px;}
    </style>
    <style>
        /* ===== KedaiSeduh Premium Dark override ===== */
        :root{--bg:#0E0B09;--bg-sec:#17110B;--bg-secondary:#17110B;--surface:#1B140E;--primary:#E0A263;--primary-dark:#C8894A;--sage:#93A56B;--brown:#F1E7D9;--text:#E9DECF;--muted:#A08E7B;--text-muted:#A08E7B;--border:rgba(224,178,122,0.14);--shadow:0 18px 45px rgba(0,0,0,0.45);}
        body{background-color:#0E0B09 !important;color:#E9DECF;}
        .top-nav,.footer{background:#100C08 !important;}
        .profil-hero{background:#100C08 !important;}
        ::selection{background:#E0A263;color:#1B140E;}
        input,select,textarea{background:#17110B;color:#E9DECF;border-color:rgba(224,178,122,0.18);}
    </style>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-inner">
            <a href="{{ url('/') }}" class="nav-brand">
                <div class="bi"><i class="fas fa-coffee"></i></div>
                Caffe Hulkam
            </a>
            <div class="nav-links">
                <a href="{{ url('/') }}"><i class="fas fa-home" style="margin-right:4px;"></i>Home</a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.admin-dashboard') }}"><i class="fas fa-user-shield" style="margin-right:4px;"></i>Admin</a>
                @elseif(Auth::user()->role === 'vendor')
                    <a href="{{ route('vendor.dashboard') }}"><i class="fas fa-store-alt" style="margin-right:4px;"></i>Vendor</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="profil-hero">
        <h1 class="profil-title">Profil Pengguna</h1>
        <p class="profil-sub">Kelola informasi akun Anda</p>
    </div>

    <div class="profil-wrap">
        <div class="profil-card">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-email">{{ Auth::user()->email }}</div>

            <div class="info-list">
                <div class="info-item">
                    <span class="info-label">Role Akun</span>
                    <span class="role-badge">{{ Auth::user()->role }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Bergabung</span>
                    <span class="info-val">{{ Auth::user()->created_at ? Auth::user()->created_at->format('d M Y') : '-' }}</span>
                </div>
            </div>

            <div class="actions">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Keluar dari Akun (Logout)
                    </button>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer">
        &copy; {{ date('Y') }} Hulkam Caffe. All rights reserved.
    </footer>
</body>
</html>
