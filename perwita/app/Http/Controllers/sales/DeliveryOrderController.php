<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as Database;
use App\Http\Requests;
use Validator as JPM;
use PDF;

class DeliveryOrderController extends Controller
{
	private $_DATA;

	public function index()
	{
		// dd($this->setQueryDelOrder()->getCityName()->getQueryForIndex());
		return view("laporan_sales.do_kertas.index", [
			"data" => $this->setQueryDelOrder()->getCityName()->getQueryForIndex()
		]);
	}

	public function store(Request $request)
	{
		$data = [
			"DO" => [
				"nomor" => $request->nomor,
				"tanggal" => $request->tanggal,
				"kode_customer" => $request->kode_customer
			],

			"DO_Detail" => [
				"nomor" => 1,
				"kode_item" => request("kode_item"),
				"satuan" => request("satuan"),
				"diskon" => (int) str_replace(".", "", request("diskon")),
				"harga" => (int) str_replace(".", "", request("harga")),
				"jumlah" => (int) str_replace(".", "", request("jumlah")),
				"total" => (int) str_replace(".", "", request("netto")),
				"keterangan" => request("keterangan"),
			]
		];
	
		/*$validator = JPM::make($request->all(), [
			"nomor" => "required",
			"kode_item" => "required",
			"satuan" => "required",
			"harga" => "required",
			"jumlah" => "required",
			"rupiah" => "required",
			"keterangan" => "required"
		]);*/

		/*if ($validator->fails()) {
			return $validator->errors()->all();
		}*/
		
		if ($request->has("kode_customer")) {
			Database::table("delivery_order")->insert($data["DO"]);
			return json_encode($data["DO"], true);
		} if ($request->has("kode_item")) {
			Database::table("delivery_orderd")->insert($data["DO_Detail"]);
			return json_encode($data["DO_Detail"], true);
		}
	}

	public function edit($id) 
	{
		$data = Database::table("delivery_orderd")
				  		->join("item", "delivery_orderd.kode_item", '=', "item.kode")
						->select(
							"delivery_orderd.id",
							"delivery_orderd.kode_item",
							"delivery_orderd.harga",
							"delivery_orderd.nomor_so",
							"delivery_orderd.total",
							"delivery_orderd.diskon",
							"delivery_orderd.satuan",
							"delivery_orderd.keterangan",
							"item.kode",
							"item.nama",
							"delivery_orderd.jumlah"
						)
						->where("id", $id)
						->first();
		$item = $this->getDataForAddItem();
		
		return json_encode([$data, $item], true);
	}

	public function update(Request $request, $id)
	{
		$data = [
			"nomor" => 1,
			"diskon" => request("diskon"),
			"kode_item" => request("kode_item"),
			"satuan" => request("satuan"),
			"harga" => request("harga"),
			"total" => request("total"),
			"jumlah" => request("jumlah"),
			"total" => request("rupiah"),
			"keterangan" => request("keterangan"),
		];

		$updateData = Database::table("delivery_orderd")->where("id", $id)->update($data);

		return $updateData;
	}

	public function destroy($id)
	{
		$destroyData = Database::table("delivery_orderd")->where("id", $id)->delete();
	}

	private function setQueryDelOrder()
	{
		$this->_DATA = Database::table("delivery_order")
								->select(
									"nomor",
									"tanggal",
									"nama_pengirim",
									"nama_penerima",
									"kode_customer",
									"id_kota_tujuan",
									"id_kota_asal",
									"status",
									"total"
								)
								/*->skip(0)
								->take(50)*/
								->where("jenis", "KORAN")
								->get();

		return $this;
	}

	private function getCityName()
	{
		for ($i=0; $i < count($this->setQueryDelOrder()->_DATA); $i++) { 
			$_data[] = Database::table("kota")
								  ->select("id", "nama")
								  ->whereIn("id", [
								  		$this->setQueryDelOrder()->_DATA[$i]->id_kota_asal,
								  		$this->setQueryDelOrder()->_DATA[$i]->id_kota_tujuan
								  ])
								  ->get();
		}
		
		for ($i = 0; $i < count($this->_DATA); $i++) { 
			if (($this->_DATA[$i]->id_kota_tujuan == $_data[$i][0]->id) && ($this->_DATA[$i]->id_kota_asal == $_data[$i][1]->id))
			{
				$this->_DATA[$i]->id_kota_tujuan = $_data[$i][0]->nama;
				$this->_DATA[$i]->id_kota_asal = $_data[$i][1]->nama;
			} 
			else if (($this->_DATA[$i]->id_kota_asal == $_data[$i][0]->id) && ($this->_DATA[$i]->id_kota_tujuan == $_data[$i][1]->id)) 
			{
				$this->_DATA[$i]->id_kota_asal = $_data[$i][0]->nama;
				$this->_DATA[$i]->id_kota_tujuan = $_data[$i][1]->nama;
			}
		}
		//dd($this->data, $_data);
		return $this;
	}

	public function getQueryForIndex()
	{
		return $this->_DATA;
	}


	public function redirectToAddForm() 
	{
		return view("laporan_sales.do_kertas.addForm", [
			"data" => $this->getDataForAddForm(),
			"item" => $this->getDataForAddItem(),
			"DO" => $this->getDeliveryOrderd(),
		]);
	}

	private function getDataForAddForm()
	{	
		$customer = [];
		$data = $this->setQueryDelOrder()->getCityName()->getQueryForIndex();

		for ($i = 0; $i < count($data); $i++) { 
			$customer[] = Database::table("customer")
						 ->select("kode", "nama")
						 ->where("kode", $data[$i]->kode_customer)
						 ->get();
		}
		
		return $customer;
	}

	private function getDeliveryOrderd() 
	{
		$data = Database::table("delivery_orderd")
						->join("item", "delivery_orderd.kode_item", '=', "item.kode")
						->select(
							"delivery_orderd.id",
							"delivery_orderd.kode_item",
							"delivery_orderd.harga",
							"delivery_orderd.satuan",
							"delivery_orderd.keterangan",
							"delivery_orderd.total",
							"item.kode",
							"item.nama",
							"delivery_orderd.jumlah"
						)
						->get();
		return $data;
	}

	private function getDataForAddItem()
	{
		$item = Database::table("item")
						->select("kode", "nama", "kode_satuan", "harga")
						->get();

		return $item;
	}
}