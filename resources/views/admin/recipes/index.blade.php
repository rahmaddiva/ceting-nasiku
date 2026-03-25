@extends('admin.layouts.app')
@section('title', 'Kelola Resep')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-utensils" style="color: var(--primary-600);"></i> Kelola Resep</h1>
    <a href="/admin/recipes/create" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Resep</a>
</div>

<div class="data-table-wrapper">
    <table id="recipesTable" class="data-table" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Kelompok Usia</th>
                <th>Porsi</th>
                <th>Status</th>
                <th>Dibuat</th>
                <th class="no-sort">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recipes as $i => $recipe)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $recipe->title }}</strong></td>
                <td>{{ $recipe->category->name ?? '-' }}</td>
                <td>{{ $recipe->age_group ?? '-' }}</td>
                <td>{{ $recipe->servings }}</td>
                <td>
                    @if($recipe->is_published)
                        <span class="badge badge-success">Publik</span>
                    @else
                        <span class="badge badge-warning">Draft</span>
                    @endif
                </td>
                <td data-order="{{ $recipe->created_at->timestamp }}">{{ $recipe->created_at->format('d M Y') }}</td>
                <td>
                    <div class="actions">
                        <a href="/admin/recipes/{{ $recipe->id }}/edit" class="btn-icon edit" title="Edit"><i class="fas fa-pen"></i></a>
                        <form action="/admin/recipes/{{ $recipe->id }}" method="POST" onsubmit="return confirm('Yakin hapus resep ini?')" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon delete" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#recipesTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
        },
        pageLength: 25,
        order: [[6, 'desc']],
        columnDefs: [
            { orderable: false, targets: 7 },  // Aksi column
            { searchable: false, targets: [0, 4, 6, 7] }
        ],
        dom: '<"dt-topbar"lf>rtip',
        responsive: true,
    });
});
</script>
@endpush
