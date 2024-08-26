<?php
namespace App\Services;

//model
use App\Models\User;


//other
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DataTableService
{
    /**
     * 構建 DataTable
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @param array $columns
     * @param string $method 可選 'eloquent', 'query', 'collection'
     * @param callable|null $customization
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function buildDataTable($query, array $columns, string $method = 'eloquent', callable $customization = null)
    {
        Log::info(["query"=>$query->get()]);

        // 根據不同方法生成 DataTable
        $datatable = match ($method) {
            'eloquent' => DataTables::eloquent($query),
            'query' => DataTables::query($query),
            'collection' => DataTables::collection($query->get()), // 針對集合數據
            default => DataTables::eloquent($query),
        };

        // 添加欄位
        foreach ($columns as $column) {
            $datatable->addColumn($column, function ($query) use ($column) {
                return $query->$column;
            });
        }

        // 如果有自定義邏輯，則應用
        if ($customization) {
            $customization($datatable);
        }

        return $datatable;
    }
}
