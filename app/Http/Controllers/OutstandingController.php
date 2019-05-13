<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Cookie;
use Session;

//use Yajra\Datatables\Datatables;

class OutstandingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if(empty(Session::get('authenticated')))
            return redirect('/login');
        
        if(Session::get('role_id')) 
        {           
            $dt['title'] = 'Outstanding | Procurement Portal';
            $dt['totalcartnotif'] = $this->get_totalcartnotif();
            return view('outstanding', $dt);
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
        $sql = " SELECT COUNT(*) AS total FROM temp_cart WHERE username = '{$username}'  ";
        $dt = DB::SELECT($sql);
        //echo "<pre>"; print_r($dt);
        return $dt[0]->total;
    }

    public function ___grid_datatable()
    {
        $a = 5;
        $ulevel = 1; //Auth::user()->level;
        $upt = 1; //Auth::user()->pt_code;
        

        //echo '<pre>'; print_r(Datatables::of(Crud::query())->make(true));die();
        $sql = " SELECT a.* FROM tr_order_req a ORDER BY a.created DESC ";
       //$sql = " select a.*, TIMESTAMPDIFF(YEAR,date_of_birth, CURDATE()) AS age from tr_candidate a where status=1 $where ";
        //echo $sql; die();
        return Datatables::of(DB::select($sql))->make(true);
        
        
        /*
        if($ulevel != 1)
        {
            //$where .= " and a.subco = '".$upt."' ";
            return Datatables::of(Crud::query())
                    ->where('status',1)
                    ->make(true);
        }
        else
        {
             return Datatables::of(Crud::query())
                    ->where(array('status'=>1,'subco'=>''.$upt.''))
                    ->make(true);
        }
        */
    }

    function grid_datatable()
    {
        //echo "<pre>"; print_r($_POST); die();
        //echo "<pre>"; print_r(session()->all()); die();
        $session = session()->all();
        $username = $session['username'];

        // Datatables Variables
        $draw = !empty($_POST["draw"]) ? intval($_POST["draw"]) : ""; 
        $start = !empty($_POST["start"]) ? intval($_POST["start"]) : "";
        $length = !empty($_POST["length"]) ? intval($_POST["length"]) : "";


        $sql = " SELECT a.* FROM tr_order_req a WHERE a.username_req = '{$username}' ORDER BY a.created DESC ";  
        $datatable = DB::SELECT($sql);
        //echo "<pre>"; print_r($datatable); die();

        
        $data = array();
        $no = 1;

        foreach($datatable as $r) 
        {
            //echo "<pre>"; print_r($r);

            $total = $r->harga_satuan*$r->quantity;
            
            $data[] = array
            (
                $no,
                $r->no_material,
                $r->material_name,
                $r->supplier_name,
                'PLANT',
                $r->quantity,
                $r->harga_satuan,
                $total
            );

            $no++;
        }
        //die();

        $output = array(
           "draw" => $draw,
             "recordsTotal" => 0, //$datatable->num_rows(),
             "recordsFiltered" => 0, //$datatable->num_rows(),
             "data" => $data
        );
        echo json_encode($output);
        exit();

        
    }

}