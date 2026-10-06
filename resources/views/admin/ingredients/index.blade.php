@extends('admin.layouts.app')
@section('title', 'Kelola Bahan Makanan')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-carrot" style="color: var(--accent-500);"></i> Bahan Makanan</h1>
    <a href="{{ route('admin.ingredients.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Bahan</a>
</div>

<div class="data-table-wrapper">
    <table id="ingredientsTable" class="data-table" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bahan</th>
                <th>Satuan</th>
                <th>Kalori</th>
                <th>Protein</th>
                <th>Lemak</th>
                <th>Karbo</th>
                <th>Kalsium</th>
                <th>Zat Besi</th>
                <th>Grup</th>
                <th class="no-sort">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#ingredientsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: @json(route('admin.ingredients.data')),
            type: 'GET'
        },
        columns: [
            { data: 0, orderable: false, searchable: false, width: '48px' },
            { data: 1 },
            { data: 2 },
            { data: 3, searchable: false },
            { data: 4, searchable: false },
            { data: 5, searchable: false },
            { data: 6, searchable: false },
            { data: 7, searchable: false },
            { data: 8, searchable: false },
            { data: 9 },
            { data: 10, orderable: false, searchable: false, width: '90px' }
        ],
        order: [[1, 'asc']],
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
