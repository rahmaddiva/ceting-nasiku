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
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-image"></i></div>
        <div class="stat-body">
            <div class="stat-number">{{ $stats['recipes_without_image'] }}</div>
            <div class="stat-label">Tanpa Gambar</div>
        </div>
    </div>
</div>

@if($stats['recipes_without_image'] > 0)
<div class="dash-panel" style="margin-bottom: 1.5rem;">
    <div class="dash-panel-header">
        <div>
            <h3><i class="fas fa-wand-magic-sparkles"></i> Generate Gambar Resep</h3>
            <p>{{ $stats['recipes_with_image'] }} dari {{ $stats['total_recipes'] }} resep sudah punya gambar</p>
        </div>
    </div>
    <div style="margin-bottom: 1rem;">
        <div style="background: #e9ecef; border-radius: 8px; height: 24px; overflow: hidden;">
            <div id="image-progress-bar" style="background: linear-gradient(90deg, #10b981, #059669); height: 100%; width: {{ $stats['total_recipes'] > 0 ? round(($stats['recipes_with_image'] / $stats['total_recipes']) * 100) : 0 }}%; transition: width 0.5s ease; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 600;">
                {{ $stats['total_recipes'] > 0 ? round(($stats['recipes_with_image'] / $stats['total_recipes']) * 100) : 0 }}%
            </div>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
        <button id="btn-generate-images" class="btn btn-primary" onclick="generateImages()">
            <i class="fas fa-wand-magic-sparkles"></i> Generate Gambar ({{ $stats['recipes_without_image'] }} resep)
        </button>
        <span id="generate-status" style="color: #6b7280; font-size: 0.875rem;"></span>
    </div>
    <div id="generate-result" style="margin-top: 0.75rem; display: none;"></div>
</div>
@else
<div class="dash-panel" style="margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 0.75rem; color: #10b981;">
        <i class="fas fa-check-circle" style="font-size: 1.25rem;"></i>
        <span>Semua resep sudah memiliki gambar.</span>
    </div>
</div>
@endif

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

@push('scripts')
<script>
function generateImages() {
    const btn = document.getElementById('btn-generate-images');
    const status = document.getElementById('generate-status');
    const result = document.getElementById('generate-result');

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
    status.textContent = 'Mohon tunggu, proses ini bisa memakan waktu beberapa menit...';
    result.style.display = 'none';

    fetch('{{ route("admin.recipes.generate-images") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        result.style.display = 'block';

        if (data.success) {
            result.innerHTML = '<div style="color: #10b981; font-weight: 500;">' +
                '<i class="fas fa-check-circle"></i> Berhasil generate ' + data.generated + ' gambar!' +
                (data.remaining > 0 ? ' Sisa ' + data.remaining + ' resep belum punya gambar.' : ' Semua resep sudah punya gambar!') +
                '</div>';
            setTimeout(() => location.reload(), 1500);
        } else {
            result.innerHTML = '<div style="color: #f59e0b; font-weight: 500;">' +
                '<i class="fas fa-exclamation-triangle"></i> ' +
                (data.errors.length > 0 ? data.errors.join(', ') : 'Tidak ada gambar yang berhasil di-generate.') +
                '</div>';
        }

        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-wand-magic-sparkles"></i> Generate Gambar';
        status.textContent = '';
    })
    .catch(err => {
        result.style.display = 'block';
        result.innerHTML = '<div style="color: #ef4444; font-weight: 500;">' +
            '<i class="fas fa-times-circle"></i> Terjadi kesalahan: ' + err.message +
            '</div>';
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-wand-magic-sparkles"></i> Generate Gambar';
        status.textContent = '';
    });
}
</script>
@endpush
