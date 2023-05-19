<?php

namespace App\Http\Controllers\wt;

use App\Http\Controllers\Controller;
use App\Models\wt\User;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;


class ExcelController extends Controller
{

    public function export(): string
    {
        $list = User::all();

        return (new FastExcel($list))->export('file.xlsx');

    }
}
