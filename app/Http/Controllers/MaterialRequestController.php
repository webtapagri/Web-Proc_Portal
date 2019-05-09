<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientErrorResponseException;

use App\SetMaterial;
use API;
use Session;
use function GuzzleHttp\json_encode;
use AccessRight;

class MaterialRequestController extends Controller
{
    public function index() {
        if (empty(Session::get('authenticated')))
            return redirect('/login');
        
        if (AccessRight::granted() == false)
            return response(view('errors.403'), 403);;

        $access = AccessRight::access();    
        return view('materialrequest/add')->with(compact('access'));
    }

    public function create() {
        if (empty(Session::get('authenticated')))
            return redirect('/login');

        $access = AccessRight::access();    

        return view('materialrequest/add');
    }
  
    public function extend($document_no) {
        if (empty(Session::get('authenticated')))
            return redirect('/login');
            
        return view('mastermaterial/extend')->with('document_no', $document_no);
    }

    public function detail() {
        $no_document = $_REQUEST['no_document'];
        $service = API::exec(array(
            'request' => 'GET',
            'method' => 'tr_files/' . $no_document
        ));
        $res = $service;
        $arr = array();
        if (count($res->data) > 0) {
            $arr = $res->data;
        }    
  
        return View('materialrequest/detail')->with('data', $arr);
    }

    public function get_material_user_grid() {

        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tr_materials_union/"
        ));
        $data = $service;
        return response()->json(array('data' => $data->data));
    }
    
    public function get_material_user_grid_search() {
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tr_materials_union_limit/".(!empty($_REQUEST['search']) ? $_REQUEST['search'] : '')
        ));

        $data = $service;
        return response()->json(array('data' => $data->data));
    }
    
    public function get_tr_materials() {

        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tr_materials/".(!empty($_REQUEST['search']) ? str_replace('/','_', $_REQUEST['search']) : '')
        ));
        $data = $service;

        return response()->json(array('data' => $data->data));
    }

    public function get_tm_materials() {
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tm_materials/".(!empty($_REQUEST['search']) ? str_replace('/','_', $_REQUEST['search']): '')
        ));
        $data = $service;
        return response()->json(array('data' => $data->data));
    }

    public function getThumbnail($no_document)
    {
        $service = API::exec(array(
            'request' => 'GET',
            'method' => 'tr_files/' . str_replace('/','_', $no_document)
        ));
        $data = $service;
        if ($data->status === "failed") {
          return '';
        }else{
            return $data->data->file_image;
        }
    }
 
    public function get_image()
    {
        $no_document = $_REQUEST['no_document'];
        $service = API::exec(array(
            'request' => 'GET',
            'method' => 'tr_files/' . str_replace('/','_', $no_document)
        ));
        $res = $service;
        $arr = array();

        if(count($res->data)>0) {
            $arr = $res->data;
        }
        return response()->json(array('data'=>$arr));
    }

    public function get_auto_sugest()
    {
        $result = array();
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tr_materials_filter/" . $_REQUEST['param']
        ));
        
        $res = $service;

        if($res->status === 'success') {
            foreach ($res->data as $key => $value) {
                if( $value->no_material) {
                    if( !in_array($value->no_material, $result)){ 
                        $result = array_merge($result, array($value->no_material));
                    }
                }
            } 
            
            foreach ($res->data as $key => $value) {
                if( $value->material_name) {
                    if(!in_array($value->material_name, $result)){
                         $result = array_merge($result, array($value->material_name));
                    }
                }
            } 
           
            foreach ($res->data as $key => $value) {
                if( $value->part_number) {
                    if( !in_array($value->part_number, $result)){ 
                        $result = array_merge($result, array($value->part_number));
                    }
                }
            } 
        }

        $slim_data = array();
        foreach($result as $key => $value) {
            if (preg_match('/'.str_replace(' ','', $_REQUEST['param']).'/i', str_replace(' ','', $value))) {
                $slim_data = array_merge($slim_data, array($value));
            }
        }

        return response()->json(array('data'=> $slim_data));
    }

    public function store(Request $request)
    {
        try {
            $no_document = rand(1,10000000000);
            foreach ($_FILES as $row) {
                if($row["name"] ) {
                    $name = $row["name"];
                    $size = $row["size"];
                    $path = $row["tmp_name"];
                    $type = pathinfo($row["tmp_name"], PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    $files[] = array(
                        "file_name" => $name,
                        "doc_size" => $size,
                        "file_category" => $type,
                        "file_image" => $base64
                    );
                }
            }

            $param = array(
                "no_document" => $no_document,
                "industri_sector" => $request->industry_sector,
                "plant" => $request->plant,
                "store_loc" => $request->store_location,
                "sales_org" => $request->sales_org,
                "dist_channel" => $request->dist_channel,
                "mat_group" => $request->sap_material_group,
                "part_number" => $request->part_no,
                "spec" => $request->specification,
                "merk" => $request->merk,
                "material_name" => $request->material_sap,
                "description" => $request->description,
                "uom" => $request->uom,
                "division" => $request->division,
                "item_cat_group" => $request->item_category_group,
                "gross_weight" => $request->gross_weight,
                "net_weight" => $request->net_weight,
                "volume" => $request->volume,
                "size_dimension" => $request->size,
                "weight_unit" => $request->weight_unit,
                "volume_unit" => $request->volume_unit,
                "mrp_controller" => $request->mrp_controller,
                "valuation_class" => $request->valuation_class,
                "tax_classification" => $request->tax_classification,
                "account_assign" => $request->account_assign,
                "general_item" => $request->general_item_category_group,
                "avail_check" => $request->availability_check,
                "transportation_group" => $request->transportation_group,
                "loading_group" => $request->loading_group,
                "profit_center" => $request->profit_center,
                "mrp_type" => $request->mrp_type,
                "period_sle" => $request->period_ind_for_sle,
                "cash_discount" => $request->cash_discount,
                "price_unit" => $request->price_unit,
                "locat" => $request->location,
                "material_type" => $request->material_type,
                "remarks" => $request->remarks,
                "price_estimate" => $request->price_estimate,
                "user_id" => Session::get('user_id'),
                "role_id" => Session::get('role_id'),
                "files"=>  $files
            );

            $service = API::exec(array(
                'request' => 'POST',
                'method' => 'tr_materials_insert',
                'data'=> $param
             )); 

            $res = $service;
            if($res->status  == 'success'){
                 foreach ($_FILES as $row) {
                    if($row["name"] ) {
                        $name = $row["name"];
                        $size = $row["size"];
                        $path = $row["tmp_name"];
                        $type = pathinfo($row["tmp_name"], PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        $files = array(
                            "no_document" => $no_document,
                            "file_name" => $name,
                            'material_no' => '-',
                            "doc_size" => $size,
                            "file_category" => $type,
                            "file_image" => $base64
                        );

                        $service = API::exec(array(
                            'request' => 'POST',
                            'method' => 'tr_files',
                            'data' => $files
                        ));
                        $res = $service;
                        if ($res->code == '201') {
                            $status = true;
                        } else {
                            $status = false;
                            echo json_encode(array(
                                "code" => 201,
                                "status" => "gagal upload",
                                "message" => $files
                            ));
                            break;
                        }
                    }
                }
                return response()->json(['status' => true, "message" => $res->message]);

            } else{
                return response()->json(['status' => false, "message" => $res->message]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, "message" => $e->getMessage()]);
       }
    }  
    
    public function get_uom()
    {
        $service = API::exec(array(
            'request' => 'GET',
            'host'=> 'ldap',
            'method' => "uom"
        ));
        $data = $service;
        $arr = array();
        foreach($data->data as $row) {
            $arr[] = array(
                'id'=> $row->MSEHI,
                'text'=> $row->MSEHI .'-'. $row->MSEHL
            );
        }
        return response()->json(array('data'=> $arr));
    }
   
    public function get_store_location(Request $request)
    {
        var_dump($request->id);
       
    }
   
    public function get_div() {
        $data = DB::table('tm_general_data')->where("general_code","div")->get();
        $arr = array();
        foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }
    
    public function get_plant() {
        $profile = AccessRight::profile();
        if($profile[0]->area_code) {
            $area_code = $profile[0]->area_code;
            $data = DB::table('tm_general_data')
            ->where("general_code","plant")
            ->whereIn('description_code', explode(',',$area_code))
            ->get ();
        } else {
            $data = DB::table('tm_general_data')->where("general_code","plant")->get ();
        }

        if(count($data) < 1) {
            $data = DB::table('tm_general_data')->where("general_code"," plant")->get();
        }

        $arr = array();
        foreach ($data as $row) {
            $arr[] = array(
                "id" => $row->description_code,
                "text" => $row->description_code ."  - ".   $row-> description
            );
        }
        
      
        return response()->json(array('data' => $arr));
    }
   
    public function get_location() {
        $data = DB::table('tm_general_data')->where("general_code", "location")->get();

        $arr = array();
        foreach ($data as $row) {
        
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }
   
    public function get_mrp_controller() {
        $data = DB::table('tm_general_data')->where("general_code", "mrp_controller")->get();
        $arr = array();
        foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }

    public function get_valuation_class() {
        $data = DB::table('tm_general_data')->where("general_code", "valuation_class")->get();
        $arr = array();
        foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }
    
    public function get_industry_sector() {
        $data = DB::table('tm_general_data')->where("general_code", "industry_sector")->get();
        $arr = array();
        foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }

    public function get_material_type() {
        $data = DB::table('tm_general_data')->where("general_code", "material_type")->get();

        $arr = array();
        foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }
    
    public function get_sales_org() {
        $data = DB::table('tm_general_data')->where("general_code", "sales_org")->get();
        $arr = array();
        foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr)); 
    }

    public function get_dist_channel() {
        $data = DB::table('tm_general_data')->where("general_code", "dist_channel")->get();

        $arr = array();
        foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }
    
    public function get_item_cat() {
        $data = DB::table('tm_general_data')->where("general_code", "item_cat")->get();
        $arr = array();
        foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }
   
    public function get_tax_classification() {
        $data = DB::table('tm_general_data')->where("general_code", "tax_class")->get();
        $arr = array();
          foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }
  
    public function get_account_assign() {
        $data = DB::table('tm_general_data')->where("general_code", "account_assign")->get();
        $arr = array();
          foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));  
    }

    public function get_availability_check() {
        $data = DB::table('tm_general_data')->where("general_code", "avail_check")->get();

        $arr = array();
          foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }
 
    public function get_transportation_group() {
        $data = DB::table('tm_general_data')->where("general_code", "trans_group")->get();

        $arr = array();
        foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }
 
    public function get_loading_group() {
        $data = DB::table('tm_general_data')->where("general_code", "loading_group")->get();
        $arr = array();
          foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }

    public function get_profit_center() {
        $data = DB::table('tm_general_data')->where("general_code", "profit_center")->get();
        $arr = array();
        foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }
   
    public function get_mrp_type() {
        $data = DB::table('tm_general_data')->where("general_code", "mrp_type")->get();

        $arr = array();
          foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }
   
    public function get_sle() {
        $data = DB::table('tm_general_data')->where("general_code", "sle")->get();
        foreach ($data as $row) {
            $arr[] = array(
                "id"=> $row->description_code,
                "text"=> $row->description_code ." - ". $row->description
            );
        }
        return response()->json(array('data' => $arr));
    }

    public function show(Request $request) {
      try {
            $service = API::exec(array(
                'request' => 'GET',
                'host' => 'ldap',
                'method' => "store_loc/" . $_REQUEST["id"]
            ));

            $data = $service;
            foreach ($data->data as $row) {
                foreach($row as $detail) {
                    $arr[] = array(
                        "id" => $detail->LGORT,
                        "text" => $detail->LGORT . " - " . str_replace("_", " ", $detail->LGOBE)
                    );
                }
            }
            return response()->json(array('data' => $arr));
      } catch (\Throwable $e) {
            return response()->json(array('data' => array()));  
      }
    }

    public function groupMaterialGroup()
    { 
        $data = DB::table('group_materials')->select('id', 'name', 'code', 'description', 'status')->where(array('status'=>0, 'code'=>$_REQUEST['code']))->get();
        $arr = array();
        foreach ($data as $row) {
            $arr[] = array(
                "id" => $row->id,
                "name" => $row->code,
                "description" => $row->description,
            );
        }
        return response()->json(array('data' => $arr));
    }
}
