<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Cookie;
use Session;
use App\Tm_material;
use App\Temp_cart;

class CartController extends Controller
{
	
	public function index()
    {	
		if(empty(Session::get('authenticated')))
        return redirect('/login');
		
		if(Session::get('role_id')) 
		{			
			$dt['title'] = 'Cart | Procurement Portal | TAP';
			$dt['data'] = $this->get_data_cart();
			$dt['totalcartnotif'] = $this->get_totalcartnotif();
			$dt['autocomplete'] = $this->get_autocomplete();
			return view('cart/v_cart', $dt);
		} 
		else 
		{
			return view('home');
		} 
    }
	
    function add($id)
    {
		$no_material = base64_decode($id);
		
        $row = Tm_material::find($no_material);
		//echo "<pre>"; print_r($row);die();
     
        if( $row->count() > 0) 
		{
			//echo "<pre>"; print_r(session()->all()); die();
			$harga_satuan = $row->price_estimate == '' ? 0 : $row->price_estimate;
			
			$u = session()->all();
			$username = $u['username'];

			DB::beginTransaction();

			try 
			{
				$sql = "INSERT INTO temp_cart(username,no_material,material_name,quantity,harga_satuan,supplier_code,supplier_name,checklist)
							VALUES('{$username}','{$no_material}','{$row->material_name}',1,{$harga_satuan},'{$row->supplier_code}','{$row->supplier_name}',0)";
				//echo $sql; die();
				DB::insert($sql);
				
				DB::commit();
				
				Session::put('alert', 'success insert to cart');
				Session::flash('message', 'Success insert to cart!'); 
				return Redirect::to('/cart');
			} 
			catch (\Exception $e) 
			{
				DB::rollback();
				
				//echo "error updating, ".$e->getMessage()." "; die();
				Session::flash('alert-class', 'alert-danger'); 
				return Redirect::to('/cart');
			}
			
			/*
			$data = new Temp_cart;
			$data->username = $username;
			$data->no_material = $no_material;
			$data->material_name = $row->material_name;
			$data->quantity = 1;
			$data->harga_satuan = $row->price_estimate;
			$data->save();
			*/
			
			//Temp_cart::add($username, $no_material, $row->material_name, 1, $row->price_estimate, '','');
			//Temp_cart::add($username, $no_material, $row->material_name, 1, $row->price_estimate, array());
			
            
        } else {
			Session::flash('alert-class', 'alert-danger'); 
            return Redirect::to('/');
        }
		
		
    }

    public function basket()
    {
        if (Cart::count() == 0) {
            return Redirect::to('/');       
        } else {
            return View::make('cart.basket')
                       ->with('title', 'Cart &rarr; Basket');
        }
    }

    public function checkout()
    {
		//echo "<pre>"; print_r($_POST); die();
		
		if(Session::get('role_id')) 
		{			
			$dt['title'] = 'Procurement | TAP';
			$dt['data'] = $this->get_list_material($filter=null);
			$dt['totalcartnotif'] = $this->get_totalcartnotif();;
            return view('cart/v_checkout', $dt);
        } 
		else 
		{
            return view('home');
        } 
    }

    /*
    public function checkout_v1()
    {
		//echo "<pre>"; print_r($_POST); die();
		
		if(Session::get('role_id')) 
		{			
			$dt['title'] = 'Procurement | TAP';
			$dt['data'] = $this->get_list_material($filter=null);
			$dt['totalcartnotif'] = $this->get_totalcartnotif();;
            return view('cart/v_checkout', $dt);
        } 
		else 
		{
            return view('home');
        } 
		//echo "PAGE CHART"; die();
        /*if (Cart::count() == 0) {
            return Redirect::to('/');       
        } else {
            return View::make('cart.checkout')
                       ->with('title', 'Cart &rarr; Checkout');
        }

    }
    */

    public function show($rowid)
    {	
		//echo $rowid; die();
		
		$u = session()->all();
		$username = $u['username'];
		
		$sql = " SELECT no_material,material_name,sum(quantity) as quantity, harga_satuan, supplier_code, supplier_name, checklist
FROM temp_cart WHERE username = '{$username}' AND no_material = '{$rowid}'
group by no_material, material_name, quantity, harga_satuan, supplier_code, supplier_name, checklist
ORDER BY supplier_name  ";
		$data = DB::SELECT($sql); 
		//echo "<pre>"; print_r($data); die();
		
		//$result = array('status' => 1, 'message' => 'success');
		$result = !empty($data) ? $data[0] : array(); 
		echo json_encode($result);
    }
	
	function remove()
    {	
		$u = session()->all();
		$username = $u['username'];
		
		//echo "<pre>"; print_r($_POST); die();
		/*
		Array
		(
			[_token] => CxcVxd4NwEFpRt0JWkVsqD7nVd5CngATyt6NPPun
			[no_material] => 201010117
			[item] => BAUT RODA BELAKANG DYNA 130 HT
			[harga-satuan] => 17000
			[kuantitas] => 3
		)
		*/
		
		DB::DELETE(" DELETE FROM temp_cart WHERE username = '{$username}' AND no_material = '{$_POST['no_material']}' ");
		
        //Cart::remove($rowid);
        return Redirect::to('cart');
    }

    public function destroy()
    {
        Cart::destroy();
        return Redirect::to('/');
    }

    public function update()
    {
        $quantity = Input::get('quantity');
        $rowid = Input::get('rowid');

        for ($i=0; $i<count($rowid); $i++) {
            Cart::update($rowid[$i], array('qty' => $quantity[$i]));
        }

        return Redirect::to('basket');
    }
	
	public function onprogress()
	{
		//echo "PAGE ON PROGRESS";
		if(empty(Session::get('authenticated')))
        return redirect('/login');
		
		if(Session::get('role_id')) 
		{			
			$dt['title'] = 'On Progress - My Order | Procurement Portal | TAP';
			$dt['data'] = $this->get_on_progress();
			$dt['totalcartnotif'] = $this->get_totalcartnotif();
			$dt['conprogress'] = 'active';

			return view('cart/v_onprogress', $dt);
		} 
		else 
		{
			return view('home');
		} 
		
	}
	
	function get_data_cart()
	{
		$u = session()->all();
		$username = $u['username'];
		//$sql = " SELECT * FROM temp_cart WHERE username = '{$username}' ORDER BY supplier_name "; echo $sql; die();
		
		$sql = " SELECT no_material,material_name,sum(quantity) as quantity, harga_satuan, supplier_code, supplier_name, checklist
FROM temp_cart WHERE username = '{$username}' 
group by no_material, material_name, quantity, harga_satuan, supplier_code, supplier_name, checklist
ORDER BY supplier_name  ";
		
		$dt = DB::SELECT($sql);
		//echo "<pre>"; print_r($dt);
		return $dt;
	}

	function get_totalcartnotif()
	{
		$u = session()->all();
		$username = $u['username'];
		$sql = " SELECT COUNT(*) AS total FROM temp_cart WHERE username = '{$username}'  ";
		$dt = DB::SELECT($sql);
		//echo "<pre>"; print_r($dt);
		return $dt[0]->total;
	}
	
	function plusmindata(Request $request, $nomat, $noid=null, $act)
	{
		//echo $nomat.' | '.$act; die();
		$u = session()->all();
		$username = $u['username'];
		
		$row = Tm_material::find($nomat);
		//echo "<pre>"; print_r($row);die();
     
        if( $row->count() > 0) 
		{
			//echo "<pre>"; print_r(session()->all()); die();
			$harga_satuan = $row->price_estimate == '' ? 0 : $row->price_estimate;
			
			$u = session()->all();
			$username = $u['username'];

			DB::beginTransaction();

			try 
			{
				if($act=='plus')
				{
					$sql = "INSERT INTO temp_cart(username,no_material,material_name,quantity,harga_satuan,supplier_code,supplier_name,checklist)
								VALUES('{$username}',{$nomat},'{$row->material_name}',1,{$harga_satuan},'{$row->supplier_code}','{$row->supplier_name}',0)";
					//echo $sql; die();
					DB::insert($sql);				
				}
				else if( $act=='min' )
				{
					//DELETE FROM tshirt WHERE id IN (SELECT id FROM tshirt WHERE sku='%s' LIMIT 1)
					$sql = " DELETE FROM temp_cart WHERE id IN 
								(SELECT id FROM temp_cart WHERE username = '{$username}' AND no_material='{$nomat}' AND supplier_code = '".trim($noid)."' LIMIT 1) ";
					//$sql = " DELETE FROM temp_cart WHERE no_material = '{$nomat}' AND supplier_code = '{$noid}' ";
					DB::delete($sql);
				}
				//echo $sql; die();
				
				DB::commit();
				
				$result = array('status' => 1, 'message' => 'success');
			} 
			catch (\Exception $e) 
			{
				DB::rollback();	
				$result = array('status' => 1, 'message' => "error updating, ".$e->getMessage()." ");
			}
        }
		
		echo json_encode($result);
		
	}

	function get_list_material()
	{

		//echo "<pre>"; print_r($_POST); die();
		$nomat = "";
		$scode = "";
		$u = session()->all();
		$username = $u['username'];
		
		if(!empty($_POST['no_material']))
		{
			//1. DELETE CHECKLIST SEBELUMNYA
			$sqlu = " UPDATE temp_cart SET checklist = 0 WHERE username = '{$username}' AND checklist != 2 ";
			DB::UPDATE($sqlu);
			
			foreach( $_POST['no_material'] as $k => $v )
			{
				$no_material = explode("_",$v);
				$nomat .= "'{$no_material[0]}',";
				$scode .= "'{$no_material[1]}',";
				
				//2. UPDATE CHECKLIST
				$sqlu = " UPDATE temp_cart SET checklist = 1 WHERE username = '{$username}' AND no_material = '{$no_material[0]}' AND supplier_code = '{$no_material[1]}' ";
				DB::UPDATE($sqlu);
			}
			
			$no_material = rtrim($nomat,',');
			$supplier_code = rtrim($scode,',');
			$datax = array();
			
			$sql = " SELECT a.supplier_code, a.supplier_name
						FROM temp_cart a left join tm_material b ON a.no_material = b.no_material 
					WHERE a.username = '{$username}' AND a.no_material in ({$no_material}) AND a.supplier_code in ({$supplier_code})
						GROUP BY a.supplier_code, a.supplier_name
					ORDER BY a.supplier_name  ";
			//echo $sql; die();
			$dt = DB::SELECT($sql);//echo "<pre>"; print_r($dt); die();

			if( $dt )
			{
				foreach( $dt as $k=> $v )
				{
					$datax[] = array(
						'supplier_code' => $v->supplier_code,
						'supplier_name' => $v->supplier_name,
						'detail_order' => $this->get_detail_order($username,$no_material,$v->supplier_code,$v->supplier_name)
					);
				}
			}

			//echo "<pre>"; print_r($datax); die();
			return $datax;
		}
		else
		{
			$sqlu = " UPDATE temp_cart SET checklist = 0 WHERE username = '{$username}' AND checklist != 2 ";
			DB::UPDATE($sqlu);
		}
	}
	
	/*
	function get_list_material_v1()
	{

		//echo "<pre>"; print_r($_POST); die();
		$nomat = "";
		$scode = "";
		$u = session()->all();
		$username = $u['username'];
		
		if(!empty($_POST['no_material']))
		{
			//1. DELETE CHECKLIST SEBELUMNYA
			$sqlu = " UPDATE temp_cart SET checklist = 0 WHERE username = '{$username}' AND checklist != 2 ";
			DB::UPDATE($sqlu);
			
			foreach( $_POST['no_material'] as $k => $v )
			{
				$no_material = explode("_",$v);
				$nomat .= "'{$no_material[0]}',";
				$scode .= "'{$no_material[1]}',";
				
				//2. UPDATE CHECKLIST
				$sqlu = " UPDATE temp_cart SET checklist = 1 WHERE username = '{$username}' AND no_material = '{$no_material[0]}' AND supplier_code = '{$no_material[1]}' ";
				DB::UPDATE($sqlu);
			}
			
			$no_material = rtrim($nomat,',');
			$supplier_code = rtrim($scode,',');
			
			$sql = " SELECT a.no_material, a.material_name, sum(a.quantity) as quantity, a.harga_satuan, a.supplier_code, a.supplier_name, b.franco
						FROM temp_cart a left join tm_material b ON a.no_material = b.no_material 
					WHERE a.username = '{$username}' AND a.no_material in ({$no_material}) AND a.supplier_code in ({$supplier_code})
						GROUP BY a.no_material, a.material_name, a.quantity, a.harga_satuan, a.supplier_code, a.supplier_name, b.franco
					ORDER BY a.supplier_name  ";
			$dt = DB::SELECT($sql);
			return $dt;
		}
		else
		{
			$sqlu = " UPDATE temp_cart SET checklist = 0 WHERE username = '{$username}' AND checklist != 2 ";
			DB::UPDATE($sqlu);
		}
	}
	*/
	
	public function create_order(Request $request)
	{
		//echo "<pre>"; print_r($_POST); die();
		/*
			[_token] => iYA7EEWLhFx5zWB8YBtNBZ99rmY3yJTyofm6ZLNl
			[get_no_material] => Array
				(
					[0] => 201010117
					[1] => 101030005
				)
		*/ 
		$u = session()->all();
		$username = $u['username'];
		//if( !empty($_POST['get_no_material']) ){}
		$sql = " SELECT * FROM temp_cart WHERE username = '{$username}' AND checklist = 1 ";
		$data = DB::SELECT($sql); //die();
		//echo "<pre>"; print_r($data); die();
		
		$random_id = rand(1,10000);
		$id_order_req = $this->c_id_order_req($random_id);
		$po_order_req = $this->c_po_order_req($random_id);
		
		if($data)
		{
			foreach( $data as $k => $v )
			{
				//echo "<pre>"; print_r($v);
				$this->create_order_submit($v,$id_order_req,$po_order_req);
			}
			//die();
		}
		
		//$result = array('status' => 1, 'message' => 'success');
		//echo json_encode($result);
		
		return redirect('/myorder/on-progress');
		
	}
	
	function create_order_submit($v,$id_order_req,$po_order_req)
	{
		//echo "<pre>"; print_r($v);die();
		/*
			stdClass Object
			(
				[id] => 101
				[username] => gudang_gawi1
				[no_material] => 201010117
				[material_name] => BAUT RODA BELAKANG DYNA 130 HT
				[quantity] => 1.00
				[harga_satuan] => 17000.00
				[supplier_code] => 23000001762    
				[supplier_name] => BLESSINDO PRIMA SARANA, PT
				[checklist] => 1
			)*/
		
		$random_id = rand(1,10000);
		date_default_timezone_set("Asia/Bangkok");
		$created = date('Y-m-d H:i:s');
		
		$sql = "INSERT INTO tr_order_req(po_order,id_order, po_order_req,id_order_req,username_req,no_material,material_name,quantity,harga_satuan,supplier_code,supplier_name,status,created)
					VALUES('{$id_order_req}','{$po_order_req}','{$this->c_po_order_req($random_id)}','{$this->c_id_order_req($random_id)}','{$v->username}',{$v->no_material},'{$v->material_name}',{$v->quantity},{$v->harga_satuan},
					'".trim($v->supplier_code)."','{$v->supplier_name}','processing','{$created}')";
			DB::insert($sql);
		
			$sqld = " DELETE FROM temp_cart WHERE id = {$v->id} "; 
			DB::DELETE($sqld);
			
		return true;
		
		/*
		DB::beginTransaction();

		try 
		{
			
			
			DB::commit();
			
			//$result = array('status' => 1, 'message' => 'success');
			
			return true;
		} 
		catch (\Exception $e) 
		{
			DB::rollback();	
			//$result = array('status' => 1, 'message' => "error updating, ".$e->getMessage()." ");
			
			return false;
		}
		*/
		
	}
	
	function c_po_order_req($id)
	{
		//19.04/TAP-PROC/ORDREQ/000001
		$year = date('y');
		$month = date('m');
		$nourut = str_pad(2, 10); //rand(1,1000);
		
		return $year.'.'.$month.'/TAP-PROC/ORDREQ/'.$id;
	}
	
	function c_id_order_req($id)
	{
		//PO/1904/000001
		$year = date('y');
		$month = date('m');
		$nourut = str_pad(2, 10);//rand(1,1000);
		
		return "PO/".$year.$month."/".$id;
	}
	
	function get_on_progress()
	{
		$u = session()->all();
		$username = $u['username'];
		//$sql = " SELECT * FROM tr_order_req WHERE username_req = '{$username}' ORDER BY po_order desc ";
		//$dt = DB::SELECT($sql); 
		
		$data = DB::table('tr_order_req')
			->Where('username_req', $username)
			->orderby('created','DESC')
			->paginate(15);
		
		return $data;
	}

	function get_autocomplete()
    {   
    	$sql = " SELECT a.no_material AS id, a.material_name AS name, a.supplier_name AS location, a.franco, a.price_estimate AS price 
    				FROM tm_material a WHERE a.no_material IN ('212060084',
												'212060118',
												'201010117',
												'212021660',
												'202060006',
												'202060240',
												'101030005',
												'101010009',
												'101010007',
												'101010017',
												'212060084',
												'212060118',
												'201010117',
												'212021660',
												'202060006',
												'202060240',
												'101030005',
												'101010009',
												'101010007',
												'101010017') 
    					ORDER BY a.created_at ASC "; //echo $sql; die();
 		$data = DB::SELECT($sql); 
		//echo "<pre>"; print_r($data); die();

 		if($data)
 		{
 			$datax = '';
 			foreach( $data as $k => $v )
 			{
 				$no_material = base64_encode($v->id);
 				$price = number_format($v->price,0,',','.');

 				$datax .= "{id : '{$no_material}',
 								name : '{$v->name} (IDR {$price}) ',
 								location : '{$v->location} ({$v->franco})'
 							},";
 			}
 		}
 		return rtrim($datax,',');
    }

    function get_detail_order($username,$no_material,$supplier_code,$supplier_name)
    {
    	//$dt = array($username,$supplier_code,$supplier_name);

    	$sql = " SELECT a.no_material, a.material_name, sum(a.quantity) as quantity, a.harga_satuan, a.supplier_code, a.supplier_name, b.franco
					FROM temp_cart a left join tm_material b ON a.no_material = b.no_material 
				WHERE a.username = '{$username}' AND a.no_material in ({$no_material})  AND a.supplier_code = '{$supplier_code}'
					GROUP BY a.no_material, a.material_name, a.quantity, a.harga_satuan, a.supplier_code, a.supplier_name, b.franco
				ORDER BY a.supplier_name  "; 
		$dt = DB::SELECT($sql);

    	return $dt;
    }
	
}

?>