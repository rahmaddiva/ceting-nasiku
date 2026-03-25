<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CETING NASIKU') — Panduan Resep Gizi Seimbang</title>
    <meta name="description" content="@yield('meta_description', 'CETING NASIKU - Panduan resep makanan bergizi seimbang untuk mencegah stunting pada anak.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="container navbar-content">
            <a href="/" class="navbar-brand">
                <div class="brand-icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <div>
                    <span class="brand-name">CETING NASIKU</span>
                    <span class="brand-tagline" title="Cegah Stunting Melalui Pemenuhan Gizi untuk Keluarga Unggul">Cegah Stunting Melalui Pemenuhan Gizi untuk Keluarga Unggul</span>
                </div>
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
                @auth
                @if(auth()->user()->isAdmin())
                <li><a href="/admin" class="btn btn-sm btn-accent"><i class="fas fa-cog"></i> Admin</a></li>
                @endif
                <li>
                    <form action="/logout" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline">Keluar</button>
                    </form>
                </li>
                @else
                <li><a href="/login" class="btn btn-sm btn-primary"><i class="fas fa-sign-in-alt"></i> Masuk</a></li>
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
                        <i class="fas fa-seedling"></i>
                        <span>CETING NASIKU</span>
                    </div>
                    <p>Panduan resep makanan bergizi seimbang untuk mencegah stunting dan mendukung tumbuh kembang anak Indonesia.</p>
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
                <div class="footer-links">
                    <h4>Tentang</h4>
                    <ul>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>Kontak</h4>
                    <p><i class="fas fa-envelope"></i> info@cetingnasiku.com</p>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
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
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: #fff;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 6px 24px rgba(46,204,113,.45);
            z-index: 9999;
            transition: transform .25s, box-shadow .25s;
        }
        #chatbot-fab:hover { transform: scale(1.1); box-shadow: 0 8px 32px rgba(46,204,113,.6); }
        #chatbot-fab .chatbot-badge {
            position: absolute;
            top: -4px; right: -4px;
            background: #e74c3c;
            color: #fff;
            font-size: .6rem;
            font-weight: 700;
            width: 18px; height: 18px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            animation: pulse-badge 1.8s infinite;
        }
        @keyframes pulse-badge {
            0%,100% { transform: scale(1); }
            50% { transform: scale(1.25); }
        }

        /* ---- Chat Panel ---- */
        #chatbot-panel {
            position: fixed;
            bottom: 100px;
            right: 28px;
            width: 370px;
            max-width: calc(100vw - 32px);
            height: 520px;
            max-height: calc(100vh - 120px);
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 16px 60px rgba(0,0,0,.18);
            display: flex;
            flex-direction: column;
            z-index: 9998;
            overflow: hidden;
            transform: translateY(20px) scale(.96);
            opacity: 0;
            pointer-events: none;
            transition: transform .3s cubic-bezier(.34,1.56,.64,1), opacity .25s;
        }
        #chatbot-panel.open {
            transform: translateY(0) scale(1);
            opacity: 1;
            pointer-events: all;
        }

        /* Header */
        .cb-header {
            background: linear-gradient(135deg, #2ecc71, #1a7a45);
            color: #fff;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }
        .cb-header-avatar {
            width: 42px; height: 42px;
            background: rgba(255,255,255,.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .cb-header-info { flex: 1 1 auto; }
        .cb-header-info strong { display: block; font-size: .92rem; font-family: 'Poppins',sans-serif; }
        .cb-header-info span { font-size: .72rem; opacity: .85; }
        .cb-header-close {
            background: rgba(255,255,255,.15);
            border: none;
            color: #fff;
            width: 32px; height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background .2s;
            flex-shrink: 0;
        }
        .cb-header-close:hover { background: rgba(255,255,255,.3); }

        /* Messages */
        .cb-messages {
            flex: 1 1 auto;
            overflow-y: auto;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: #f8fdf9;
        }
        .cb-messages::-webkit-scrollbar { width: 4px; }
        .cb-messages::-webkit-scrollbar-thumb { background: #c3e6cb; border-radius: 2px; }

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
            from { opacity:0; transform: translateY(6px); }
            to   { opacity:1; transform: translateY(0); }
        }
        .cb-msg.bot {
            background: #fff;
            border: 1px solid #e8f5e9;
            border-bottom-left-radius: 4px;
            align-self: flex-start;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
            color: #2d3436;
        }
        .cb-msg.user {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: #fff;
            border-bottom-right-radius: 4px;
            align-self: flex-end;
        }
        .cb-msg.bot ul, .cb-msg.bot ol { margin: 6px 0 0 16px; padding: 0; }
        .cb-msg.bot li { margin-bottom: 3px; }
        .cb-msg.bot p { margin: 4px 0; }

        /* Typing indicator */
        .cb-typing {
            display: flex; gap: 5px; align-items: center;
            padding: 10px 14px;
            background: #fff; border: 1px solid #e8f5e9;
            border-bottom-left-radius: 4px; border-radius: 18px;
            align-self: flex-start;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
        }
        .cb-typing span {
            width: 7px; height: 7px;
            background: #2ecc71;
            border-radius: 50%;
            animation: bounce-dot .9s infinite;
        }
        .cb-typing span:nth-child(2) { animation-delay: .15s; }
        .cb-typing span:nth-child(3) { animation-delay: .3s; }
        @keyframes bounce-dot {
            0%,80%,100% { transform: translateY(0); }
            40% { transform: translateY(-6px); }
        }

        /* Input area */
        .cb-footer {
            padding: 12px 14px;
            background: #fff;
            border-top: 1px solid #eaf7ed;
            display: flex;
            gap: 8px;
            align-items: flex-end;
            flex-shrink: 0;
        }
        #cb-input {
            flex: 1;
            border: 1.5px solid #c3e6cb;
            border-radius: 14px;
            padding: 9px 14px;
            font-size: .83rem;
            font-family: 'Poppins', sans-serif;
            resize: none;
            outline: none;
            transition: border-color .2s;
            max-height: 90px;
            overflow-y: auto;
            line-height: 1.5;
        }
        #cb-input:focus { border-color: #2ecc71; }
        #cb-send {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            border: none;
            color: #fff;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: .95rem;
            transition: transform .2s, box-shadow .2s;
            flex-shrink: 0;
        }
        #cb-send:hover { transform: scale(1.1); box-shadow: 0 4px 16px rgba(46,204,113,.4); }
        #cb-send:disabled { opacity: .5; transform: none; cursor: not-allowed; }

        /* Quick suggestions */
        .cb-suggestions {
            padding: 0 14px 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            background: #fff;
            flex-shrink: 0;
        }
        .cb-suggestion-btn {
            background: #eafaf1;
            border: 1px solid #c3e6cb;
            border-radius: 20px;
            padding: 5px 11px;
            font-size: .73rem;
            color: #1a7a45;
            cursor: pointer;
            transition: background .2s;
            font-family: 'Poppins',sans-serif;
        }
        .cb-suggestion-btn:hover { background: #c3e6cb; }
    </style>

    <!-- FAB Button -->
    <button id="chatbot-fab" title="Chat dengan NASI – Asisten Stunting" aria-label="Buka chatbot stunting">
        <i class="fas fa-robot"></i>
        <span class="chatbot-badge">AI</span>
    </button>

    <!-- Chat Panel -->
    <div id="chatbot-panel" role="dialog" aria-label="Chatbot NASI">
        <!-- Header -->
        <div class="cb-header">
            <div class="cb-header-avatar"><i class="fas fa-seedling"></i></div>
            <div class="cb-header-info">
                <strong>NASI – Asisten Stunting</strong>
                <span>Tanya seputar gizi, resep & pencegahan stunting</span>
            </div>
            <button class="cb-header-close" id="chatbot-close" aria-label="Tutup chatbot">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Messages -->
        <div class="cb-messages" id="cb-messages"></div>

        <!-- Quick suggestions (hidden after first send) -->
        <div class="cb-suggestions" id="cb-suggestions">
            <button class="cb-suggestion-btn" data-q="Resep MPASI bergizi untuk bayi 6 bulan?">🍼 MPASI bayi 6 bulan</button>
            <button class="cb-suggestion-btn" data-q="Apa itu stunting dan bagaimana mencegahnya?">❓ Apa itu stunting?</button>
            <button class="cb-suggestion-btn" data-q="Makanan tinggi protein yang murah untuk anak?">🥗 Protein murah</button>
            <button class="cb-suggestion-btn" data-q="Tips pola asuh anak agar tidak stunting?">👶 Pola asuh</button>
        </div>

        <!-- Input -->
        <div class="cb-footer">
            <textarea id="cb-input" rows="1" placeholder="Tanya tentang stunting, resep, gizi…" aria-label="Pesan chatbot"></textarea>
            <button id="cb-send" aria-label="Kirim pesan"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>

    <script>
    (function () {
        const fab       = document.getElementById('chatbot-fab');
        const panel     = document.getElementById('chatbot-panel');
        const closeBtn  = document.getElementById('chatbot-close');
        const msgBox    = document.getElementById('cb-messages');
        const input     = document.getElementById('cb-input');
        const sendBtn   = document.getElementById('cb-send');
        const suggestEl = document.getElementById('cb-suggestions');

        let history     = [];   // multi-turn conversation history
        let isOpen      = false;
        let isLoading   = false;
        let greeted     = false;

        // ---- Toggle panel ----
        function openPanel() {
            panel.classList.add('open');
            isOpen = true;
            fab.querySelector('.chatbot-badge').style.display = 'none';
            input.focus();
            if (!greeted) { greet(); greeted = true; }
        }
        function closePanel() {
            panel.classList.remove('open');
            isOpen = false;
        }
        fab.addEventListener('click', () => isOpen ? closePanel() : openPanel());
        closeBtn.addEventListener('click', closePanel);

        // ---- Greeting ----
        function greet() {
            appendMsg('bot', '👋 Halo! Saya <strong>NASI</strong>, asisten gizi dan pencegahan stunting dari <strong>CETING NASIKU</strong>.\n\nSilakan tanya apa saja seputar resep bergizi, pola makan, atau cara mencegah stunting. Saya siap membantu! 🌱');
        }

        // ---- Append message ----
        function appendMsg(role, text) {
            const div = document.createElement('div');
            div.className = 'cb-msg ' + role;
            if (role === 'bot') {
                // Render markdown-lite: bold, newlines, bullet points
                div.innerHTML = renderMarkdown(text);
            } else {
                div.textContent = text;
            }
            msgBox.appendChild(div);
            scrollBottom();
            return div;
        }

        function renderMarkdown(text) {
            return text
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/^[-•]\s+(.+)$/gm, '<li>$1</li>')
                .replace(/(<li>.*<\/li>)/gs, '<ul>$1</ul>')
                .replace(/\n{2,}/g, '</p><p>')
                .replace(/\n/g, '<br>')
                .replace(/^(.+)$/, '<p>$1</p>');
        }

        // ---- Typing indicator ----
        function showTyping() {
            const el = document.createElement('div');
            el.className = 'cb-typing';
            el.id = 'cb-typing';
            el.innerHTML = '<span></span><span></span><span></span>';
            msgBox.appendChild(el);
            scrollBottom();
        }
        function hideTyping() {
            const el = document.getElementById('cb-typing');
            if (el) el.remove();
        }

        function scrollBottom() {
            msgBox.scrollTop = msgBox.scrollHeight;
        }

        // ---- Send message ----
        async function sendMessage(text) {
            if (!text.trim() || isLoading) return;
            isLoading = true;
            sendBtn.disabled = true;
            suggestEl.style.display = 'none';

            appendMsg('user', text);
            input.value = '';
            input.style.height = 'auto';

            showTyping();

            try {
                const res = await fetch('{{ route("chatbot.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ message: text, history: history }),
                });

                const data = await res.json();
                hideTyping();

                if (data.error) {
                    appendMsg('bot', '⚠️ ' + data.error);
                } else {
                    const reply = data.reply || '(Tidak ada respons)';
                    appendMsg('bot', reply);

                    // Save to history for multi-turn
                    history.push({ role: 'user', content: text });
                    const assistantMsg = { role: 'assistant', content: reply };
                    if (data.reasoning_details) {
                        assistantMsg.reasoning_details = data.reasoning_details;
                    }
                    history.push(assistantMsg);

                    // Keep history bounded (last 20 turns = 10 pairs)
                    if (history.length > 20) history = history.slice(-20);
                }
            } catch (err) {
                hideTyping();
                appendMsg('bot', '⚠️ Koneksi bermasalah. Pastikan jaringan internet tersedia.');
                console.error('Chatbot error:', err);
            }

            isLoading = false;
            sendBtn.disabled = false;
            input.focus();
        }

        // ---- Event listeners ----
        sendBtn.addEventListener('click', () => sendMessage(input.value));

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage(this.value);
            }
        });

        // Auto-resize textarea
        input.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 90) + 'px';
        });

        // Quick suggestion buttons
        suggestEl.querySelectorAll('.cb-suggestion-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                if (!greeted) { greet(); greeted = true; }
                sendMessage(btn.dataset.q);
            });
        });
    })();
    </script>

    @stack('scripts')
</body>

</html>