<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DB;

class ChartJSController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $users = User::select(
            DB::raw("COUNT(*) as count"),
            DB::raw("MONTHNAME(created_at) as month_name"),
            DB::raw("MONTH(created_at) as month_number")
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month_number', 'month_name')
            ->orderBy('month_number')
            ->pluck('count', 'month_name');

        $labels = $users->keys();
        $data = $users->values();

        return view('chart', compact('labels', 'data'));
    }
}
