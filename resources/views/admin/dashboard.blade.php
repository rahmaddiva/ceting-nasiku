@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan data dan aktivitas konten')

@section('content')
<div class="dash-welcome">
    <div class="dash-welcome-text">
        <p class="dash-welcome-label">Selamat datang</p>
        <h2>{{ auth()->user()->name }}</h2>
        <p>Kelola resep, bahan, dan kategori gizi untuk program pencegahan stunting.</p>
    </div>
    <a href="{{ route('admin.recipes.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Resep
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-utensils"></i></div>
        <div class="stat-body">
            <div class="stat-number">{{ $stats['total_recipes'] }}</div>
            <div class="stat-label">Total Resep</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-check-circle"></i></div>
        <div class="stat-body">
            <div class="stat-number">{{ $stats['published_recipes'] }}</div>
            <div class="stat-label">Resep Dipublikasi</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-carrot"></i></div>
        <div class="stat-body">
            <div class="stat-number">{{ $stats['total_ingredients'] }}</div>
            <div class="stat-label">Bahan Makanan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal"><i class="fas fa-tags"></i></div>
        <div class="stat-body">
            <div class="stat-number">{{ $stats['total_categories'] }}</div>
            <div class="stat-label">Kategori</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-users"></i></div>
        <div class="stat-body">
            <div class="stat-number">{{ $stats['total_users'] }}</div>
            <div class="stat-label">Pengguna</div>
        </div>
    </div>
</div>

<div class="dash-grid">
    <section class="data-table-wrapper dash-panel">
        <div class="dash-panel-header">
            <div>
                <h3><i class="fas fa-clock"></i> Resep Terbaru</h3>
                <p>5 resep terakhir yang ditambahkan</p>
            </div>
            <a href="{{ route('admin.recipes.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Porsi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latest_recipes as $recipe)
                    <tr>
                        <td>
                            <a href="{{ route('admin.recipes.edit', $recipe) }}" class="dash-link">
                                <strong>{{ $recipe->title }}</strong>
                            </a>
                        </td>
                        <td>{{ $recipe->category->name ?? '—' }}</td>
                        <td>{{ $recipe->servings ?? '—' }}</td>
                        <td>
                            @if($recipe->is_published)
                                <span class="badge badge-success">Dipublikasi</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $recipe->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="dash-empty">
                                <i class="fas fa-utensils"></i>
                                <p>Belum ada resep. Mulai dengan menambahkan resep pertama.</p>
                                <a href="{{ route('admin.recipes.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Resep
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <aside class="dash-side">
        <div class="dash-panel dash-quick">
            <div class="dash-panel-header">
                <div>
                    <h3><i class="fas fa-bolt"></i> Aksi Cepat</h3>
                    <p>Navigasi singkat</p>
                </div>
            </div>
            <div class="dash-quick-list">
                <a href="{{ route('admin.recipes.create') }}" class="dash-quick-item">
                    <span class="dash-quick-icon green"><i class="fas fa-plus"></i></span>
                    <span>
                        <strong>Tambah Resep</strong>
                        <small>Buat resep gizi baru</small>
                    </span>
                </a>
                <a href="{{ route('admin.ingredients.create') }}" class="dash-quick-item">
                    <span class="dash-quick-icon orange"><i class="fas fa-carrot"></i></span>
                    <span>
                        <strong>Tambah Bahan</strong>
                        <small>Data bahan makanan</small>
                    </span>
                </a>
                <a href="{{ route('admin.categories.create') }}" class="dash-quick-item">
                    <span class="dash-quick-icon blue"><i class="fas fa-tags"></i></span>
                    <span>
                        <strong>Tambah Kategori</strong>
                        <small>Kelompokkan resep</small>
                    </span>
                </a>
                <a href="{{ route('home') }}" class="dash-quick-item" target="_blank" rel="noopener">
                    <span class="dash-quick-icon purple"><i class="fas fa-globe"></i></span>
                    <span>
                        <strong>Lihat Website</strong>
                        <small>Buka halaman publik</small>
                    </span>
                </a>
            </div>
        </div>
    </aside>
</div>
@endsection
