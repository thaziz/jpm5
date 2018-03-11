<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Response;

class trackingdoController extends Controller
{
    public function index(){
    	
        return view('trackingdo.index',compact('data','data2','data3'));
    }
    public function getdata($nomor) {
      /*dd($nomor);*/
       $sql = "    SELECT d.nomor,d.telpon_pengirim, d.telpon_penerima, d.tanggal,d.alamat_pengirim, d.alamat_penerima, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total
                    FROM delivery_order d
                    LEFT JOIN kota k ON k.id=d.id_kota_asal
                    LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan 
                    where d.nomor =  '$nomor'
                    ";
      $data = DB::select($sql);
      $data2 = DB::table('delivery_order')
              ->where('nomor','=',$nomor)
              ->get();
      $data3 = DB::table('update_detail1')
              ->where('nomor_do','=',$nomor)
              ->get();
      $getdata = DB::table('delivery_order')
        ->where('nomor','=',$nomor)
        ->groupBy('nomor')
        ->get();

          return view('trackingdo.tabel',['berhasil' => $getdata],compact('data','data2','data3','getdata'));

    }
    public function autocomplete(Request $request){
  
        $term = $request->term;
        
        $results = array();
        $queries = DB::table('delivery_order')
            ->where('delivery_order.nomor', 'like', '%'.$term.'%')
            ->take(10)->get();

        if ($queries == null){
            $results[] = [ 'id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {

            foreach ($queries as $query)
            {
                $results[] = [ 'id' => $query->nomor, 'label' => $query->nomor];
            }
        }

        return Response::json($results);
    }
}
