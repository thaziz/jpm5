<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use File;
use App\masterItemPurchase;
use App\masterJenisItemPurchase;
use App\master_cabang;
use App\master_provinsi;
use App\master_kota;
use App\masterGudangPurchase;
use App\masterSupplierPurchase;
use App\master_department;
use App\itemsupplier;
use App\masterbank;
use App\masterbank_dt;

use App\d_golongan_aktiva;
use App\d_master_aktiva;

use Auth;

use DB;

use Session;

class MasterPurchaseController extends Controller
{

	public function masteritem() {

		$data['cabang'] = master_cabang::all();
		$cabang = session::get('cabang');
		/*if(Auth::user()->punyaAkses('Master Item Purchase','all')){
			$data['item'] = DB::select("select * from masteritem, jenis_item where masteritem.jenisitem = jenis_item.kode_jenisitem  ORDER BY kode_item DESC");
		}else{
			$data['item'] = DB::select("select * from masteritem, jenis_item where masteritem.jenisitem = jenis_item.kode_jenisitem and comp_id = '$cabang'  ORDER BY kode_item DESC");
		}*/

		$data['item'] = DB::select("select * from masteritem, jenis_item where masteritem.jenisitem = jenis_item.kode_jenisitem  ORDER BY kode_item DESC");


		return view('purchase/master/master_item/index',compact('data'));
	}
	

	public function createmasteritem() {
		$data['cabang'] = master_cabang::all();
		$data['jenisitem'] = masterJenisItemPurchase::all();
		$akun = DB::table('d_akun')->select('id_akun','nama_akun')->get();
		$id=masterItemPurchase::max('kode_item'); 
		
		if(isset($id)) {

			$string = explode("-",$id);
			$jumlah = $string[1] + 1;
			$iditem = $string[0] . '-' . $jumlah;

			$invID = str_pad($jumlah, 5, '0', STR_PAD_LEFT);

			$data['id'] = $invID;
		}
		else {
			$data['id'] ='A-000001';
		}

	//	dd($data['jenisitem']);
		
		return view('purchase/master/master_item/create', compact('data','akun'));
	}

	public function datajenisitem(Request $request){
		$updatestock = $request->updatestock;
		$idgrupitem = $request->kodejenis;

		$datajenis = DB::select("select * from jenis_item where kode_jenisitem = '$idgrupitem'");
		$stock = $datajenis[0]->stock;
		$cabang = $request->cabang;
	//	$data['stock'] = $stock;

		if($stock == 'Y'){
			if($updatestock == 'T'){
				if($idgrupitem == 'P'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '5111%' and kode_cabang = '$cabang'");
				}
				else if($idgrupitem == 'S'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '5106%' and  kode_cabang = '$cabang'  or id_akun LIKE '5206%' and  kode_cabang = '000' or id_akun LIKE '5306%' and  kode_cabang = '$cabang' ");
				}
				else if($idgrupitem == 'A'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '6103%' and kode_cabang = '$cabang'");
				}
				else if($idgrupitem == 'C'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1604%' and kode_cabang = '$cabang'");
				}
				else {
					$data['akun'] = DB::select("select * from d_akun where kode_cabang = '$cabang' ");
				}
			}
			else if($updatestock == 'Y'){
				if($idgrupitem == 'P'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1501%' and kode_cabang = '000'");
					//return json_encode($data);
				}
				else if($idgrupitem == 'S'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1502%' and kode_cabang = '$cabang'");
				}
				else if($idgrupitem == 'A'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1503%' and kode_cabang = '$cabang'");
				}
				else if($idgrupitem == 'L'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1599%' and kode_cabang = '$cabang'");

				}
				else if($idgrupitem == 'C'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1604%' and kode_cabang = '$cabang'");
				}
				else {
					$data['akun'] = DB::select("select * from d_akun where kode_cabang = '$cabang'");
				}
			}
		}		
		else {
			if($idgrupitem == 'C'){
				$data['akun'] = DB::select("select * from d_akun where kode_cabang = '$cabang' and id_akun LIKE '1604%'");
			}
			else if($idgrupitem == 'B'){
				$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '5%' or id_akun LIKE '6%' or id_akun LIKE '7%' or id_akun LIKE '8%' and kode_cabang = '$cabang'");
			}
			else {
				$data['akun'] = DB::select("select * from d_akun where kode_cabang = '$cabang'");
			}
			
		}
	
		$data['stock'] = $stock;
		return json_encode($data);
	}
	

	public function getpersediaan(Request $request){
		$updatestock = $request->updatestock;
		$idgrupitem = $request->groupitem;
	
		$cabang = $request->cabang;
	

		$datagrup = DB::select("select * from jenis_item where kode_jenisitem = '$idgrupitem'");
		$stock = $datagrup[0]->stock;
		$data['stock'] = $stock;
		if($stock == 'Y'){
			if($updatestock == 'T'){
				if($cabang == 000){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '7%' and kode_cabang = '$cabang'");
				}
				else {
					if($idgrupitem == 'P'){
						$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '5111%' and kode_cabang = '$cabang'");
					}
					else if($idgrupitem == 'S'){
						$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '5106%' and  kode_cabang = '$cabang'  or id_akun LIKE '5206%' and  kode_cabang = '000' or id_akun LIKE '5306%' and  kode_cabang = '$cabang' ");
					}
					else if($idgrupitem == 'A'){
						$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '6103%' and kode_cabang = '$cabang'");
					}
					else if($idgrupitem == 'C'){
						$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1604%' and kode_cabang = '$cabang'");
					}
					else {
						$data['akun'] = DB::select("select * from d_akun where kode_cabang = '$cabang' ");
					}
				}
			}
			else if($updatestock == 'Y'){
				if($idgrupitem == 'P'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1501%' and kode_cabang = '000'");
					//return json_encode($data);
				}
				else if($idgrupitem == 'S'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1502%' and kode_cabang = '$cabang'");
				}
				else if($idgrupitem == 'A'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1503%' and kode_cabang = '$cabang'");
				}
				else if($idgrupitem == 'L'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1599%' and kode_cabang = '$cabang'");

				}
				else if($idgrupitem == 'C'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1604%' and kode_cabang = '$cabang'");
				}
				else {
					$data['akun'] = DB::select("select * from d_akun where kode_cabang = '$cabang'");
				}
			}
		}		
		else {
			if($idgrupitem == 'C'){
				$data['akun'] = DB::select("select * from d_akun where kode_cabang = '$cabang' and id_akun LIKE '1604%'");
			}
			else if($idgrupitem == 'B'){
				$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '5%' or id_akun LIKE '6%' or id_akun LIKE '7%' or id_akun LIKE '8%' and kode_cabang = '$cabang'");
			}
			else {
				$data['akun'] = DB::select("select * from d_akun where kode_cabang = '$cabang'");
			}
			
		}

		$data['akunmaster'] = DB::select("select * from d_akun where kode_cabang = '$cabang'");
		return json_encode($data);
	}

	public function getaccpersediaan(Request $request){
		$updatestock = $request->updatestock;
		$groupitem = $request->groupitem;
		$explode = explode(",", $groupitem);
		$cabang = $request->cabang;
		$idgrupitem = $explode[0];
		$stock = $explode[1];
		$data['stock'] = $stock;
		if($stock == 'Y'){
			if($updatestock == 'T'){
				if($cabang == 000){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '7%' and kode_cabang = '$cabang'");
				}
				else {
					if($idgrupitem == 'P'){
						$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '5111%' and kode_cabang = '$cabang'");
					}
					else if($idgrupitem == 'S'){
						$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '5106%' and  kode_cabang = '$cabang'  or id_akun LIKE '5206%' and  kode_cabang = '000' or id_akun LIKE '5306%' and  kode_cabang = '$cabang' ");
					}
					else if($idgrupitem == 'A'){
						$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '6103%' and kode_cabang = '$cabang'");
					}
					else if($idgrupitem == 'C'){
						$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1604%' and kode_cabang = '$cabang'");
					}
					else {
						$data['akun'] = DB::select("select * from d_akun where kode_cabang = '$cabang' ");
					}
				}
			}
			else if($updatestock == 'Y'){
				if($idgrupitem == 'P'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1501%' and kode_cabang = '000'");
					//return json_encode($data);
				}
				else if($idgrupitem == 'S'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1502%' and kode_cabang = '$cabang'");
				}
				else if($idgrupitem == 'A'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1503%' and kode_cabang = '$cabang'");
				}
				else if($idgrupitem == 'L'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1599%' and kode_cabang = '$cabang'");

				}
				else if($idgrupitem == 'C'){
					$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '1604%' and kode_cabang = '$cabang'");
				}
				else {
					$data['akun'] = DB::select("select * from d_akun where kode_cabang = '$cabang'");
				}
			}
		}		
		else {
			if($idgrupitem == 'C'){
				$data['akun'] = DB::select("select * from d_akun where kode_cabang = '$cabang' and id_akun LIKE '1604%'");
			}
			else if($idgrupitem == 'B'){
				$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '5%' or id_akun LIKE '6%' or id_akun LIKE '7%' or id_akun LIKE '8%' and kode_cabang = '$cabang'");
			}
			else {
				$data['akun'] = DB::select("select * from d_akun where kode_cabang = '$cabang'");
			}
			
		}
		
				$data['akunmaster'] = DB::select("select * from d_akun where kode_cabang = '$cabang'");

		
		return json_encode($data);
	}

	public function saveitem(Request $request) {
		//dd($request);
		$variable = explode(",", $request->jenis_item);
		$jenisitem = $variable[0];

		$id=masterItemPurchase::where('jenisitem' , $jenisitem)->max('kode_item'); 
	//	dd($jenisitem);


		$lastiditem = masterItemPurchase::max('iditem'); 				
		if(isset($lastiditem)) {
		
				$iditem = $lastiditem;
				$iditem = (int)$lastiditem + 1;
		}
		else {
			$iditem = 1;	
		}
		
		if($id) {
			$string = explode("-",$id);
			$jumlah = $string[1] + 1;
		//	$iditem = $string[0] . '-' . $jumlah;

		
			$invID = str_pad($jumlah, 6, '0', STR_PAD_LEFT);

			$data['id'] = $jenisitem . "-" . $invID;
		}
		else {
			$data['id'] = $jenisitem . "-" .  '000001';
		}

		//dd($data['id']);
		$comp_id = "C001";

		$masteritem = new masterItemPurchase();
		$masteritem->kode_item = $data['id'];
		$masteritem->nama_masteritem = strtoupper(request()->nama_item);
		$masteritem->iditem = $iditem;
		$masteritem->comp_id = $request->cabang;
		$masteritem->kode_akun = $request->akun;
		if($jenisitem != 'J'){
			$masteritem->minstock = strtoupper(request()->minimum_stock);
		}
		 $masteritem->acc_persediaan = $request->acc_persediaan;
        $masteritem->acc_hpp = $request->acc_hpp;
		

		$masteritem->jenisitem = $jenisitem ;

		$masteritem->updatestock = strtoupper(request()->update_stock);


		$replacehrg = str_replace(',', '', $request->harga);
		$masteritem->harga = $replacehrg;
		$masteritem->unit1 = strtoupper(request()->unit1);
		$masteritem->unit2 = strtoupper(request()->unit2);
		$masteritem->unit3 = strtoupper(request()->unit3);
	
		$masteritem->unitstock = strtoupper(request()->unitstock);

		if($request->konversi2 == '') {

		}else{
			$masteritem->konversi2 = strtoupper(request()->konversi2);

		}
		if($request->konversi3 == ''){

		}
		else {
			$masteritem->konversi3 = strtoupper(request()->konversi3);
		}

		if($request->posisilantai != ''){
			$masteritem->posisilantai = strtoupper(request()->posisilantai);
		}
		if($request->posisiruang != ''){
			$masteritem->posisiruang = strtoupper(request()->posisiruang);
		}
		if($request->posisirak != ''){
			$masteritem->posisirak = strtoupper(request()->posisirak);
		}
		if($request->posisikolom != ''){
			$masteritem->posisikolom = strtoupper(request()->posisikolom);
		}
		
			

		/*if($request->file('imageUpload') == ''){
            return 'file kosong';
        }
        else{
            $childPath = 'img/item/'. $data['id'];
            $path = $childPath;
            $file = $request->file('imageUpload');
            $name = 'item-'.$data['id'] .'.'.$file->getClientOriginalExtension();            
            if (!File::exists($path))
            {
                if(File::makeDirectory($path,0777,true)){
                    

                    $imgPath = $childPath.'/'.$name;
                }
                else
                    return "gagal upload foto";
            }
            else{
            	
                return 'gambar sudah ada';
            }
        }

        	$masteritem->foto = $imgPath; */
       		$masteritem->save();
       	//	$file->move($path, $name);
       			
       		 return redirect('masteritem/masteritem');
	} 


	public function edititem($id) {
		$akun = DB::table('d_akun')->select('id_akun','nama_akun')->get();
		$data['cabang'] = master_cabang::all();
		$data['jenisitem'] = masterJenisItemPurchase::all();

		// $data = masterItemPurchase::find($id);
		$data['item'] = DB::select("select * from masteritem, cabang, jenis_item where  masteritem.comp_id = cabang.kode and masteritem.kode_item = '$id' and masteritem.jenisitem = jenis_item.kode_jenisitem ORDER BY kode_item DESC");
		//dd($data);

		return view('purchase/master/master_item/edit',compact('data','akun'));
	}

	public function updateitem($id, Request $request) {
	//	dd($request);

		/*	dd($request);*/
		$data = masterItemPurchase::find($id);
		  $jenis  = $request->jenis_item;
		/*$file = $request->file('imageUpload');
        $imgPath = "";
        $pathPic = $data->foto;      */  

        $iditem2=masterItemPurchase::where('jenisitem' , $jenis)->max('kode_item'); 

		$kodeitem = $id;
		$variable = explode("-", $kodeitem);
		$idvariable = $variable[0];



		if($idvariable == $jenis) {
			$iditem = $id;
		}
		else {

		$id=masterItemPurchase::where('jenisitem' , $jenis)->max('kode_item'); 
		
			if($id) {
				$string = explode("-",$id);
				$jumlah = $string[1] + 1;
				$iditem = $string[0] . '-' . $jumlah;

			
				$invID = str_pad($jumlah, 6, '0', STR_PAD_LEFT);

				$iditem = $jenis . "-" . $invID;
			}
			else {
				$iditem = $jenis . "-" .  '000001';
			}
		}



      /*  if($file != ""){

            $childPath = 'img/item/'.$id;
            $path = $childPath;
            $name = 'item-'.$id.'.'.$file->getClientOriginalExtension();
            
        
            if($data->foto != ""){     
               
               // if(File::delete(public_path().'/'.$pathPic)){
                    $file->move($path, $name);
                    $imgPath = $childPath.'/'.$name;
                    //return "okee1";
              //  }

            }
            else{
                $file->move($path, $name);
                $imgPath = $childPath.'/'.$name;
                //return $imgPath;
            }

            $data->foto = $imgPath;

        }
        else{
           
            $data->foto = $pathPic;
        }
*/
        $data->nama_masteritem = $request->nama_item;
    
		$jenisitem = $request->jenis_item;

		$data->jenisitem = $request->jenis_item;
		
        $data->minstock = $request->minimum_stock;
        $data->acc_persediaan = $request->acc_persediaan;
        $data->acc_hpp = $request->acc_hpp;
        $data->harga = $request->harga;
    	$data->kode_akun = $request->akun;
    	
	    $data->unit1 = $request->unit1;
    	
	   $data->unit2 = $request->unit2;
    	
        $data->unit3 = $request->unit3;
        $data->unitstock = $request->unit3;
       	if($request->konversi2 == '') {

		}else{
			$data->konversi2 = strtoupper(request()->konversi2);

		}
		if($request->konversi3 == ''){

		}
		else {
			$data->konversi3 = strtoupper(request()->konversi3);
		}

		if($request->posisilantai != ''){
			$data->posisilantai = strtoupper(request()->posisilantai);
		}
		if($request->posisiruang != ''){
			$data->posisiruang = strtoupper(request()->posisiruang);
		}
		if($request->posisirak != ''){
			$data->posisirak = strtoupper(request()->posisirak);
		}
		if($request->posisikolom != ''){
			$data->posisikolom = strtoupper(request()->posisikolom);
		}
      
		



		$data->kode_item = $iditem;

        $data->save();
         return redirect('masteritem/masteritem');
}

	public function deleteitem($id) {
		$f="img/item/".$id; 
        File::deleteDirectory($f);        
        $data2 = masterItemPurchase::find($id); 
      	$data2->delete($data2);

       Session::flash('sukses', 'data item berhasil dihapus');
        return redirect('masteritem/masteritem');
	}
	
	public function masterbank(){
		$data['bank'] = DB::select("select * from masterbank");
	//	dd($data);
		return view('purchase/master/masterbank/index', compact('data'));
	}

	public function createmasterbank(){

		$lastidbank = masterbank::max('mb_id'); 				
			if(isset($lastidbank)) {
			
					$idbank = $lastidbank;
					$idbank = (int)$lastidbank + 1;
			}
			else {
				$idbank = 1;	
			}

		$data['cabang'] = DB::select("select * from cabang");
		$data['bank'] = DB::select("select * from d_akun where  (id_akun LIKE '10%' or id_akun LIKE '11%') and id_akun NOT IN (select mb_kode from masterbank where mb_kode is NOT NULL) ") ;
	//	dd($data);
		return view('purchase/master/masterbank/create' , compact('data'));
	}

	public function updatemasterbank(Request $request){

		//update di header
		$data['header3'] = DB::table('masterbank')
							->where('mb_id' , $request->mb_id)
							->update([
								'mb_nama' => $request->nmbank,
								'mb_cabang' => $request->cabang,
								'mb_alamat' => $request->alamat,
								'mb_mshaktif' => $request->mshaktif,
								'mb_namarekening' => $request->namarekening,
								'mb_accno' => $request->norekening
							]);

		$tempdatafpg = 0;

		/*$idbank = $request->mb_id;
		for($hs = 0; $hs < count($request->noseridatabase); $hs++){
			$datambdt['database'] = DB::select("select * from masterbank_dt where mb_id = '$idbank'");
			for($hx = 0; $hx < count($datambdt['database']); $hx++){
				$noseri = $datambdt['database'][$hx]->mbdt_noseri;
				if($noseri){
					DB::delete("DELETE from  masterbank_dt where mb_id = '$idbbk'");	
				}
			}
		}


		for($h = 0; $h < count($request->noseridatabase); $h++){
			if($request->databasefpg[$h] != ' '){
				$tempdatafpg = $tempdatafpg + 1;
			}
		}*/

		
			if($request->input == 'CEK'){
				$banyaknyaseri = $request->nosericek;
				for($i = 10; $i < count($banyaknyaseri);$i++){
					$masterbankdt = new masterbank_dt();

					$lastidbankdt = masterbank_dt::max('mbdt_id'); 				
					if(isset($lastidbankdt)) {
					
							$idbankdt = $lastidbankdt;
							$idbankdt = (int)$lastidbankdt + 1;
						}
						else {
							$idbankdt = 1;
						
				 		}

					$masterbankdt->mbdt_kodebank = $request->kodebank;
					$masterbankdt->mbdt_noseri = $request->nosericek[$i];
					$masterbankdt->mbdt_noseri = $request->nosericek[$i];
					$masterbankdt->mbdt_id = $idbankdt;
					$masterbankdt->mbdt_seri = $request->seri;
					$masterbankdt->mbdt_idmb = $request->mb_id;
					$masterbankdt->save();

				}
			}
			else if($request->input == 'BG'){
				$banyaknyaseri = $request->noseribg;
				for($i = 10; $i < count($banyaknyaseri);$i++){
					$masterbankdt = new masterbank_dt();

					$lastidbankdt = masterbank_dt::max('mbdt_id'); 				
					if(isset($lastidbankdt)) {
					
							$idbankdt = $lastidbankdt;
							$idbankdt = (int)$lastidbankdt + 1;
						}
						else {
							$idbankdt = 1;
						
						}

					$masterbankdt->mbdt_kodebank = $request->kodebank;
					$masterbankdt->mbdt_noseri = strtoupper($request->noseribg[$i]);
					$masterbankdt->mbdt_noseri = strtoupper($request->noseribg[$i]);
					$masterbankdt->mbdt_id = $idbankdt;
					$masterbankdt->mbdt_seri = strtoupper($request->seri);
					$masterbankdt->mbdt_idmb = $request->mb_id;
					$masterbankdt->save();

				}
			}
			else if($request->input = 'centangdua'){
				$banyaknyasericek = $request->nosericek;
				$countcek = count($banyaknyasericek);
				$temp = 0;
				
				if($countcek % 25 == 0){
					$temp = 0;
				}else {
					$temp = 1;
				}

				$banyaknyaseribg = $request->noseribg;
				$countbg = count($banyaknyaseribg);
				$temp2 = 0;
				if($countbg % 25 == 0){
					$temp2 = 0;
				}
				else {
					$temp2 = 1;
				} 

				if($temp == 0){
					$varcek = 0;
				}
				else {
					$varcek = 10;
				}

				if($temp2 == 0){
					$varbg = 0;
				}
				else {
					$varbg = 10;
				}

			
				for($i = $varcek; $i < count($banyaknyasericek);$i++){
					$masterbankdt = new masterbank_dt();

					$lastidbankdt = masterbank_dt::max('mbdt_id'); 				
					if(isset($lastidbankdt)) {
					
							$idbankdt = $lastidbankdt;
							$idbankdt = (int)$lastidbankdt + 1;
						}
						else {
							$idbankdt = 1;
						
				 		}

					$masterbankdt->mbdt_kodebank = $request->kodebank;
					$masterbankdt->mbdt_noseri = strtoupper($request->nosericek[$i]);
					$masterbankdt->mbdt_noseri = strtoupper($request->nosericek[$i]);
					$masterbankdt->mbdt_id = $idbankdt;
					$masterbankdt->mbdt_seri = $request->seri;
					$masterbankdt->mbdt_idmb = $request->mb_id;
					$masterbankdt->save();

				}


				$banyaknyaseribg = $request->noseribg;
				for($i = $varbg; $i < count($banyaknyaseribg);$i++){
					$masterbankdt = new masterbank_dt();

					$lastidbankdt = masterbank_dt::max('mbdt_id'); 				
					if(isset($lastidbankdt)) {
					
							$idbankdt = $lastidbankdt;
							$idbankdt = (int)$lastidbankdt + 1;
						}
						else {
							$idbankdt = 1;
						
						}

					$masterbankdt->mbdt_kodebank = $request->kodebank;
					$masterbankdt->mbdt_noseri = strtoupper($request->noseribg[$i]);
					$masterbankdt->mbdt_noseri = strtoupper($request->noseribg[$i]);
					$masterbankdt->mbdt_id = $idbankdt;
					$masterbankdt->mbdt_seri = 'CEK&BG';
					$masterbankdt->mbdt_idmb = $request->mb_id;
					$masterbankdt->save();

				}
			}

		

		return json_encode('test');
	}

	public function detailbank($id){
		$data['bank'] = DB::select("select * from masterbank  where mb_id = '$id'");
		$data['bankdt'] = DB::select("select * from masterbank, masterbank_dt  where mbdt_idmb = mb_id and mbdt_idmb = '$id'");
		$data['banks'] = DB::select("select id_akun, nama_akun from d_akun where  id_akun LIKE '10%'or id_akun LIKE '11%'  ");
		//dd($data);

		return view('purchase/master/masterbank/detail' , compact('data'));

	}

	public function getkodeakunbank(Reqeust $request){
		$idbank = $request->idakun2;
		return 'suskes;';
	}

	public function savemasterbank(Request $request){
			

			$lastidbank = masterbank::max('mb_id'); 				
			if(isset($lastidbank)) {
			
					$idbank = $lastidbank;
					$idbank = (int)$lastidbank + 1;
				}
				else {
					$idbank = 1;
				
				}

			$idbank2 = $request->kodebank;

		$dka = DB::select("select akun_dka from d_akun where id_akun = '$idbank2' ");

		if($request->statusbg == 'BUKAN BG'){
			$masterbank = new masterbank();
			$masterbank->mb_id = $idbank;
			$masterbank->mb_kode = $request->kodebank;
			$masterbank->mb_nama = strtoupper($request->nmbank);
			$masterbank->mb_cabang = strtoupper($request->cabang);
			$masterbank->mb_accno = strtoupper($request->norekening);		
			$masterbank->mb_alamat = strtoupper($request->alamat);
			$masterbank->mb_namarekening = strtoupper($request->namarekening);
			$masterbank->mb_namarekening = strtoupper($request->namarekening);
			$masterbank->mb_bka = $dka[0]->akun_dka;
			$masterbank->save();
		}
		else {
		$masterbank = new masterbank();
		$masterbank->mb_id = $idbank;
		$masterbank->mb_kode = $request->kodebank;
		$masterbank->mb_nama = strtoupper($request->nmbank);
		$masterbank->mb_cabang = strtoupper($request->cabang);
		$masterbank->mb_accno = strtoupper($request->norekening);
		
		$masterbank->mb_alamat = strtoupper($request->alamat);
		if($request->input == 'CEK'){
			$masterbank->mb_sericek = strtoupper($request->sericek);
			$masterbank->mb_sericekawal =$request->awalsericek;
			$masterbank->mb_sericekakhir =$request->akhirsericek;
			$masterbank->mb_tglbukucek =  $request->tglbukucek;
			$masterbank->mb_kodebuktibank = $idbank;
			$masterbank->mb_mshaktif = $request->mshaktif;
		}
		elseif($request->input == 'BG'){
			$masterbank->mb_seribg = strtoupper($request->seribg);
			$masterbank->mb_seribgawal = strtoupper($request->awalseribg);
			$masterbank->mb_seribgakhir = strtoupper($request->akhirseribg);
			$masterbank->mb_tglbukubg =  $request->tglbukubg;
			$masterbank->mb_kodebuktibank = $idbank;
			$masterbank->mb_mshaktif = $request->mshaktif;
		}
		elseif($request->input == 'centangdua'){
			$masterbank->mb_seribg = strtoupper($request->seribg);
			$masterbank->mb_seribgawal = strtoupper($request->awalsericek);
			$masterbank->mb_seribgakhir =$request->akhirsericek;
			$masterbank->mb_tglbukubg =  $request->tglbukubg;
			$masterbank->mb_kodebuktibank = $idbank;
			$masterbank->mb_mshaktif = $request->mshaktif;

			$masterbank->mb_sericek = strtoupper($request->sericek);
			$masterbank->mb_sericekawal =$request->awalseribg;
			$masterbank->mb_sericekakhir =$request->akhirseribg;
			
			$masterbank->mb_tglbukucek =  $request->tglbukucek;
			$masterbank->mb_kodebuktibank = $idbank;
			$masterbank->mb_mshaktif = $request->mshaktif;
		}

			$masterbank->mb_namarekening = strtoupper($request->namarekening);
			$masterbank->mb_namarekening = strtoupper($request->namarekening);
			$masterbank->mb_bka = $dka[0]->akun_dka;
			$masterbank->save();


			if($request->input == 'CEK'){
			$banyaknyaseri = $request->nosericek;
			for($i = 10; $i < count($banyaknyaseri);$i++){
				$masterbankdt = new masterbank_dt();

				$lastidbankdt = masterbank_dt::max('mbdt_id'); 				
				if(isset($lastidbankdt)) {
				
						$idbankdt = $lastidbankdt;
						$idbankdt = (int)$lastidbankdt + 1;
					}
					else {
						$idbankdt = 1;
					
			 		}

				$masterbankdt->mbdt_kodebank = $request->kodebank;
				$masterbankdt->mbdt_noseri = $request->nosericek[$i];
				$masterbankdt->mbdt_noseri = $request->nosericek[$i];
				$masterbankdt->mbdt_id = $idbankdt;
				$masterbankdt->mbdt_seri = $request->seri;
				$masterbankdt->mbdt_idmb = $idbank;
				$masterbankdt->save();

			}
		}
		else if($request->input == 'BG'){
			$banyaknyaseri = $request->noseribg;
			for($i = 10; $i < count($banyaknyaseri);$i++){
				$masterbankdt = new masterbank_dt();

				$lastidbankdt = masterbank_dt::max('mbdt_id'); 				
				if(isset($lastidbankdt)) {
				
						$idbankdt = $lastidbankdt;
						$idbankdt = (int)$lastidbankdt + 1;
					}
					else {
						$idbankdt = 1;
					
					}

				$masterbankdt->mbdt_kodebank = $request->kodebank;
				$masterbankdt->mbdt_noseri = strtoupper($request->noseribg[$i]);
				$masterbankdt->mbdt_noseri = strtoupper($request->noseribg[$i]);
				$masterbankdt->mbdt_id = $idbankdt;
				$masterbankdt->mbdt_seri = strtoupper($request->seri);
				$masterbankdt->mbdt_idmb = $idbank;
				$masterbankdt->save();

			}
		}
		else if($request->input = 'centangdua'){
			$banyaknyasericek = $request->nosericek;
			$countcek = count($banyaknyasericek);
			$temp = 0;
			
			if($countcek % 25 == 0){
				$temp = 0;
			}else {
				$temp = 1;
			}

			$banyaknyaseribg = $request->noseribg;
			$countbg = count($banyaknyaseribg);
			$temp2 = 0;
			if($countbg % 25 == 0){
				$temp2 = 0;
			}
			else {
				$temp2 = 1;
			} 

			if($temp == 0){
				$varcek = 0;
			}
			else {
				$varcek = 10;
			}

			if($temp2 == 0){
				$varbg = 0;
			}
			else {
				$varbg = 10;
			}

		
			for($i = $varcek; $i < count($banyaknyasericek);$i++){
				$masterbankdt = new masterbank_dt();

				$lastidbankdt = masterbank_dt::max('mbdt_id'); 				
				if(isset($lastidbankdt)) {
				
						$idbankdt = $lastidbankdt;
						$idbankdt = (int)$lastidbankdt + 1;
					}
					else {
						$idbankdt = 1;
					
			 		}

				$masterbankdt->mbdt_kodebank = $request->kodebank;
				$masterbankdt->mbdt_noseri = strtoupper($request->nosericek[$i]);
				$masterbankdt->mbdt_noseri = strtoupper($request->nosericek[$i]);
				$masterbankdt->mbdt_id = $idbankdt;
				$masterbankdt->mbdt_seri = $request->seri;
				$masterbankdt->mbdt_idmb = $idbank;
				$masterbankdt->save();

			}


			$banyaknyaseribg = $request->noseribg;
			for($i = $varbg; $i < count($banyaknyaseribg);$i++){
				$masterbankdt = new masterbank_dt();

				$lastidbankdt = masterbank_dt::max('mbdt_id'); 				
				if(isset($lastidbankdt)) {
				
						$idbankdt = $lastidbankdt;
						$idbankdt = (int)$lastidbankdt + 1;
					}
					else {
						$idbankdt = 1;
					
					}

				$masterbankdt->mbdt_kodebank = $request->kodebank;
				$masterbankdt->mbdt_noseri = strtoupper($request->noseribg[$i]);
				$masterbankdt->mbdt_noseri = strtoupper($request->noseribg[$i]);
				$masterbankdt->mbdt_id = $idbankdt;
				$masterbankdt->mbdt_seri = 'CEK&BG';
				$masterbankdt->mbdt_idmb = $idbank;
				$masterbankdt->save();

			}
		}
			
		}

	//	dd($dka[0]->akun_dka);
		return json_encode("sukses");
	}


	public function deletebank($id) {

        $data = masterbank::find($id);        
        $data->delete($data);
        Session::flash('sukses', 'data item berhasil dihapus');
        return redirect('masterbank/masterbank');
		
	}

	public function masterpengajuansupplier() {
	}

	public function createmasterpengajuansupplier() {
	}

	public function mastersupplier() {

		
		
		$data = DB::select("select * from supplier, kota, provinsi where supplier.kota = kota.id and supplier.propinsi = provinsi.id and active='AKTIF'");

		return view('purchase/master/master_supplier/index', compact('data'));
	}
	
	public function getacchutang(Request $request) {
		$cabang = $request->cabang;

		$data = DB::select("select * from d_akun where id_akun LIKE '21%' and kode_cabang = '$cabang'");

		return json_encode($data);
	}


	public function createmastersupplier() {
		
		$data['cabang'] = master_cabang::all();
		$data['kota'] = master_kota::all();
		$data['provinsi'] = master_provinsi::all();
		$data['item'] = masterItemPurchase::all();

		return view('purchase/master/master_supplier/create', compact('data'));
	}

	public function ajax_kota($id){	
		/*$ajax = DB::select("select * from kota, provinsi where kota.id_provinsi = provinsi.id and kota.id_provinsi = $id ");*/
	
		$ajax = DB::table("kota")
                     ->where("id_provinsi",$id)
                     ->pluck("nama","id");


		return json_encode($ajax);
		/*return 'ana';*/
	}


	public function getnosupplier (Request $request){
		$cabang = $request->cabang;
		
		$supplier = DB::select("select * from supplier where idcabang = '$cabang'  order by idsup desc limit 1");
		
	
		
		
		if(count($supplier) > 0) {
	//		return $fpg[0]->fpg_nofpg;
			$explode = explode("/", $supplier[0]->no_supplier);
			$idsupplier1 = $explode[1];
			
		

			$idsupplier = (int)$idsupplier1 + 1;
			$data['idsupplier'] = str_pad($idsupplier, 6, '0', STR_PAD_LEFT);
			
		}

		else {
	
			$data['idsupplier'] = '000001';
		}

		return json_encode($data);
	
	}

	public function savesupplier(Request $request) {
		/*dd($request);*/
		$mastersupplier = new masterSupplierPurchase();
		$cabang = $request->cabang;
	/*	dd($request);*/
		$idsupplier=masterSupplierPurchase::max('no_supplier'); 
	/*	dd($idsupplier);*/
		$idsup = masterSupplierPurchase::max('idsup');


		if(isset($idsupplier)) {
		/*	dd('ana');
			dd($idsupplier);*/
			$string = explode("EM/",$idsupplier);
			
			$jumlah = $string[1] + 1;
			
			$invID = str_pad($jumlah, 6, '0', STR_PAD_LEFT);
			$no_supplier = 'SP/' . $cabang .'/' . $invID;
			
		}
		else {
			/*dd('supplier');*/
			$no_supplier = 'SP/EM/000001';
		}


		if(isset($idsup)){

			$idsup = (int)$idsup + 1;
		}
		else {
			$idsup = 1;
		}


		$status = 'BELUM DI SETUJUI';
		$statusactive = 'AKTIF';

		$replaceplafon = str_replace(',', '', $request->Plafon);

		$mastersupplier->idsup = $idsup;
		$mastersupplier->no_supplier = $request->nosupplier;
		$mastersupplier->nama_supplier = strtoupper($request->nama_supplier);
		$mastersupplier->alamat = strtoupper($request->alamat);
		$mastersupplier->kota = strtoupper($request->kota);
		$mastersupplier->telp = strtoupper($request->notelp);
		$mastersupplier->kota = strtoupper($request->kota);
		$mastersupplier->propinsi = strtoupper($request->provinsi);
		$mastersupplier->contact_person = strtoupper($request->number_cp);
		$mastersupplier->syarat_kredit = strtoupper($request->syarat_kredit);
		$mastersupplier->plafon = $replaceplafon;
		$mastersupplier->currency = strtoupper($request->matauang);
		$mastersupplier->pajak_npwp = strtoupper($request->npwp);
		$mastersupplier->kodepos = strtoupper($request->kodepos);
		$mastersupplier->idcabang = strtoupper($request->cabang);
		$mastersupplier->status = strtoupper($status);
		$mastersupplier->kontrak = $request->kontrak;
		$mastersupplier->nama_cp = $request->nm_cp;
		$mastersupplier->acc_hutang = $request->acc_hutangdagang;
		$mastersupplier->acc_csf = $request->acc_csf;
		$mastersupplier->active = $statusactive;
		$mastersupplier->nik = $request->nik;
		if($request->kontrak == 'YA') {
			$mastersupplier->no_kontrak = strtoupper($request->nokontrak);
		}
		else {
			$mastersupplier->no_kontrak = '';

		}

		if($request->pkp == 'Y'){
			$mastersupplier->namapajak = $request->namapajak;
			$mastersupplier->telppajak = $request->telppajak;
			$mastersupplier->alamatpajak = $request->alamatpajak;
			$mastersupplier->nik = $request->nik;
		}
		else {
			$mastersupplier->namapajak = null;
			$mastersupplier->telppajak = null;
			$mastersupplier->alamatpajak = null;
			$mastersupplier->nik = null;
		}
		$mastersupplier->save();


		

		
		$j = 0;
		for($i=0;$i<count($request->idbarang);$i++){
			$iditemsupplier=itemsupplier::max('is_id');


			if(isset($iditemsupplier)) {
				$iditem = $iditemsupplier;
				$iditem = (int)$iditemsupplier + 1;
			}

			else {
				$iditem = 1;
			}

			$itemsupplier = new itemsupplier();	
			$stringharga = $request->harga[$i];
			$replacehrg = str_replace(',', '', $stringharga);

			$itemsupplier->is_id = $iditem;
			$itemsupplier->is_kodeitem = $request->idbarang[$i];
			$itemsupplier->is_supplier = $no_supplier;
			$itemsupplier->is_harga = $replacehrg;
			$itemsupplier->is_idsup = $mastersupplier->idsup;
			$itemsupplier->is_updatestock = $request->updatestock[$i];

			$itemsupplier->save();
		}

		return redirect('mastersupplier/mastersupplier');
	}



	public function editsupplier($id) {
		$data = DB::select("select *, cabang.nama as namacabang from supplier, kota, provinsi where supplier.kota = kota.id and supplier.propinsi = provinsi.id and supplier.no_supplier = '$id'");
		
		return view('purchase/master/master_supplier/edit', compact('data'));
	}

	public function detailsupplier($id) {



		$data['supplier'] = DB::select("select *, cabang.nama as namacabang, cabang.kode as kodecabang, supplier.alamat as alamatsupplier from supplier, cabang, kota, provinsi where supplier.kota = kota.id and supplier.propinsi = provinsi.id and supplier.idsup = '$id' and idcabang = kode");
		$data['item_supplier'] = DB::select("select * from itemsupplier,masteritem where is_idsup = '$id' and is_kodeitem = kode_item");
		$data['countitem'] = count($data['item_supplier']);
		$data['barang'] = masterItemPurchase::all();
		$data['cabang'] = master_cabang::all();
			$data['item'] = masterItemPurchase::all();
				$data['kota'] = master_kota::all();
		$data['provinsi'] = master_provinsi::all();
		$cabang = $data['supplier'][0]->kodecabang;
		$data['mastersup'] = DB::select("select * from d_akun where id_akun LIKE '21%' and kode_cabang = '$cabang'");


		
		return view('purchase/master/master_supplier/detail', compact('data'));
	}

	public function updatesupplier($id, Request $request) {
	/*	dd($request);*/
		/*	*/

		if($request->iskontrak == 'tdkeditkontrak') {	
			$replaceplafon = str_replace(',', '', $request->plafon_kredit);

		/*dd('sama');*/
			$statusactive = 'AKTIF';
			$data = masterSupplierPurchase::find($id);
			$data->nama_supplier = strtoupper($request->nama_supplier);
			$data->no_supplier = strtoupper($request->nosupplier);
			$data->alamat = strtoupper($request->alamat);
			$data->kota = strtoupper($request->kota);
			$data->telp = strtoupper($request->notelp);
			$data->kota = strtoupper($request->kota);
			$data->propinsi = strtoupper($request->provinsi);
			$data->contact_person = strtoupper($request->cp);
			$data->syarat_kredit = strtoupper($request->syarat_kredit);
			$data->plafon = strtoupper($replaceplafon);
			$data->currency = strtoupper($request->matauang);
			$data->pajak_npwp = strtoupper($request->npwp);
		
			$data->kodepos = strtoupper($request->kodepos);
			$data->idcabang = strtoupper($request->idcabang);
			$data->kontrak = strtoupper($request->kontrak);	
			$data->nama_cp = $request->nm_cp;
			$data->acc_hutang = $request->acc_hutangdagang;
			$data->acc_csf = $request->acc_csf;
			$data->active = $statusactive;

			if($request->nokontrak != '') {
				$data->no_kontrak = strtoupper($request->nokontrak);
			}

			if($request->pkp == 'Y'){
				$data->namapajak = $request->namapajak;
				$data->telppajak = $request->telppajak;
				$data->alamatpajak = $request->alamatpajak;

			}
			else {
				$data->namapajak = null;
				$data->telppajak = null;
				$data->alamatpajak = null;
				$data->noseri_pajak = null;
				$data->pajak_npwp = null;
			}
			$data->save();

			if($data->kontrak == 'TIDAK'){
				$idsupplier = $request->idsupplier;
				DB::delete("DELETE from  itemsupplier where is_idsup = '$idsupplier'");	
			}
			else if($data->kontrak == 'YA'){
				for($i=0; $i<count($request->brg); $i++){
				
				if(count($request->databarang) > 0) {
					$iditemsup = itemsupplier::max('is_id');

					if(isset($iditemsup)){
						$iditemsup = (int)$iditemsup + 1;
					}
					else {
						$iditemsup = 1;
					}

					//echo($iditemsup);
					$itemsupplier = new itemsupplier();
					$replacehrga = str_replace(',', '', $request->harga[$i]);
				//	dd($replacehrga);
					$itemsupplier->is_id =$iditemsup;
					$itemsupplier->is_kodeitem = strtoupper($request->brg[$i]);
					$itemsupplier->is_harga = $replacehrga;
					$itemsupplier->is_supplier = strtoupper($request->nosupplier);
					$itemsupplier->is_idsup = $data->idsup;
					$itemsupplier->is_updatestock = $request->updatestock[$i];
					$itemsupplier->save();
				}
				else {
				if(empty($request->iditemsup[$i])){
				//	dd('ok');
					$iditemsup = itemsupplier::max('is_id');

					if(isset($iditemsup)){
						$iditemsup = (int)$iditemsup + 1;
					}
					else {
						$iditemsup = 1;
					}

				//	echo($iditemsup);
					$itemsupplier = new itemsupplier();
					$replacehrga = str_replace(',', '', $request->harga[$i]);
				//	dd($replacehrga);
					$itemsupplier->is_id =$iditemsup;
					$itemsupplier->is_kodeitem = strtoupper($request->brg[$i]);
					$itemsupplier->is_harga = $replacehrga;
					$itemsupplier->is_supplier = strtoupper($request->nosupplier);
					$itemsupplier->is_idsup = $data->idsup;
					$itemsupplier->is_updatestock = $request->updatestock[$i];
					$itemsupplier->save();

				}
				else {
				//	echo($request->iditemsup[$i]);
					$updateitem = itemsupplier::where([['is_id', '=', $request->iditemsup[$i]] , ['is_idsup' , '=' , $request->idsupplier]]);
					$replacehrg = str_replace(',', '', $request->harga[$i]);
				//	dd($replacehrg);
					$updateitem->update([
						'is_kodeitem' => $request->brg[$i],
						'is_harga' => $replacehrg
					]);

				}
			}
			}
			}

			
		}
		else{
		/*	dd('tdksama');*/
				$idsup = masterSupplierPurchase::max('idsup');

				if(isset($idsup)){

					$idsup = (int)$idsup + 1;
				}
				else {
					$idsup = 1;
				}

			$status = 'BELUM DI SETUJUI';
			$aktif = 'AKTIF';

			
			$mastersupplier = new masterSupplierPurchase();

			$mastersupplier->no_supplier = strtoupper($request->nosupplier);
			$mastersupplier->idsup = $idsup;
			$mastersupplier->nama_supplier = strtoupper($request->nama_supplier);
			$mastersupplier->alamat = strtoupper($request->alamat);
			$mastersupplier->kota = strtoupper($request->kota);
			$mastersupplier->telp = strtoupper($request->notelp);
			$mastersupplier->kota = strtoupper($request->kota);
			$mastersupplier->propinsi = strtoupper($request->provinsi);
			$mastersupplier->contact_person = strtoupper($request->cp);
			$mastersupplier->syarat_kredit = strtoupper($request->syarat_kredit);
			$mastersupplier->plafon = strtoupper($request->plafon_kredit);
			$mastersupplier->currency = strtoupper($request->matauang);
			$mastersupplier->pajak_npwp = strtoupper($request->npwp);

			$mastersupplier->kodepos = strtoupper($request->kodepos);
			$mastersupplier->status = strtoupper($status);
			$mastersupplier->kontrak = $request->kontrak;
			$mastersupplier->idcabang = $request->idcabang;
			$mastersupplier->nama_cp = $request->nm_cp;
			$mastersupplier->active = $aktif;

			
			$data->acc_hutang = $request->acc_hutangdagang;
			$data->acc_csf = $request->acc_csf;
			

			if($request->kontrak == 'YA') {
				$mastersupplier->no_kontrak = strtoupper($request->no_kontrak);
			}
			else {
				$mastersupplier->no_kontrak = '';

			}
			$mastersupplier->save();	


			for($j=0; $j < count($request->brg); $j++){
				$itemsupplier = new itemsupplier();

					//menghitung id sppdt
				$lastiditem = itemsupplier::max('is_id'); 				
				if(isset($lastiditem)) {
				
					$idis = $lastiditem;
					$idis = (int)$lastiditem + 1;
				}
				else {
					$idis = 1;
				
				}

				$replacehrga = str_replace(',', '', $request->harga[$j]);
		//	dd($replacehrga);
				$itemsupplier->is_id =$idis;
				$itemsupplier->is_kodeitem = strtoupper($request->brg[$j]);
				$itemsupplier->is_harga = $replacehrga;
				$itemsupplier->is_supplier = strtoupper($request->nosupplier);
				$itemsupplier->is_idsup = $idsup;
				$itemsupplier->save();

				$updateitem = masterSupplierPurchase::where([['no_supplier', '=', $request->nosupplier], ['idsup' , '<>' , $idsup ]] );

				$statusaktif = 'TIDAK AKTIF';

				$updateitem->update([
				 	'active' => $statusaktif,
				 //	'sppd_qtyrequest' => $request->qtyrequest[$n],	
			 	]);	
			}
		}

	//	Session::flash('sukses', 'data item baru anda berhasil disimpan');
         return redirect('mastersupplier/mastersupplier');
	}

	public function deletesupplier($id) {

        $data = masterSupplierPurchase::find($id);        
        $data->delete($data);
        Session::flash('sukses', 'data item berhasil dihapus');
        return redirect('mastersupplier/mastersupplier');
		
	}


	public function konfirmasisupplier() {
		$data['supp'] = DB::select("select * from supplier, kota, provinsi where supplier.kota = kota.id and supplier.propinsi = provinsi.id");

		$data['disetujui'] = DB::table("supplier")->where('status' , '=' , 'SETUJU')->count();
		$data['belumdisetujui'] = DB::table("supplier")->where('status' , '=' , 'BELUM DI SETUJUI')->count();
		$data['tidakdisetujui'] = DB::table("supplier")->where('status' , '=' , 'TIDAK SETUJU')->count();
		return view('purchase/master/master_supplier/index_konfirmasi', compact('data'));
	}

	public function updatekonfirmasisupplier($id, Request $request){

		/*dd($request);*/
		if($request->iskontrak == 'tdkeditkontrak') {	
			$replaceplafon = str_replace(',', '', $request->plafon_kredit);

		/*dd('sama');*/
			$statusactive = 'AKTIF';
			$data = masterSupplierPurchase::find($id);
			$data->nama_supplier = strtoupper($request->nama_supplier);
			$data->no_supplier = strtoupper($request->nosupplier);
			$data->alamat = strtoupper($request->alamat);
			$data->kota = strtoupper($request->kota);
			$data->telp = strtoupper($request->notelp);
			$data->kota = strtoupper($request->kota);
			$data->propinsi = strtoupper($request->provinsi);
			$data->contact_person = strtoupper($request->cp);
			$data->syarat_kredit = strtoupper($request->syarat_kredit);
			$data->plafon = strtoupper($replaceplafon);
			$data->currency = strtoupper($request->matauang);
			$data->pajak_npwp = strtoupper($request->npwp);
			
			$data->kodepos = strtoupper($request->kodepos);
			$data->idcabang = strtoupper($request->idcabang);
			$data->kontrak = strtoupper($request->kontrak);	
			$data->nama_cp = $request->nm_cp;
			$data->acc_hutang = $request->acc_hutangdagang;
			$data->acc_csf = $request->acc_csf;
			$data->active = $statusactive;
			$data->status = $request->setuju;

			if($request->nokontrak != '') {
				$data->no_kontrak = strtoupper($request->nokontrak);
			}

			if($request->pkp == 'Y'){
				$data->namapajak = $request->namapajak;
				$data->telppajak = $request->telppajak;
				$data->alamatpajak = $request->alamatpajak;

			}
			else {
				$data->namapajak = null;
				$data->telppajak = null;
				$data->alamatpajak = null;
				
				$data->pajak_npwp = null;
			}
			$data->save();

			if($data->kontrak == 'TIDAK'){
				$idsupplier = $request->idsupplier;
				DB::delete("DELETE from  itemsupplier where is_idsup = '$idsupplier'");	
			}
			else if($data->kontrak == 'YA'){
				for($i=0; $i<count($request->brg); $i++){
				
				if(count($request->databarang) > 0) {
					$iditemsup = itemsupplier::max('is_id');

					if(isset($iditemsup)){
						$iditemsup = (int)$iditemsup + 1;
					}
					else {
						$iditemsup = 1;
					}

					//echo($iditemsup);
					$itemsupplier = new itemsupplier();
					$replacehrga = str_replace(',', '', $request->harga[$i]);
				//	dd($replacehrga);
					$itemsupplier->is_id =$iditemsup;
					$itemsupplier->is_kodeitem = strtoupper($request->brg[$i]);
					$itemsupplier->is_harga = $replacehrga;
					$itemsupplier->is_supplier = strtoupper($request->nosupplier);
					$itemsupplier->is_idsup = $data->idsup;
					$itemsupplier->is_updatestock = $request->updatestock[$i];
					$itemsupplier->save();
				}
				else {
				if(empty($request->iditemsup[$i])){
				//	dd('ok');
					$iditemsup = itemsupplier::max('is_id');

					if(isset($iditemsup)){
						$iditemsup = (int)$iditemsup + 1;
					}
					else {
						$iditemsup = 1;
					}

				//	echo($iditemsup);
					$itemsupplier = new itemsupplier();
					$replacehrga = str_replace(',', '', $request->harga[$i]);
				//	dd($replacehrga);
					$itemsupplier->is_id =$iditemsup;
					$itemsupplier->is_kodeitem = strtoupper($request->brg[$i]);
					$itemsupplier->is_harga = $replacehrga;
					$itemsupplier->is_supplier = strtoupper($request->nosupplier);
					$itemsupplier->is_idsup = $data->idsup;
					$itemsupplier->is_updatestock = $request->updatestock[$i];
					$itemsupplier->save();

				}
				else {
				//	echo($request->iditemsup[$i]);
					$updateitem = itemsupplier::where([['is_id', '=', $request->iditemsup[$i]] , ['is_idsup' , '=' , $request->idsupplier]]);
					$replacehrg = str_replace(',', '', $request->harga[$i]);
				//	dd($replacehrg);
					$updateitem->update([
						'is_kodeitem' => $request->brg[$i],
						'is_harga' => $replacehrg
					]);

				}
			}
			}
			}

			
		}
		else{
		/*	dd('tdksama');*/
				$idsup = masterSupplierPurchase::max('idsup');

				if(isset($idsup)){

					$idsup = (int)$idsup + 1;
				}
				else {
					$idsup = 1;
				}

			$status = 'BELUM DI SETUJUI';
			$aktif = 'AKTIF';

			
			$mastersupplier = new masterSupplierPurchase();

			$mastersupplier->no_supplier = strtoupper($request->nosupplier);
			$mastersupplier->idsup = $idsup;
			$mastersupplier->nama_supplier = strtoupper($request->nama_supplier);
			$mastersupplier->alamat = strtoupper($request->alamat);
			$mastersupplier->kota = strtoupper($request->kota);
			$mastersupplier->telp = strtoupper($request->notelp);
			$mastersupplier->kota = strtoupper($request->kota);
			$mastersupplier->propinsi = strtoupper($request->provinsi);
			$mastersupplier->contact_person = strtoupper($request->cp);
			$mastersupplier->syarat_kredit = strtoupper($request->syarat_kredit);
			$mastersupplier->plafon = strtoupper($request->plafon_kredit);
			$mastersupplier->currency = strtoupper($request->matauang);
			$mastersupplier->pajak_npwp = strtoupper($request->npwp);
	
			$mastersupplier->kodepos = strtoupper($request->kodepos);
			$mastersupplier->status = strtoupper($status);
			$mastersupplier->kontrak = $request->kontrak;
			$mastersupplier->idcabang = $request->idcabang;
			$mastersupplier->nama_cp = $request->nm_cp;
			$mastersupplier->active = $aktif;			
			$data->acc_hutang = $request->acc_hutangdagang;
			$data->acc_csf = $request->acc_csf;
			

			if($request->kontrak == 'YA') {
				$mastersupplier->no_kontrak = strtoupper($request->no_kontrak);
			}
			else {
				$mastersupplier->no_kontrak = '';

			}
			$mastersupplier->save();	


			for($j=0; $j < count($request->brg); $j++){
				$itemsupplier = new itemsupplier();

					//menghitung id sppdt
				$lastiditem = itemsupplier::max('is_id'); 				
				if(isset($lastiditem)) {
				
					$idis = $lastiditem;
					$idis = (int)$lastiditem + 1;
				}
				else {
					$idis = 1;
				
				}

				$replacehrga = str_replace(',', '', $request->harga[$j]);
		//	dd($replacehrga);
				$itemsupplier->is_id =$idis;
				$itemsupplier->is_kodeitem = strtoupper($request->brg[$j]);
				$itemsupplier->is_harga = $replacehrga;
				$itemsupplier->is_supplier = strtoupper($request->nosupplier);
				$itemsupplier->is_idsup = $idsup;
				$itemsupplier->save();

				$updateitem = masterSupplierPurchase::where([['no_supplier', '=', $request->nosupplier], ['idsup' , '<>' , $idsup ]] );

				$statusaktif = 'TIDAK AKTIF';

				$updateitem->update([
				 	'active' => $statusaktif,
				 //	'sppd_qtyrequest' => $request->qtyrequest[$n],	
			 	]);	
			}
		}
		Session::flash('sukses', 'data item baru anda berhasil disimpan');
        return redirect('konfirmasisupplier/konfirmasisupplier');
	}

	public function detailkonfirmasisupplier($id) {
		$data['supplier'] = DB::select("select *, cabang.nama as namacabang, cabang.kode as kodecabang, supplier.alamat as alamatsupplier from supplier, cabang, kota, provinsi where supplier.kota = kota.id and supplier.propinsi = provinsi.id and supplier.idsup = '$id' and idcabang = kode");
		$data['item_supplier'] = DB::select("select * from itemsupplier,masteritem where is_idsup = '$id' and is_kodeitem = kode_item");
		$data['countitem'] = count($data['item_supplier']);
		$data['barang'] = masterItemPurchase::all();
		$data['cabang'] = master_cabang::all();
			$data['item'] = masterItemPurchase::all();
				$data['kota'] = master_kota::all();
		$data['provinsi'] = master_provinsi::all();
		$cabang = $data['supplier'][0]->kodecabang;
		$data['mastersup'] = DB::select("select * from d_akun where id_akun LIKE '21%' and kode_cabang = '$cabang'");
		
		return view('purchase/master/master_supplier/detail_konfirmasi', compact('data'));
	}
	
	public function masterdepartment() {

		$data = master_department::all();
		return view('purchase/master/master_department/index', compact('data'));
	}
	
	public function createmasterdepartment() {
		$iddepartment=master_department::max('kode_department'); 
/*
			if(isset($iddepartment)) {
				$explode = explode("-", $iddepartment);
				$iddepartment = $explode[1];
				$iddepartment = (int)$iddepartment + 1;
				$string = str_pad($iddepartment, 3, '0', STR_PAD_LEFT);
				$iddepartment = 'B' .'-'. $string;
			}
			else {
				$iddepartment = 'B-001';
					
			}*/

		return view('purchase/master/master_department/create');
	}

	public function detailmasterdepartment($id) {
		$data = DB::select("select * from masterdepartment where kode_department = '$id'");

		return view('purchase/master/master_department/detail', compact('data'));
	}

	public function deletemasterdepartment($id) {
		$data = master_department::find($id);        
        $data->delete($data);
	    Session::flash('sukses', 'data item berhasil dihapus');

		return redirect('masterdepartment/masterdepartment');
	}

	public function savemasterdepartment(Request $request) {
		$data = new master_department();

		$data->kode_department = strtoupper($request->kode_department);
		$data->nama_department = strtoupper($request->keterangan);
		$data->save();

		 return redirect('masterdepartment/masterdepartment');
	}

	public function updatemasterdepartment($id, Request $request) {
		$data = master_department::find($id);
		$data->nama_department = strtoupper($request->keterangan);
		$data->save();
		Session::flash('sukses', 'data item baru anda berhasil disimpan');

        return redirect('masterdepartment/masterdepartment');
	}

	public function masterjenisitem() {
		if(Auth::user()->punyaAkses('Master Group Item','all')){
			$data = masterJenisItemPurchase::all();
		}else{
			$data = masterJenisItemPurchase::all();
		}

		return view('purchase/master/master_jenisitem/index', compact('data'));
	}
	
	public function createmasterjenisitem() {
		
		return view('purchase/master/master_jenisitem/create');
	}

	public function detailmasterjenisitem($id) {
		$data = DB::select("select * from jenis_item where kode_jenisitem = '$id'");

		return view('purchase/master/master_jenisitem/detail', compact('data'));
	}

	public function savemasterjenisitem(Request $request) {
		$data = new masterJenisItemPurchase();
		$data->kode_jenisitem = strtoupper($request->kodejenisitem);
		$data->keterangan_jenisitem = strtoupper($request->keterangan);
		$data->stock = $request->penerimaan;
		$data->save();

		return redirect('masterjenisitem/masterjenisitem');
	}

	public function updatemasterjenisitem($id, Request $request) {
		$data = masterJenisItemPurchase::find($id);
		$data->keterangan_jenisitem = strtoupper($request->keterangan);
		$data->stock = $request->penerimaan;
		$data->save();
		Session::flash('sukses', 'data item baru anda berhasil disimpan');
		return redirect('masterjenisitem/masterjenisitem');
	}

	public function deletemasterjenisitem($id) {
		$data = masterJenisItemPurchase::find($id);        
        $data->delete($data);
	    Session::flash('sukses', 'data item berhasil dihapus');

		

		return redirect('masterjenisitem/masterjenisitem');
	}

	public function kodejenisitem(Request $request){
		$kode = strtoupper($request->kode);

		$data = DB::select("select * from jenis_item where kode_jenisitem = '$kode'");

		return $data;
	}

	// Fungsi-Fungsi Golongan Aktiva Mulai Dari Sini

	public function masteractiva($cabang) {
		if(!Auth::user()->PunyaAkses('Master Activa','all') && $cabang != Session::get("cabang")){
			return redirect(url("masteractiva/masteractiva/".Session::get("cabang")));
		}

		if(Auth::user()->PunyaAkses('Master Activa','all')){
			$cab  = DB::table('cabang')
                	->select("kode", "nama")->get();
        }else{
        	$cab  = DB::table('cabang')
                	->select("kode", "nama")
                	->where("kode", Session::get("cabang"))->get();
        }

        $data = DB::table('d_master_aktiva')
        		->join('d_golongan_aktiva', 'd_golongan_aktiva.id', "=", "d_master_aktiva.kode_golongan")
        		->where("d_master_aktiva.kode_cabang", $cabang)
        		->select("d_master_aktiva.nama_aktiva", "d_golongan_aktiva.nama_golongan", "d_master_aktiva.nilai_perolehan", "d_master_aktiva.tanggal_perolehan", "d_golongan_aktiva.persentase_garis_lurus", "d_golongan_aktiva.persentase_saldo_menurun", "d_master_aktiva.kode_cabang", "d_master_aktiva.id")->get();

        // return $data;

		return view('purchase/master/master_activa/index')->withCab($cab)->withData($data)->withCabang($cabang);;
	}
	
	public function createmasteractiva() {
		if(Auth::user()->PunyaAkses('Master Activa','cabang')){
			$cab = DB::table("cabang")->select("kode", "nama")->get();
			$gol = DB::table("d_golongan_aktiva")->select("*")->get();
		}else{
			$cab = DB::table("cabang")->select("kode", "nama")->where("kode", Session::get("cabang"))->get();
			$gol = DB::table("d_golongan_aktiva")->where("kode_cabang", Session::get('cabang'))->select("*")->get();
		}

		$akun = DB::table("d_akun")
					->whereNotIn("id_akun", function($query){
			    		$query->select("id_parrent")
			    			  ->whereNotNull("id_parrent")
			    			  ->from("d_akun")->get();
			    	})->select(["id_akun", "nama_akun"])->get();

		return view('purchase/master/master_activa/create')->withCab($cab)->withGol(json_encode($gol))->withAkun($akun);
	}

	public function editmasteractiva($cabang, $id){
		$data = DB::table("d_master_aktiva")
				->join("cabang", "cabang.kode", "=", "d_master_aktiva.kode_cabang")
				->join("d_golongan_aktiva", "d_master_aktiva.kode_golongan", "=", "d_golongan_aktiva.id")
				->where("d_master_aktiva.id", $id)
				->where("d_master_aktiva.kode_cabang", $cabang)
				->select("d_master_aktiva.*", "d_golongan_aktiva.nama_golongan", "d_golongan_aktiva.masa_manfaat_garis_lurus", "d_golongan_aktiva.persentase_garis_lurus", "d_golongan_aktiva.masa_manfaat_saldo_menurun", "d_golongan_aktiva.persentase_saldo_menurun", "cabang.nama")->first();

		// return json_encode($data);

		return view('purchase/master/master_activa/edit')->withData($data);
	}

	public function aktiva_save(Request $request){
		// return json_encode($request->all());
		$response = [
			"status"	=> "sukses",
			"content"	=> null
		];

		$cek = DB::table("d_master_aktiva")->where("kode_cabang", $request->cabang)->where("id", $request->kode_golongan)->get();

		// return $cek;

		if(count($cek) > 0){
			$response = [
				"status" 	=> "exist",
				"content"	=> null
			];

			return json_encode($response);
		}

		$aktiva = new d_master_aktiva;
		$aktiva->id = $request->kode_aktiva;
		$aktiva->kode_cabang = $request->cabang;
		$aktiva->nama_aktiva = $request->nama_aktiva;
		$aktiva->tanggal_perolehan = $request->tanggal_perolehan;
		$aktiva->nilai_perolehan = str_replace('.', '', explode(',', $request->nilai_perolehan)[0]);
		$aktiva->acc_debet = $request->acc_debet;
		$aktiva->csf_kredit = $request->csf_kredit;
		$aktiva->keterangan = $request->keterangan;
		$aktiva->kode_golongan = $request->kode_golongan;

		if($aktiva->save())
			return json_encode($response);
	}

	public function aktiva_update(Request $request){
		// return json_encode($request->all());

		$response = [
			"status"	=> "sukses",
			"content"	=> null
		];

		DB::table("d_master_aktiva")->where("kode_cabang", $request->kode_cabang)->where("id", $request->kode_aktiva)->update([
			"nama_aktiva" => $request->nama_aktiva,
			"keterangan" => $request->keterangan
		]);
		
		return json_encode($response);
	}

	public function aktiva_hapus($cabang, $id){
		DB::table("d_master_aktiva")
			->join("cabang", "cabang.kode", "=", "d_master_aktiva.kode_cabang")
			->where("id", $id)
			->where("kode_cabang", $cabang)
			->select("d_master_aktiva.*", "cabang.nama")->delete();

		Session::flash('sukses', 'Data Berhasil Dihapus...');
		return redirect(url("masteractiva/masteractiva/".Session::get("cabang")));
	}

	public function ask_kode_activa($cabang){
		$data = DB::table("d_master_aktiva")
				->select(DB::raw("max(to_number(substring(id, 6), '99G999D9S')) as id"))
				->where("kode_cabang", $cabang)->first();

		$response = (count($data) > 0) ? ($data->id + 1) : $data->id;

		return json_encode($response);
	}

	// Fungsi-Fungsi master Aktiva Berhenti Dari Sini

	public function detailmasteractiva() {
		return view('purchase/master/master_activa/detail');
	}
	
	public function detailgarislurusmasteractiva() {
		return view('purchase/master/master_activa/detailgarislurus');
	}

	public function detailsaldomenurunmasteractiva() {
		return view('purchase/master/master_activa/detailsaldomenurun');
	}


	// Fungsi-Fungsi Golongan Aktiva Mulai Dari Sini

	public function golonganactiva($cabang) {

		if(!Auth::user()->PunyaAkses('Golongan Activa','all') && $cabang != Session::get("cabang")){
			return redirect(url("golonganactiva/golonganactiva/".Session::get("cabang")));
		}

		if(Auth::user()->PunyaAkses('Golongan Activa','all')){
			$cab  = DB::table('cabang')
                	->select("kode", "nama")->get();
        }else{
        	$cab  = DB::table('cabang')
                	->select("kode", "nama")
                	->where("kode", Session::get("cabang"))->get();
        }

        $data = DB::table('d_golongan_aktiva')->where("kode_cabang", $cabang)->get();

		return view('purchase/master/golongan_activa/index')->withCab($cab)->withData($data)->withCabang($cabang);
	}

	public function creategolonganactiva() {

		if(Auth::user()->PunyaAkses('Golongan Activa','cabang')){
			$cab = DB::table("cabang")->select("kode", "nama")->get();
		}else{
			$cab = DB::table("cabang")->select("kode", "nama")->where("kode", Session::get("cabang"))->get();
		}

		return view('purchase/master/golongan_activa/create')->withCab($cab);
	}

	public function editgolonganactiva($cabang, $id){
		$data = DB::table("d_golongan_aktiva")
				->join("cabang", "cabang.kode", "=", "d_golongan_aktiva.kode_cabang")
				->where("id", $id)
				->where("kode_cabang", $cabang)
				->select("d_golongan_aktiva.*", "cabang.nama")->first();
		return view('purchase/master/golongan_activa/edit')->withData($data);
	}

	public function ask_kode($cabang){
		$data = DB::table("d_golongan_aktiva")
				->select(DB::raw("max(to_number(substring(id, 6), '99G999D9S')) as id"))
				->where("kode_cabang", $cabang)->first();

		$response = (count($data) > 0) ? ($data->id + 1) : $data->id;

		return json_encode($response);
	}

	public function golongan_save(Request $request){
		// return json_encode($request->all());

		$response = [
			"status"	=> "sukses",
			"content"	=> null
		];

		$cek = DB::table("d_golongan_aktiva")->where("kode_cabang", $request->cabang)->where("id", $request->kode_golongan)->get();

		// return $cek;

		if(count($cek) > 0){
			$response = [
				"status" 	=> "exist",
				"content"	=> null
			];

			return json_encode($response);
		}

		$golongan = new d_golongan_aktiva;
		$golongan->id = $request->kode_golongan;
		$golongan->kode_cabang = $request->cabang;
		$golongan->nama_golongan = $request->nama_golongan;
		$golongan->keterangan_golongan = $request->keterangan;
		$golongan->masa_manfaat = $request->masa_manfaat;
		$golongan->fiskal_komersial = $request->s_k;
		$golongan->masa_manfaat_garis_lurus = $request->masa_manfaat_gl;
		$golongan->persentase_garis_lurus = $request->persentase_gl;
		$golongan->masa_manfaat_saldo_menurun = $request->masa_manfaat_sm;
		$golongan->persentase_saldo_menurun = $request->persentase_sm;

		if($golongan->save())
			return json_encode($response);
	}

	public function golongan_update(Request $request){
		// return json_encode($request->all());

		$response = [
			"status"	=> "sukses",
			"content"	=> null
		];

		DB::table("d_golongan_aktiva")->where("kode_cabang", $request->kode_cabang)->where("id", $request->kode_golongan)->update([
			"nama_golongan" => $request->nama_golongan,
			"keterangan_golongan" => $request->keterangan
		]);
		
		return json_encode($response);
	}

	public function golongan_hapus($cabang, $id){
		DB::table("d_golongan_aktiva")
			->join("cabang", "cabang.kode", "=", "d_golongan_aktiva.kode_cabang")
			->where("id", $id)
			->where("kode_cabang", $cabang)
			->select("d_golongan_aktiva.*", "cabang.nama")->delete();

		Session::flash('sukses', 'Data Berhasil Dihapus...');
		return redirect(url("golonganactiva/golonganactiva/".Session::get("cabang")));
	}

	// Fungsi-Fungsi Golongan Aktiva Berhenti Dari Sini

	public function nota_debit() {
		return view('purchase/master/nota_debit/index');
	}
	
	public function createnota_debit() {
		return view('purchase/master/nota_debit/create');
	}

	public function detailnota_debit() {
		return view('purchase/master/nota_debit/detail');
	}


	public function master_barang() {
		return view('purchase/master/master_barang/index');
	}
	
	public function createmaster_barang() {
		return view('purchase/master/master_barang/create');
	}

	public function detailmaster_barang() {
		return view('purchase/master/master_barang/detail');
	}


	public function jeniskendaraan() {
		return view('purchase/master/jeniskendaraan/index');
	}
	
	public function createjeniskendaraan() {
		return view('purchase/master/jeniskendaraan/create');
	}

	public function detailjeniskendaraan() {
		return view('purchase/master/jeniskendaraan/detail');
	}


	public function modelkendaraan() {
		return view('purchase/master/modelkendaraan/index');
	}
	
	public function createmodelkendaraan() {
		return view('purchase/master/modelkendaraan/create');
	}

	public function detailmodelkendaraan() {
		return view('purchase/master/modelkendaraan/detail');
	}

	public function mastergudang() {
		$data['mastergudang'] = DB::select("select * from mastergudang, cabang where mg_cabang = kode");

		return view('purchase/master/master_gudang/index', compact('data'));
	}

	public function deletegudang($id) {
		       
        $data2 = masterGudangPurchase::find($id); 
      	$data2->delete($data2);
       Session::flash('sukses', 'data item berhasil dihapus');
        return redirect('mastergudang/mastergudang');
	}

	public function savemastergudang(Request $request){
		

		$id=masterGudangPurchase::max('mg_id'); 
		//dd($id);
		if(isset($id)){
			$idgudang = (int)$id + 1;
		}
		else{
			
			$idgudang = 1;
		}

		$data = new masterGudangPurchase();
		$data->mg_id = $idgudang;
		$data->mg_namagudang = strtoupper($request->nmgudang);
		$data->mg_cabang = strtoupper($request->idcabang);
		$data->mg_alamat = strtoupper($request->alamat);

		$data->save();

		return redirect('mastergudang/mastergudang');
	}

	public function createmastergudang() {
		$data['cabang'] = master_cabang::all();	

		return view('purchase/master/master_gudang/create', compact('data'));
	}

	public function detailmastergudang($id) {
		$data['cabang'] = master_cabang::all();	
		$data['gudang'] = DB::select("select * from mastergudang where mg_id = '$id'");
		return view('purchase/master/master_gudang/detail', compact('data'));
	}

	public function updatemastergudang(Request $request){
	//	dd($request);
		$id = $request->idgudang;

		$updategudang = masterGudangPurchase::where('mg_id' , '=' , $id);
		$updategudang->update([
				'mg_namagudang' => $request->nmgudang,
				'mg_cabang' => $request->idcabang,
				'mg_alamat' => $request->alamat,
		 		]);

		return redirect('mastergudang/mastergudang');

	}


	public function master_supplier(){
		return view('purchase/master/kontraksupplier/index');
	}
}	
