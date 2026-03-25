@extends('admin.layouts.app')
@section('title', 'Kelola Bahan Makanan')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-carrot" style="color: var(--accent-500);"></i> Bahan Makanan</h1>
    <a href="/admin/ingredients/create" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Bahan</a>
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
                <th class="no-sort">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ingredients as $i => $ing)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $ing->name }}</strong></td>
                <td><small style="color: var(--text-muted);">{{ $ing->unit }}</small></td>
                <td>{{ $ing->calories ?? $ing->calories_per_100g ?? 0 }} kkal</td>
                <td>{{ $ing->protein ?? $ing->protein_per_100g ?? 0 }} g</td>
                <td>{{ $ing->fat ?? $ing->fat_per_100g ?? 0 }} g</td>
                <td>{{ $ing->carbohydrates ?? $ing->carbohydrates_per_100g ?? 0 }} g</td>
                <td>{{ $ing->calcium ?? $ing->calcium_per_100g ?? 0 }} mg</td>
                <td>{{ $ing->iron ?? $ing->iron_per_100g ?? 0 }} mg</td>
                <td>
                    <div class="actions">
                        <a href="/admin/ingredients/{{ $ing->id }}/edit" class="btn-icon edit" title="Edit"><i class="fas fa-pen"></i></a>
                        <form action="/admin/ingredients/{{ $ing->id }}" method="POST" onsubmit="return confirm('Yakin hapus bahan ini?')" style="display:inline">
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
    $('#ingredientsTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
        },
        pageLength: 25,
        order: [[1, 'asc']],
        columnDefs: [
            { orderable: false, targets: 9 },
            { searchable: false, targets: [0, 3, 4, 5, 6, 7, 8, 9] }
        ],
        dom: '<"dt-topbar"lf>rtip',
        responsive: true,
    });
});
</script>
@endpush
