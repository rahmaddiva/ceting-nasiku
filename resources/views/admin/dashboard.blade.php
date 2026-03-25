@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="admin-header">
    <div>
        <h1>Dashboard</h1>
        <p style="color: var(--text-secondary);">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-utensils"></i></div>
        <div>
            <div class="stat-number">{{ $stats['total_recipes'] }}</div>
            <div class="stat-label">Total Resep</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-check-circle"></i></div>
        <div>
            <div class="stat-number">{{ $stats['published_recipes'] }}</div>
            <div class="stat-label">Resep Dipublikasi</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-carrot"></i></div>
        <div>
            <div class="stat-number">{{ $stats['total_ingredients'] }}</div>
            <div class="stat-label">Bahan Makanan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-users"></i></div>
        <div>
            <div class="stat-number">{{ $stats['total_users'] }}</div>
            <div class="stat-label">Pengguna</div>
        </div>
    </div>
</div>

<!-- Latest Recipes -->
<div class="data-table-wrapper" style="margin-top: 2rem;">
    <div style="padding: 1.25rem; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-size: 1.1rem;"><i class="fas fa-clock" style="color: var(--primary-600);"></i> Resep Terbaru</h3>
        <a href="/admin/recipes" class="btn btn-sm btn-outline">Lihat Semua</a>
    </div>
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
                <td><strong>{{ $recipe->title }}</strong></td>
                <td>{{ $recipe->category->name ?? '-' }}</td>
                <td>{{ $recipe->servings }}</td>
                <td>
                    @if($recipe->is_published)
                        <span class="badge badge-success">Dipublikasi</span>
                    @else
                        <span class="badge badge-warning">Draft</span>
                    @endif
                </td>
                <td>{{ $recipe->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-muted);">Belum ada resep</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
