@extends('admin.layouts.app')
@section('title', 'Kelola Kategori')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-tags" style="color: var(--primary-600);"></i> Kategori</h1>
    <a href="/admin/categories/create" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Kategori</a>
</div>

<div class="data-table-wrapper">
    <table id="categoriesTable" class="data-table" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah Resep</th>
                <th class="no-sort">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $i => $cat)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $cat->name }}</strong></td>
                <td>{{ Str::limit($cat->description, 60) }}</td>
                <td><span class="badge badge-success">{{ $cat->recipes_count }}</span></td>
                <td>
                    <div class="actions">
                        <a href="/admin/categories/{{ $cat->id }}/edit" class="btn-icon edit" title="Edit"><i class="fas fa-pen"></i></a>
                        <form action="/admin/categories/{{ $cat->id }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')" style="display:inline">
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
    $('#categoriesTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
        },
        pageLength: 25,
        order: [[3, 'desc']],
        columnDefs: [
            { orderable: false, targets: 4 },
            { searchable: false, targets: [0, 3, 4] }
        ],
        dom: '<"dt-topbar"lf>rtip',
    });
});
</script>
@endpush
