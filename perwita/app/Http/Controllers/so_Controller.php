<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class so_Controller extends Controller
{

    public function index()
    {
        # code...
        echo "sdfsdfds";
    }
    public function so_form()
        $customers = DB::table('provinsi')->get;
        //return view('sales.so.form',['customers' => $customers]);
        $list = $list->toArray();
        $data = array();
        foreach ($list as $r) {
            $data[] = $r;
        }
        $i=0;
        foreach ($data as $key) {
                    // add new button
            $data[$i]['button'] = ' <button type="submit" id="'.$data[$i]['id'].'" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                                            <button type="submit" id="'.$data[$i]['id'].'" name="'.$data[$i]['provinsi'].'" class="btn btn-danger btn-xs btnhapus" ><i class="glyphicon glyphicon-remove"></i></button>';
            $i++;
        //return view('sales.so.form',['customers' => $customers]);
    }

}
