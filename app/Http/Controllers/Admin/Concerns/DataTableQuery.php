<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait DataTableQuery
{
    /**
     * Apply DataTables search/sort/paginate and return JSON payload.
     *
     * @param  array<int, string|null>  $columns  map column index => DB column (null = not sortable)
     * @param  array<int, string>  $searchColumns  DB columns for global search
     * @param  callable(mixed): array  $mapRow
     */
    protected function dataTable(Request $request, Builder $query, array $columns, array $searchColumns, callable $mapRow)
    {
        $draw = (int) $request->input('draw', 1);
        $start = max(0, (int) $request->input('start', 0));
        $length = (int) $request->input('length', 25);
        if ($length < 1 || $length > 100) {
            $length = 25;
        }

        $recordsTotal = (clone $query)->count();

        $search = trim((string) data_get($request->input('search'), 'value', ''));
        if ($search !== '' && $searchColumns) {
            $query->where(function (Builder $q) use ($search, $searchColumns) {
                foreach ($searchColumns as $i => $col) {
                    $i === 0
                        ? $q->where($col, 'like', "%{$search}%")
                        : $q->orWhere($col, 'like', "%{$search}%");
                }
            });
        }

        $recordsFiltered = (clone $query)->count();

        $orderCol = (int) data_get($request->input('order'), '0.column', 0);
        $orderDir = strtolower((string) data_get($request->input('order'), '0.dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        $sortColumn = $columns[$orderCol] ?? null;
        if ($sortColumn) {
            $query->orderBy($sortColumn, $orderDir);
        }

        $rows = $query->skip($start)->take($length)->get();
        $data = [];
        foreach ($rows as $i => $row) {
            $data[] = $mapRow($row, $start + $i + 1);
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}
