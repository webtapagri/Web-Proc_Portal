<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Cookie;
use Session;

class HomeController extends Controller
{	 
    public function index()
    {	
        if(empty(Session::get('authenticated')))
            return redirect('/login');

        if(Session::get('role_id')) 
		{			
			$dt['title'] = 'Procurement | TAP';
			$dt['totalcartnotif'] = $this->get_totalcartnotif();
			$dt['data'] = $this->get_list_material($filter=null);
            return view('dashboard', $dt);
        } 
		else 
		{
            return view('home');
        } 
    }
	
	function get_list_material($filter)
	{
		if( $filter['isearch'] != '' ){
			//echo "<pre>"; print_r($filter); die();
			$data = DB::table('tm_material')
						->orWhere('material_name', 'like', '%'.strtoupper($filter['isearch']).'%')
						->orderby('created_at','ASC')
						->paginate(1000000000);
		}else{
			//$filter['_token'] = 'JDTGTQLig5hhOCUca2id2CLHvkLD2YHQ8nbRHQSp';
			$data = DB::table('tm_material')
						->whereIn('no_material',array('212060084',
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
														'101010017'))
						->orderby('created_at','ASC')
						->paginate(6);
		}
		//echo "<pre>"; print_r($data); die();
		return $data;
	}
	
	function search()
	{
		if(empty(Session::get('authenticated')))
            return redirect('/login');

        if(Session::get('role_id')) 
		{			
			$dt['title'] = 'Procurement | TAP';
			$dt['data'] = $this->get_list_material($filter=$_POST);
            return view('dashboard', $dt);
        } 
		else 
		{
            return view('home');
        } 
	}
	
	function get_totalcartnotif()
	{
		$u = session()->all();
		$username = $u['username'];
		$sql = " SELECT COUNT(*) AS total FROM temp_cart WHERE username = '{$username}' ";
		$dt = DB::SELECT($sql);
		//echo "<pre>"; print_r($dt);
		return $dt[0]->total;
	}
}