<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — CETING NASIKU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <style>
        /* DataTables shell */
        .data-table-wrapper { padding: 1rem 1.15rem 1.15rem; }
        .data-table-wrapper .dataTables_wrapper { width: 100%; }

        .dt-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 0.85rem;
        }
        .dt-toolbar-left,
        .dt-toolbar-right { display: flex; align-items: center; gap: 0.5rem; }

        .dt-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-top: 0.85rem;
            padding-top: 0.85rem;
            border-top: 1px solid var(--gray-100);
        }

        div.dataTables_wrapper div.dataTables_filter label,
        div.dataTables_wrapper div.dataTables_length label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin: 0;
        }
        div.dataTables_wrapper div.dataTables_filter input {
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            padding: 0.45rem 0.85rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            min-width: 200px;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        div.dataTables_wrapper div.dataTables_filter input:focus {
            border-color: var(--primary-500);
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.12);
        }
        div.dataTables_wrapper div.dataTables_length select {
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            padding: 0.4rem 0.6rem;
            font-size: 0.875rem;
            background: white;
        }
        div.dataTables_wrapper div.dataTables_info {
            font-size: 0.82rem;
            color: var(--text-muted);
            padding: 0;
        }

        /* Pagination pills */
        div.dataTables_wrapper div.dataTables_paginate {
            padding: 0;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        div.dataTables_wrapper div.dataTables_paginate .paginate_button {
            border-radius: 8px !important;
            min-width: 34px;
            height: 34px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            padding: 0 0.65rem !important;
            margin: 0 1px !important;
            font-size: 0.82rem !important;
            font-weight: 500;
            border: 1px solid var(--gray-200) !important;
            background: white !important;
            color: var(--gray-700) !important;
            box-shadow: none !important;
            transition: all 0.15s ease !important;
        }
        div.dataTables_wrapper div.dataTables_paginate .paginate_button.current,
        div.dataTables_wrapper div.dataTables_paginate .paginate_button.current:hover {
            background: var(--primary-600) !important;
            color: white !important;
            border-color: var(--primary-600) !important;
        }
        div.dataTables_wrapper div.dataTables_paginate .paginate_button:hover:not(.disabled):not(.current) {
            background: var(--primary-50) !important;
            color: var(--primary-700) !important;
            border-color: var(--primary-200) !important;
        }
        div.dataTables_wrapper div.dataTables_paginate .paginate_button.disabled,
        div.dataTables_wrapper div.dataTables_paginate .paginate_button.disabled:hover {
            opacity: 0.45;
            cursor: default !important;
            background: white !important;
            color: var(--gray-400) !important;
            border-color: var(--gray-100) !important;
        }
        div.dataTables_wrapper div.dataTables_paginate .paginate_button.previous,
        div.dataTables_wrapper div.dataTables_paginate .paginate_button.next {
            font-weight: 600;
        }

        /* Loading overlay */
        div.dataTables_processing {
            background: rgba(255,255,255,0.92) !important;
            border: 1px solid var(--gray-100) !important;
            border-radius: 12px !important;
            box-shadow: var(--shadow-md) !important;
            color: var(--gray-700) !important;
            padding: 1rem 1.25rem !important;
        }
        .dt-loading { display: inline-flex; align-items: center; gap: 0.5rem; color: var(--primary-700); }
        .dt-loading i { color: var(--primary-600); }

        table.dataTable thead th { cursor: pointer; user-select: none; white-space: nowrap; }
        table.dataTable thead th.sorting_asc::after  { content: ' ↑'; color: var(--primary-600); font-size: 0.8em; }
        table.dataTable thead th.sorting_desc::after { content: ' ↓'; color: var(--primary-600); font-size: 0.8em; }
        table.dataTable thead th.sorting::after      { content: ' ↕'; color: var(--gray-400); font-size: 0.8em; }

        @media (max-width: 768px) {
            .dt-toolbar, .dt-footer { flex-direction: column; align-items: stretch; }
            .dt-toolbar-left, .dt-toolbar-right, .dt-footer-info, .dt-footer-paginate {
                width: 100%; justify-content: space-between;
            }
            div.dataTables_wrapper div.dataTables_filter input { min-width: 0; width: 100%; }
            div.dataTables_wrapper div.dataTables_paginate { justify-content: center; flex-wrap: wrap; }
        }
    </style>
    @stack('styles')
</head>
<body class="admin-body">
    <div class="admin-layout">
        <div class="admin-overlay" id="adminOverlay"></div>

        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon"><i class="fas fa-seedling"></i></div>
                <div class="sidebar-brand-text">
                    <span class="sidebar-brand-name">CETING NASIKU</span>
                    <span class="sidebar-brand-sub">Panel Admin</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="sidebar-label">Menu Utama</div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-pie"></i><span>Dashboard</span>
                        </a>
                    </li>
                </ul>

                <div class="sidebar-label">Manajemen Konten</div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('admin.recipes.index') }}" class="{{ request()->is('admin/recipes*') ? 'active' : '' }}">
                            <i class="fas fa-utensils"></i><span>Resep</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.ingredients.index') }}" class="{{ request()->is('admin/ingredients*') ? 'active' : '' }}">
                            <i class="fas fa-carrot"></i><span>Bahan Makanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i><span>Kategori</span>
                        </a>
                    </li>
                </ul>

                <div class="sidebar-label">Lainnya</div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('home') }}" target="_blank" rel="noopener">
                            <i class="fas fa-external-link-alt"></i><span>Lihat Website</span>
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="sidebar-logout-form">
                            @csrf
                            <button type="submit" class="sidebar-logout-btn">
                                <i class="fas fa-sign-out-alt"></i><span>Keluar</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="sidebar-user-meta">
                        <strong>{{ auth()->user()->name }}</strong>
                        <span>Administrator</span>
                    </div>
                </div>
            </div>
        </aside>

        <div class="admin-content">
            <header class="admin-topbar">
                <button type="button" class="admin-menu-btn" id="adminMenuBtn" aria-label="Buka menu">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="admin-topbar-title">
                    <h1>@yield('title', 'Admin')</h1>
                    @hasSection('subtitle')
                        <p>@yield('subtitle')</p>
                    @endif
                </div>
                <div class="admin-topbar-actions">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline" target="_blank" rel="noopener">
                        <i class="fas fa-globe"></i> Website
                    </a>
                </div>
            </header>

            <main class="admin-main">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script>
        (function () {
            var sidebar = document.getElementById('adminSidebar');
            var overlay = document.getElementById('adminOverlay');
            var btn = document.getElementById('adminMenuBtn');
            function close() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
            if (btn) btn.addEventListener('click', function () {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
            if (overlay) overlay.addEventListener('click', close);
        })();
    </script>
    @stack('scripts')
</body>
</html>
