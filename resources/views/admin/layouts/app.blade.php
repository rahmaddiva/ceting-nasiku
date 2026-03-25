<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — CETING NASIKU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <style>
        /* DataTables custom overrides to match existing design */
        div.dataTables_wrapper div.dataTables_filter input {
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius-sm);
            padding: 0.4rem 0.75rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.2s;
        }
        div.dataTables_wrapper div.dataTables_filter input:focus {
            border-color: var(--primary-500);
        }
        div.dataTables_wrapper div.dataTables_length select {
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius-sm);
            padding: 0.3rem 0.5rem;
            font-size: 0.875rem;
        }
        div.dataTables_wrapper div.dataTables_info {
            font-size: 0.82rem;
            color: var(--text-muted);
            padding-top: 0.75rem;
        }
        div.dataTables_wrapper div.dataTables_paginate {
            padding-top: 0.5rem;
        }
        div.dataTables_wrapper div.dataTables_paginate .paginate_button {
            border-radius: 6px !important;
            padding: 0.3rem 0.7rem !important;
            font-size: 0.82rem !important;
            border: 1px solid transparent !important;
        }
        div.dataTables_wrapper div.dataTables_paginate .paginate_button.current,
        div.dataTables_wrapper div.dataTables_paginate .paginate_button.current:hover {
            background: var(--primary-600) !important;
            color: white !important;
            border-color: var(--primary-600) !important;
        }
        div.dataTables_wrapper div.dataTables_paginate .paginate_button:hover {
            background: var(--gray-100) !important;
            color: var(--gray-800) !important;
            border-color: var(--gray-200) !important;
        }
        table.dataTable thead th {
            cursor: pointer;
            user-select: none;
        }
        table.dataTable thead th.sorting_asc::after  { content: ' ↑'; color: var(--primary-600); font-size: 0.8em; }
        table.dataTable thead th.sorting_desc::after { content: ' ↓'; color: var(--primary-600); font-size: 0.8em; }
        table.dataTable thead th.sorting::after      { content: ' ↕'; color: var(--gray-400); font-size: 0.8em; }
        div.dataTables_wrapper div.dataTables_filter { margin-bottom: 0.5rem; }
        div.dataTables_wrapper div.dataTables_length { margin-bottom: 0.5rem; }
        .dt-topbar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; padding: 0.25rem 0 0.75rem; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-brand">
                <i class="fas fa-seedling"></i>
                <span>CETING NASIKU</span>
            </div>

            <div class="sidebar-label">Menu Utama</div>
            <ul class="sidebar-menu">
                <li><a href="/admin" class="{{ request()->is('admin') ? 'active' : '' }}"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
            </ul>

            <div class="sidebar-label">Manajemen Konten</div>
            <ul class="sidebar-menu">
                <li><a href="/admin/recipes" class="{{ request()->is('admin/recipes*') ? 'active' : '' }}"><i class="fas fa-utensils"></i> Resep</a></li>
                <li><a href="/admin/ingredients" class="{{ request()->is('admin/ingredients*') ? 'active' : '' }}"><i class="fas fa-carrot"></i> Bahan Makanan</a></li>
                <li><a href="/admin/categories" class="{{ request()->is('admin/categories*') ? 'active' : '' }}"><i class="fas fa-tags"></i> Kategori</a></li>
            </ul>

            <div class="sidebar-label">Lainnya</div>
            <ul class="sidebar-menu">
                <li><a href="/"><i class="fas fa-globe"></i> Lihat Website</a></li>
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" style="all: inherit; cursor: pointer; width: 100%;"><i class="fas fa-sign-out-alt"></i> Keluar</button>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
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

    {{-- jQuery + DataTables JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    @stack('scripts')
</body>
</html>
