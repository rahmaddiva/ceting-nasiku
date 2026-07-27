@extends('admin.layouts.app')
@section('title', 'Kelola Resep')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-utensils" style="color: var(--primary-600);"></i> Kelola Resep</h1>
    <a href="{{ route('admin.recipes.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Resep</a>
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
            { data: 1 },
            { data: 2, orderable: false },
            { data: 3 },
            { data: 4, searchable: false },
            { data: 5, searchable: false },
            { data: 6, searchable: false },
            { data: 7, orderable: false, searchable: false, width: '90px' }
        ],
        order: [[6, 'desc']],
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
</script>
@endpush
