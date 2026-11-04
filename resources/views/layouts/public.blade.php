<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CETING NASIKU') — Panduan Resep Gizi Seimbang</title>
    <meta name="description" content="@yield('meta_description', 'CETING NASIKU - Panduan resep makanan bergizi seimbang untuk mencegah stunting pada anak.')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon-192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="theme-color" content="#047857">
    <meta property="og:title" content="@yield('og_title', 'CETING NASIKU — Panduan Resep Gizi Seimbang')">
    <meta property="og:description" content="@yield('og_description', 'CETING NASIKU - Panduan resep makanan bergizi seimbang untuk mencegah stunting pada anak.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="CETING NASIKU">
    <meta property="og:locale" content="id_ID">
    @yield('og_image')
    @yield('structured_data')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&family=Noto+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) ?: '1' }}">
    @stack('styles')
</head>

<body class="@yield('body_class')">
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="container navbar-content">
            <a href="/" class="navbar-brand">
                <img src="{{ asset('images/ceting_nasiku-mark.png') }}" alt="CETING NASIKU Logo" class="navbar-logo navbar-logo-main">
                <img src="{{ asset('images/logo_dinas.png') }}" alt="Logo Dinas" class="navbar-logo navbar-logo-dinas">
            </a>

            <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>

            <ul class="navbar-menu" id="navbarMenu">
                <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}"><i class="fas fa-home"></i> Beranda</a></li>
                <li><a href="/resep" class="{{ request()->is('resep*') ? 'active' : '' }}"><i class="fas fa-utensils"></i> Resep</a></li>
                <li><a href="/stunting" class="{{ request()->is('stunting') ? 'active' : '' }}"><i class="fas fa-heart-pulse"></i> Cegah Stunting</a></li>
                <li><a href="/cek-risiko" class="{{ request()->is('cek-risiko') ? 'active' : '' }}"><i class="fas fa-clipboard-check"></i> Cek Risiko</a></li>
                <li><a href="/edukasi" class="{{ request()->is('edukasi*') ? 'active' : '' }}"><i class="fas fa-graduation-cap"></i> Edukasi</a></li>
                <li><a href="/kalkulator" class="{{ request()->is('kalkulator') ? 'active' : '' }}"><i class="fas fa-calculator"></i> Kalkulator Gizi</a></li>
                @guest
                <li><a href="{{ route('login') }}" class="btn btn-sm btn-accent navbar-login"><i class="fas fa-right-to-bracket"></i> Masuk</a></li>
                @endguest
                @auth
                <li><a href="{{ route('profil.index') }}" class="{{ request()->is('profil*') ? 'active' : '' }}"><i class="fas fa-child"></i> Pantau Tumbuh Kembang</a></li>
                @if(auth()->user()->isAdmin())
                <li><a href="/admin" class="btn btn-sm btn-accent"><i class="fas fa-cog"></i> Admin</a></li>
                @endif
                <li>
                    <form action="/logout" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline">Keluar</button>
                    </form>
                </li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
        <div class="container">
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="container">
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <div class="footer-brand">
                        <img src="{{ asset('images/ceting_nasiku.png') }}" alt="CETING NASIKU Logo" style="height: 50px; width: auto; object-fit: contain; margin-bottom: 10px;">
                    </div>
                    <p>
                        Panduan resep makanan bergizi seimbang untuk mencegah stunting dan mendukung tumbuh kembang anak Indonesia.
                        Lengkap dengan kalkulator gizi, cek risiko stunting, kurva pertumbuhan WHO, modul edukasi
                        pola asuh &amp; PHBS, serta asisten AI <strong>NASI</strong> yang siap menjawab pertanyaan gizi kapan saja.
                    </p>
                    <div class="footer-visits">
                        <span title="Total kunjungan sejak penghitung diaktifkan">
                            <i class="fas fa-users" aria-hidden="true"></i>
                            <strong>{{ number_format($visitStats['total'] ?? 0, 0, ',', '.') }}</strong> Total Pengunjung
                        </span>
                        <span>
                            <i class="fas fa-user-clock" aria-hidden="true"></i>
                            <strong>{{ number_format($visitStats['today'] ?? 0, 0, ',', '.') }}</strong> Hari Ini
                        </span>
                    </div>
                </div>
                <div class="footer-links">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="/">Beranda</a></li>
                        <li><a href="/resep">Koleksi Resep</a></li>
                        <li><a href="/stunting">Cegah Stunting</a></li>
                        <li><a href="/cek-risiko">Cek Risiko Stunting</a></li>
                        <li><a href="/edukasi">Modul Edukasi</a></li>
                        <li><a href="/kalkulator">Kalkulator Gizi</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} CETING NASIKU. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar toggle
        document.getElementById('navbarToggle').addEventListener('click', function() {
            document.getElementById('navbarMenu').classList.toggle('show');
            this.classList.toggle('active');
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
    {{-- ========================================================= --}}
    {{-- CHATBOT WIDGET - NASI (Narasumber Ahli Stunting Indonesia) --}}
    {{-- ========================================================= --}}
    <style>
        /* ---- Floating Button ---- */
        #chatbot-fab {
            position: fixed;
            bottom: 28px;
            right: 28px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: #fff;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 6px 24px rgba(8, 145, 178, .35);
            z-index: 9999;
            transition: transform .25s, box-shadow .25s;
        }

        #chatbot-fab:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 32px rgba(8, 145, 178, .5);
        }

        #chatbot-fab .chatbot-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--danger);
            color: #fff;
            font-size: .6rem;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse-badge 1.8s infinite;
        }

        @keyframes pulse-badge {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.25);
            }
        }

        /* ---- Chat Panel ---- */
        #chatbot-panel {
            position: fixed;
            bottom: 100px;
            right: 28px;
            width: 400px;
            max-width: calc(100vw - 32px);
            height: 620px;
            max-height: calc(100vh - 130px);
            background: #fff;
            border: 1px solid var(--primary-100);
            border-radius: 22px;
            box-shadow: 0 24px 70px rgba(15, 23, 42, .22), 0 2px 8px rgba(8, 145, 178, .08);
            display: flex;
            flex-direction: column;
            z-index: 9998;
            overflow: hidden;
            transform: translateY(20px) scale(.96);
            opacity: 0;
            pointer-events: none;
            transition: transform .3s cubic-bezier(.34, 1.56, .64, 1), opacity .25s;
        }

        #chatbot-panel.open {
            transform: translateY(0) scale(1);
            opacity: 1;
            pointer-events: all;
        }

        /* Header */
        .cb-header {
            background: var(--gradient-primary);
            color: #fff;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .cb-header-avatar {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, .2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .cb-header-info {
            flex: 1 1 auto;
        }

        .cb-header-info strong {
            display: block;
            font-size: .92rem;
            font-family: var(--font-body);
        }

        .cb-header-info span {
            font-size: .72rem;
            opacity: .85;
        }

        .cb-header-close {
            background: rgba(255, 255, 255, .15);
            border: none;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s;
            flex-shrink: 0;
        }

        .cb-header-close:hover {
            background: rgba(255, 255, 255, .3);
        }

        /* Bottom dock: live prompt strip above chips + input */
        .cb-dock {
            background: #fff;
            border-top: 1px solid var(--primary-100);
            flex-shrink: 0;
        }

        .cb-status {
            display: none;
            align-items: flex-start;
            gap: 8px;
            padding: 9px 14px;
            background: var(--primary-50);
            border-bottom: 1px solid var(--primary-100);
            font-size: .72rem;
            line-height: 1.45;
            color: var(--primary-800);
        }

        .cb-status.show {
            display: flex;
        }

        .cb-status i {
            font-size: .7rem;
            margin-top: 2px;
            color: var(--primary-600);
            animation: status-spin 1s linear infinite;
        }

        @keyframes status-spin {
            to {
                transform: rotate(360deg);
            }
        }

        .cb-status.show.failed {
            background: #fef2f2;
            border-bottom-color: #fecaca;
            color: #991b1b;
        }

        .cb-status.show.failed i {
            color: var(--danger);
            animation: none;
        }

        .cb-msg.bot.error {
            border-color: #fecaca;
            background: #fef2f2;
            color: #991b1b;
        }

        .cb-status-text {
            flex: 1 1 auto;
            min-width: 0;
        }

        .cb-status-text b {
            font-variant-numeric: tabular-nums;
            color: var(--primary-700);
        }

        .cb-status-prompt {
            display: block;
            margin-top: 3px;
            padding-left: 8px;
            border-left: 2px solid var(--primary-300);
            color: var(--gray-600);
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            word-break: break-word;
        }

        /* Messages */
        .cb-messages {
            flex: 1 1 auto;
            overflow-y: auto;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: var(--gray-50);
            scrollbar-width: thin;
            scrollbar-color: var(--primary-200) transparent;
        }

        .cb-messages::-webkit-scrollbar {
            width: 4px;
        }

        .cb-messages::-webkit-scrollbar-thumb {
            background: var(--primary-200);
            border-radius: 2px;
        }

        .cb-msg {
            max-width: 82%;
            padding: 10px 14px;
            border-radius: 18px;
            font-size: .83rem;
            line-height: 1.55;
            word-break: break-word;
            animation: msg-in .2s ease;
        }

        @keyframes msg-in {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cb-msg.bot {
            background: #fff;
            border: 1px solid var(--primary-100);
            border-bottom-left-radius: 4px;
            align-self: flex-start;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
            color: var(--gray-800);
        }

        .cb-msg.user {
            background: var(--gradient-primary);
            color: #fff;
            border-bottom-right-radius: 4px;
            align-self: flex-end;
        }

        .cb-msg.bot ul,
        .cb-msg.bot ol {
            margin: 6px 0 0 16px;
            padding: 0;
        }

        .cb-msg.bot li {
            margin-bottom: 3px;
        }

        .cb-msg.bot p {
            margin: 4px 0;
        }


        /* Input area */
        .cb-footer {
            padding: 12px 14px;
            background: #fff;
            border-top: 1px solid var(--primary-100);
            display: flex;
            gap: 8px;
            align-items: flex-end;
            flex-shrink: 0;
        }

        #cb-input {
            flex: 1;
            border: 1.5px solid var(--primary-200);
            border-radius: 14px;
            padding: 9px 14px;
            font-size: .83rem;
            font-family: var(--font-body);
            resize: none;
            outline: none;
            transition: border-color .2s;
            max-height: 90px;
            overflow-y: auto;
            line-height: 1.5;
        }

        #cb-input:focus {
            border-color: var(--primary-500);
        }

        #cb-send {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-primary);
            border: none;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .95rem;
            transition: transform .2s, box-shadow .2s;
            flex-shrink: 0;
        }

        #cb-send:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 16px rgba(8, 145, 178, .35);
        }

        #cb-send:disabled {
            opacity: .5;
            transform: none;
            cursor: not-allowed;
        }

        /* Quick suggestions */
        .cb-suggestions {
            padding: 8px 14px 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            background: #fff;
            flex-shrink: 0;
        }

        .cb-suggestion-btn {
            background: var(--primary-50);
            border: 1px solid var(--primary-200);
            border-radius: 20px;
            padding: 5px 11px;
            font-size: .73rem;
            color: var(--primary-700);
            cursor: pointer;
            transition: background .2s;
            font-family: var(--font-body);
        }

        .cb-suggestion-btn:disabled {
            opacity: .55;
            cursor: default;
        }

        .cb-suggestion-btn:hover {
            background: var(--primary-200);
        }
        .cb-online {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent-400);
            margin-right: 6px;
            vertical-align: middle;
        }

        #cb-input:focus-visible,
        #cb-send:focus-visible {
            outline: 2px solid var(--primary-400);
            outline-offset: 2px;
        }

        @media (max-width: 520px) {
            #chatbot-panel {
                bottom: 0;
                right: 0;
                width: 100vw;
                max-width: 100vw;
                height: 100dvh;
                max-height: 100dvh;
                border: none;
                border-radius: 0;
            }

            #chatbot-fab {
                bottom: 18px;
                right: 18px;
            }

            .cb-msg {
                max-width: 90%;
            }

            .cb-suggestions {
                overflow-x: auto;
                flex-wrap: nowrap;
                scrollbar-width: none;
            }

            .cb-suggestions::-webkit-scrollbar {
                display: none;
            }

            .cb-suggestion-btn {
                flex: 0 0 auto;
            }
        }

    </style>

    <!-- NASI Assistant -->
    <button id="chatbot-fab" type="button" title="Chat dengan NASI – Asisten Stunting" aria-label="Buka chatbot NASI" aria-controls="chatbot-panel" aria-expanded="false">
        <i class="fas fa-robot" aria-hidden="true"></i>
        <span class="chatbot-badge">AI</span>
    </button>

    <div id="chatbot-panel" role="dialog" aria-modal="false" aria-labelledby="cb-title">
        <div class="cb-header">
            <div class="cb-header-avatar"><i class="fas fa-seedling" aria-hidden="true"></i></div>
            <div class="cb-header-info">
                <strong id="cb-title">NASI – Asisten Stunting</strong>
                <span><i class="cb-online" aria-hidden="true"></i>Tanya seputar gizi, resep & pencegahan stunting</span>
            </div>
            <button type="button" class="cb-header-close" id="chatbot-close" aria-label="Tutup chatbot">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>

        <div class="cb-messages" id="cb-messages" role="log" aria-live="polite" aria-relevant="additions"></div>

        <div class="cb-dock">
            <!-- Live status: what NASI is doing with the prompt right now -->
            <div class="cb-status" id="cb-status" aria-hidden="true">
                <i class="fas fa-circle-notch" aria-hidden="true"></i>
                <div class="cb-status-text">
                    <span id="cb-status-label">Memproses…</span>
                    <b id="cb-status-time">0,0 dtk</b>
                    <span class="cb-status-prompt" id="cb-status-prompt"></span>
                </div>
            </div>

            <div class="cb-suggestions" id="cb-suggestions">
                <button type="button" class="cb-suggestion-btn" data-q="Resep MPASI bergizi untuk bayi 6 bulan?">🍼 MPASI bayi 6 bulan</button>
                <button type="button" class="cb-suggestion-btn" data-q="Apa itu stunting dan bagaimana mencegahnya?">❓ Apa itu stunting?</button>
                <button type="button" class="cb-suggestion-btn" data-q="Makanan tinggi protein yang murah untuk anak?">🥗 Protein murah</button>
                <button type="button" class="cb-suggestion-btn" data-q="Tips pola asuh anak agar tidak stunting?">👶 Pola asuh</button>
            </div>

            <div class="cb-footer">
                <textarea id="cb-input" rows="1" maxlength="2000" placeholder="Tanya tentang stunting, resep, gizi…" aria-label="Pesan untuk NASI"></textarea>
                <button type="button" id="cb-send" aria-label="Kirim pesan"><i class="fas fa-paper-plane" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const fab = document.getElementById('chatbot-fab');
            const panel = document.getElementById('chatbot-panel');
            const closeBtn = document.getElementById('chatbot-close');
            const msgBox = document.getElementById('cb-messages');
            const input = document.getElementById('cb-input');
            const sendBtn = document.getElementById('cb-send');
            const suggestEl = document.getElementById('cb-suggestions');
            const statusEl = document.getElementById('cb-status');
            const statusLabel = document.getElementById('cb-status-label');
            const statusTime = document.getElementById('cb-status-time');
            const statusPrompt = document.getElementById('cb-status-prompt');

            const ENDPOINT = @json(route('chatbot.send'));
            const MAX_TURNS = 10; // server juga memotong ke 10 pasangan

            let history = [];
            let isOpen = false;
            let isLoading = false;
            let greeted = false;
            let statusTimer = null;
            let statusStart = 0;

            // ---- Toggle panel ----
            function openPanel() {
                panel.classList.add('open');
                isOpen = true;
                fab.setAttribute('aria-expanded', 'true');
                fab.querySelector('.chatbot-badge').style.display = 'none';
                if (!greeted) {
                    greet();
                    greeted = true;
                }
                input.focus();
            }

            function closePanel() {
                panel.classList.remove('open');
                isOpen = false;
                fab.setAttribute('aria-expanded', 'false');
                fab.focus();
            }

            fab.addEventListener('click', () => (isOpen ? closePanel() : openPanel()));
            closeBtn.addEventListener('click', closePanel);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && isOpen) closePanel();
            });

            // ---- Messages ----
            function greet() {
                appendMsg('bot', '👋 Halo! Saya NASI, asisten gizi dan pencegahan stunting dari CETING NASIKU.\n\nSilakan tanya apa saja seputar resep bergizi, pola makan, atau cara mencegah stunting. Saya siap membantu! 🌱');
            }

            function appendMsg(role, text, isError) {
                const div = document.createElement('div');
                div.className = 'cb-msg ' + role + (isError ? ' error' : '');
                if (role === 'bot') {
                    div.append(...renderMarkdown(text));
                } else {
                    div.textContent = text;
                }
                msgBox.appendChild(div);
                scrollBottom();
                return div;
            }

            /*
             * Markdown-lite untuk balasan model, dibangun dari node DOM (bukan
             * innerHTML), jadi HTML di dalam teks AI tidak pernah dieksekusi.
             * Didukung: ## judul, **bold**, *miring*, `kode`, -/•/1. daftar.
             */
            function renderMarkdown(text) {
                const frag = document.createDocumentFragment();
                const inline = (str) => {
                    const nodes = [];
                    const re = /\*\*(.+?)\*\*|\*(.+?)\*|`([^`]+)`/g;
                    let last = 0, m;
                    while ((m = re.exec(str))) {
                        if (m.index > last) nodes.push(document.createTextNode(str.slice(last, m.index)));
                        if (m[1] !== undefined) {
                            const b = document.createElement('strong');
                            b.textContent = m[1];
                            nodes.push(b);
                        } else if (m[2] !== undefined) {
                            const em = document.createElement('em');
                            em.textContent = m[2];
                            nodes.push(em);
                        } else {
                            const code = document.createElement('code');
                            code.textContent = m[3];
                            nodes.push(code);
                        }
                        last = re.lastIndex;
                    }
                    if (last < str.length) nodes.push(document.createTextNode(str.slice(last)));
                    return nodes;
                };

                const lines = String(text).replace(/\r\n?/g, '\n').split('\n');
                let list = null;   // ul|ol yang sedang dibangun
                let para = [];     // baris paragraf terkumpul

                const flushPara = () => {
                    if (!para.length) return;
                    const p = document.createElement('p');
                    para.forEach((line, i) => {
                        if (i) p.appendChild(document.createElement('br'));
                        p.append(...inline(line));
                    });
                    frag.appendChild(p);
                    para = [];
                };
                const flushList = () => {
                    if (list) frag.appendChild(list);
                    list = null;
                };

                for (const raw of lines) {
                    const line = raw.trim();
                    if (!line) {
                        flushPara();
                        flushList();
                        continue;
                    }
                    const bullet = line.match(/^[-•*]\s+(.*)$/);
                    const number = line.match(/^\d+[.)]\s+(.*)$/);
                    const heading = line.match(/^#{1,4}\s+(.*)$/);

                    if (heading) {
                        flushPara();
                        flushList();
                        const h = document.createElement('p');
                        const strong = document.createElement('strong');
                        strong.textContent = heading[1].replace(/\*\*/g, '');
                        h.appendChild(strong);
                        frag.appendChild(h);
                        continue;
                    }
                    if (bullet || number) {
                        flushPara();
                        const tag = bullet ? 'UL' : 'OL';
                        if (!list || list.tagName !== tag) {
                            flushList();
                            list = document.createElement(tag);
                        }
                        const li = document.createElement('li');
                        li.append(...inline((bullet || number)[1]));
                        list.appendChild(li);
                        continue;
                    }
                    flushList();
                    para.push(line);
                }
                flushPara();
                flushList();
                return Array.from(frag.childNodes);
            }

            function scrollBottom() {
                msgBox.scrollTop = msgBox.scrollHeight;
            }

            // ---- Live status ----
            function fmt(sec) {
                return sec.toFixed(1).replace('.', ',') + ' dtk';
            }

            function startStatus(promptText) {
                statusStart = performance.now();
                statusLabel.textContent = 'Menganalisis pertanyaan…';
                statusTime.textContent = '0,0 dtk';
                statusPrompt.textContent = '“' + promptText.replace(/\s+/g, ' ').trim() + '”';
                statusEl.classList.add('show');
                statusEl.setAttribute('aria-hidden', 'false');

                clearInterval(statusTimer);
                statusTimer = setInterval(() => {
                    const s = (performance.now() - statusStart) / 1000;
                    statusTime.textContent = fmt(s);
                    if (s > 12) statusLabel.textContent = 'Menyusun jawaban bergizi…';
                    else if (s > 5) statusLabel.textContent = 'Mencari rujukan gizi…';
                }, 100);
            }

            function stopStatus(errorText) {
                clearInterval(statusTimer);
                statusTimer = null;
                if (errorText) {
                    const s = (performance.now() - statusStart) / 1000;
                    statusLabel.textContent = 'Gagal memproses';
                    statusTime.textContent = fmt(s);
                    statusEl.classList.add('show', 'failed');
                    return;
                }
                statusEl.classList.remove('show', 'failed');
                statusEl.setAttribute('aria-hidden', 'true');
            }

            // ---- Send ----
            function setBusy(busy) {
                isLoading = busy;
                sendBtn.disabled = busy;
                suggestEl.querySelectorAll('.cb-suggestion-btn').forEach(b => { b.disabled = busy; });
            }

            async function sendMessage(raw) {
                const text = raw.trim();
                if (!text || isLoading) return;

                setBusy(true);
                appendMsg('user', text);
                input.value = '';
                input.style.height = 'auto';
                startStatus(text);

                try {
                    const res = await fetch(ENDPOINT, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ message: text, history: history }),
                    });

                    let data = {};
                    try { data = await res.json(); } catch (_) { /* body bukan JSON */ }

                    if (!res.ok || data.error) {
                        const msg = data.error || (res.status === 429
                            ? 'Terlalu banyak permintaan. Tunggu sebentar lalu coba lagi.'
                            : 'Maaf, terjadi kesalahan. Silakan coba lagi.');
                        stopStatus(msg);
                        appendMsg('bot', '⚠️ ' + msg, true);
                    } else {
                        const reply = data.reply || '(Tidak ada respons)';
                        stopStatus();
                        appendMsg('bot', reply);
                        history.push({ role: 'user', content: text }, { role: 'assistant', content: reply });
                        if (history.length > MAX_TURNS * 2) history = history.slice(-MAX_TURNS * 2);
                    }
                } catch (err) {
                    const msg = 'Koneksi bermasalah. Pastikan jaringan internet tersedia.';
                    stopStatus(msg);
                    appendMsg('bot', '⚠️ ' + msg, true);
                    console.error('Chatbot error:', err);
                }

                setBusy(false);
                input.focus();
            }

            // ---- Events ----
            sendBtn.addEventListener('click', () => sendMessage(input.value));

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage(this.value);
                }
            });

            input.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 90) + 'px';
            });

            suggestEl.querySelectorAll('.cb-suggestion-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (!greeted) {
                        greet();
                        greeted = true;
                    }
                    sendMessage(btn.dataset.q);
                });
            });
        })();
    </script>

    @stack('scripts')
</body>

</html>