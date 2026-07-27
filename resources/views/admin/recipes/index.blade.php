@extends('admin.layouts.app')
@section('title', 'Kelola Resep')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-utensils" style="color: var(--primary-600);"></i> Kelola Resep</h1>
    <a href="{{ route('admin.recipes.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Resep</a>
</div>

<div class="data-table-wrapper">
    <div style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; border-bottom:1px solid #e5e7eb;">
        <label for="image-model-index" style="font-size:0.8rem; color:#6b7280; white-space:nowrap;">Model Generate:</label>
        <select id="image-model-index" style="padding:0.35rem 0.5rem; border:1px solid #d1d5db; border-radius:6px; font-size:0.8rem;">
            <option value="ali-z-image-turbo">Z Image Turbo (Free)</option>
            <option value="flux-2-klein-4b">Flux 2 Klein (Free)</option>
            <option value="ali-qwen-image-plus">Qwen Image Plus</option>
            <option value="ali-qwen-image-2.0">Qwen Image 2.0</option>
            <option value="ali-qwen-image-2.0-pro">Qwen Image 2.0 Pro</option>
            <option value="ali-qwen-image-max">Qwen Image Max</option>
            <option value="ali-wan2.7-image">Wan2.7 Image</option>
            <option value="ali-wan2.7-image-pro">Wan2.7 Image Pro</option>
        </select>
    </div>
    <table id="recipesTable" class="data-table" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th class="no-sort">Gambar</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Kelompok Usia</th>
                <th>Porsi</th>
                <th>Status</th>
                <th>Dibuat</th>
                <th class="no-sort">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#recipesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: @json(route('admin.recipes.data')),
            type: 'GET'
        },
        columns: [
            { data: 0, orderable: false, searchable: false, width: '48px' },
            { data: 1, orderable: false, searchable: false, width: '64px' },
            { data: 2 },
            { data: 3, orderable: false },
            { data: 4 },
            { data: 5, searchable: false },
            { data: 6, searchable: false },
            { data: 7, searchable: false },
            { data: 8, orderable: false, searchable: false, width: '120px' }
        ],
        order: [[7, 'desc']],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json',
            processing: '<div class="dt-loading"><i class="fas fa-spinner fa-spin"></i> Memuat data…</div>'
        },
        dom: '<"dt-toolbar"<"dt-toolbar-left"l><"dt-toolbar-right"f>>rt<"dt-footer"<"dt-footer-info"i><"dt-footer-paginate"p>>',
        responsive: true,
    });
});

function generateSingleImage(recipeId, btn) {
    const model = document.getElementById('image-model-index').value;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    fetch('{{ route("admin.recipes.generate-single-image") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ id: recipeId, model: model }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            btn.outerHTML = '<img src="' + data.image + '?' + Date.now() + '" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">';
        } else {
            alert('Gagal: ' + (data.error || 'Unknown error'));
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-wand-magic-sparkles"></i>';
        }
    })
    .catch(err => {
        alert('Error: ' + err.message);
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-wand-magic-sparkles"></i>';
    });
}
</script>
@endpush
