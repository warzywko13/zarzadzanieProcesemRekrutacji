<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    public function createPagination(array $results)
    {
        $perPage = 10;
        $currentPage = Paginator::resolveCurrentPage();
        $currentPageItems = array_slice($results, ($currentPage - 1) * $perPage, $perPage);

        $paginatedData = new LengthAwarePaginator(
            $currentPageItems,
            count($results),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath(), 'onEachSide' => 1] // Set onEachSide to the desired limit
        );

        return $paginatedData;
    }

    public function generate_sql_array(string $prefix, array $array): string
    {
        $array_string = array_map(function($item) {
            return "'" . addslashes($item) . "'";
        }, $array);

        $result = implode(',', $array_string);

        return " AND " . $prefix . " IN (" . $result . ")";
    }

    public function get_user_filter_data()
    {
        $filter = [];
        $filter['users'] = DB::select("SELECT id, CONCAT(firstname, ' ', lastname) as name FROM users WHERE deleted = 0 ORDER BY firstname");
        $filter['city'] = DB::select("SELECT city as id, city as name FROM users WHERE deleted = 0 GROUP BY city ORDER BY city");
        $filter['phone'] = DB::select("SELECT phone as id, phone as name FROM users WHERE deleted = 0 GROUP BY phone ORDER BY phone");

        return $filter;
    }

    public function get_positions_filter_data()
    {
        $filter = [];
        $filter['positions'] = DB::select("SELECT id, name FROM positions WHERE deleted = 0 ORDER BY name");

        return $filter;
    }
}
