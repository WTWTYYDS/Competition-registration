<?php

namespace App\Http\Controllers\wt;

use App\Http\Controllers\Controller;
use App\Models\wt\User;
use App\Models\wt\User_inf;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;


class ExcelController extends Controller
{

    public function export(Request $request): string
    {
        if($request->filled('competition_3')){
            $list = User_inf::select_excel($request);

        }else{
            $list = User_inf::select_excel_all($request);
        }

        $file_name = 'rr.xlsx';
        $file_dir = (new FastExcel($list))->export($file_name);

// 检查文件是否存在
        if (!file_exists($file_dir)) {
            header('HTTP/1.1 404 NOT FOUND');
        } else {
            // 以只读和二进制模式打开文件
            $file = fopen($file_dir, "rb");

            // 告诉浏览器这是一个文件流格式的文件
            Header("Content-type: application/octet-stream");
            // 请求范围的度量单位
            Header("Accept-Ranges: bytes");
            // Content-Length是指定包含于请求或响应中数据的字节长度
            Header("Accept-Length: " . filesize($file_dir));
            // 用来告诉浏览器，文件是可以当做附件被下载，下载后的文件名称为$file_name该变量的值。
            Header("Content-Disposition: attachment; filename=" . $file_name);

            // 读取文件内容并直接输出到浏览器
            echo fread($file, filesize($file_dir));
            fclose($file);

            exit ();
        }


        //unlink() 函数用于删除文件。若成功，则返回 true，失败则返回 false。rmdir()
        // 函数用于删除空的目录。它尝试删除 dir 所指定的目录。 该目录必须是空的，
        //而且要有相应的权限。
        return unlink($file_dir);

    }
}
