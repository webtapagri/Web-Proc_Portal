<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientErrorResponseException;
use API;
use function GuzzleHttp\json_encode;
use Session;
use AccessRight;

class EditMaterialRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (empty(Session::get('authenticated')))
            return redirect('/login');

        if (AccessRight::granted() == false)
            return response(view('errors.403'), 403);

        $access = AccessRight::access();        

        return view('materialrequest/index')->with(\compact('access'));
    }

    public function grid()
    {
        $search = str_replace('/','_', $_REQUEST['search']);
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tr_materials/" . $search
        ));
        $arr = array();
        $data = $service;
        if($data->data) {
            foreach ($data->data as $row) {
                $image = ($row->no_document ? $this->image($search) :'');

                $arr[] = array(
                    "image" => $image,
                    "no_material" => str_replace('/','_', $row->no_material),
                    "no_document" => str_replace('/','_',$row->no_document),
                    "industri_sector" => $row->industri_sector,
                    "plant" => $row->plant,
                    "store_loc" => $row->store_loc,
                    "sales_org" => $row->sales_org,
                    "dist_channel" => $row->dist_channel,
                    "mat_group" => $row->mat_group,
                    "part_number" => $row->part_number,
                    "spec" => $row->spec,
                    "merk" => $row->merk,
                    "material_name" => $row->material_name,
                    "description" => $row->description,
                    "uom" => $row->uom,
                    "division" => $row->division,
                    "item_cat_group" => $row->item_cat_group,
                    "gross_weight" => $row->gross_weight,
                    "net_weight" => $row->net_weight,
                    "volume" => $row->volume,
                    "size_dimension" => $row->size_dimension,
                    "weight_unit" => $row->weight_unit,
                    "volume_unit" => $row->volume_unit,
                    "mrp_controller" => $row->mrp_controller,
                    "valuation_class" => $row->valuation_class,
                    "tax_classification" => $row->tax_classification,
                    "account_assign" => $row->account_assign,
                    "general_item" => $row->general_item,
                    "avail_check" => $row->avail_check,
                    "transportation_group" => $row->transportation_group,
                    "loading_group" => $row->loading_group,
                    "profit_center" => $row->profit_center,
                    "mrp_type" => $row->mrp_type,
                    "period_sle" => $row->period_sle,
                    "cash_discount" => $row->cash_discount,
                    "price_unit" => $row->price_unit,
                    "locat" => $row->locat,
                    "material_type" => $row->material_type,
                    "remarks" => $row->remarks
                );
            }
        }
        
        return response()->json(array('data' => $arr));
    }

    public function image($no_document)
    {
        $service = API::exec(array(
            'request' => 'GET',
            'method' => 'tr_files/' . $no_document
        ));
        $data = $service;

        if ($data->status === "failed") {
            return '';
        } else {
            return $data->data[0]->file_image;
        }
    }

    public function auto_sugest()
    {
        $result = array();
        $service = API::exec(array(
            'request' => 'GET',
            'method' => 'edit_material_request_search/' . (!empty($_REQUEST['search']) ? $_REQUEST['search'] : '')
        ));

        $res = $service;
        if ($res->status === 'success') {
            
            foreach ($res->data as $key => $value) {
                if (!in_array($value->no_document, $result)) {
                    $result = array_merge($result, array($value->no_document));
                }
            }

            foreach ($res->data as $key => $value) {
                if (!in_array($value->material_name, $result)) {
                    $result = array_merge($result, array($value->material_name));
                }
            }

            foreach ($res->data as $key => $value) {
                if (!in_array($value->part_number, $result)) {
                    $result = array_merge($result, array($value->part_number));
                }
            }
        }

        $slim_data = array();
        foreach($result   as $key => $value) {

              if (preg_match('/'.str_replace(' ','', $_REQUEST['search']).'/i', str_replace(' ','', $value))) {
                $slim_data = array_merge($slim_data, array($value));
            }
        }

        return response()->json(array('data'=> $slim_data));
    }

    public function store(Request $request)
    {
        $param = array(
            "part_number" => $request->part_no,
            "spec" => $request->specification,
            "merk" => $request->merk,
            "material_name" => $request->material_sap,
            "description" => $request->description,
            "uom" => $request->uom,
            "gross_weight" => $request->gross_weight,
            "net_weight" => $request->net_weight,
            "volume" => $request->volume,
            "size_dimension" => $request->size,
            "weight_unit" => $request->weight_unit,
            "volume_unit" => $request->volume_unit,
            "remarks" => $request->remarks,
            "updated_by" => Session::get('user'),
        );

        $service = API::exec(array(
            'request' => 'PUT',
            'method' => 'tr_materials/' . str_replace("/","_", $request->no_document),
            'data' => $param
        ));

        $res = $service;

        if ($res->code == '200') {

            $no = 1;
            foreach($request->data_files as $row) {
                $file_id = "file_id_" . $row;
                $file_deleted = "file_deleted_" . $row;
                $file = $_FILES['files_' . $row];
                if($file['name']) {
                    $name = $file["name"];
                    $size = $file["size"];
                    $path = $file["tmp_name"];
                    $type = pathinfo($file["tmp_name"], PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                }


                if($request->$file_id) {
                    if( $request->$file_deleted) {
                          $service = API::exec(array(
                            'request' => 'DELETE',
                            'method' => 'tr_files/' .$request->$file_id ,
                        ));
                    } else {
                        if($file["name"]) {
                            $files = array(
                                "file_name" => $name,
                                "doc_size" => $size,
                                "file_category" => $type,
                                "file_image" => $base64
                            );
                            $service = API::exec(array(
                                'request' => 'PUT',
                                'method' => 'tr_files/'. $request->$file_id,
                                'data' => $files
                            ));
                        }
                        
                    }
                } else {
                    if($file["name"]) { 
                        $files = array(
                            "no_document" => $request->no_document,
                            "file_name" => $name,
                            'material_no' => $request->no_material,
                            "doc_size" => $size,
                            "file_category" => $type,
                            "file_image" => $base64
                        );

                        $service = API::exec(array(
                            'request' => 'POST',
                            'method' => 'tr_files',
                            'data' => $files
                        ));
                    }
                }
            }
        }

        return response()->json(array('code' =>201, "message"=> "data has been updated successfully"));
    }  

    public function show($id)
    {
        if (empty(Session::get('authenticated')))
            return redirect('/login');

        $material = $this->material($id);
        $param = (object) array(
            "no_document" => $material[0]->no_document,
            "no_material" => $material[0]->no_material,
            "industri_sector" => $material[0]->industri_sector,
            "plant" => $material[0]->plant,
            "store_loc" => $material[0]->store_loc,
            "sales_org" => $material[0]->sales_org,
            "dist_channel" => $material[0]->dist_channel,
            "mat_group" => $material[0]->mat_group,
            "part_number" => $material[0]->part_number,
            "spec" => $material[0]->spec,
            "merk" => $material[0]->merk,
            "material_name" => $material[0]->material_name,
            "description" => $material[0]->description,
            "uom" => $material[0]->uom,
            "division" => $material[0]->division,
            "item_cat_group" => $material[0]->item_cat_group,
            "gross_weight" => $material[0]->gross_weight,
            "net_weight" => $material[0]->net_weight,
            "volume" => $material[0]->volume,
            "size_dimension" => $material[0]->size_dimension,
            "weight_unit" => $material[0]->weight_unit,
            "volume_unit" => $material[0]->volume_unit,
            "mrp_controller" => $material[0]->mrp_controller,
            "valuation_class" => $material[0]->valuation_class,
            "tax_classification" => $material[0]->tax_classification,
            "account_assign" => $material[0]->account_assign,
            "general_item" => $material[0]->general_item,
            "avail_check" => $material[0]->avail_check,
            "transportation_group" => $material[0]->transportation_group,
            "loading_group" => $material[0]->loading_group,
            "profit_center" => $material[0]->profit_center,
            "mrp_type" => $material[0]->mrp_type,
            "period_sle" => $material[0]->period_sle,
            "cash_discount" => $material[0]->cash_discount,
            "price_unit" => $material[0]->price_unit,
            "locat" => $material[0]->locat,
            "material_type" => $material[0]->material_type,
            "remarks" => $material[0]->remarks,
        );


        $data['div'] = ($param->division ? $this->getMaster('div',$param->division) : '');
        $data['plant'] = ($param->plant ? $this->getMaster('plant',$param->plant) : '');
        $data['location'] = ($param->locat ? $this->getMaster('location', $param->locat):'');
        $data['mrp_controller'] = ($param->mrp_controller ? $this->getMaster('mrp_controller', $param->mrp_controller):'');
        $data['valuation_class'] = ($param->valuation_class ? $this->getMaster('valuation_class', $param->valuation_class) : '');
        $data['industry_sector'] = ($param->industri_sector ? $this->getMaster('industry_sector', $param->industri_sector) : '');
        $data['material_type'] = ($param->material_type ? $this->getMaster('material_type', $param->material_type) : '');
        $data['dist_channel'] = ($param->dist_channel ? $this->getMaster('dist_channel', $param->dist_channel) : '');
        $data['item_cat'] = ($param->item_cat_group ? $this->getMaster('item_cat', $param->item_cat_group) : '');
        $data['tax_class'] = ($param->tax_classification ? $this->getMaster('tax_class', $param->tax_classification) : '');
        $data['account_assign'] = ($param->account_assign ? $this->getMaster('account_assign', $param->account_assign) : '');
        $data['avail_check'] = ($param->avail_check ? $this->getMaster('avail_check', $param->avail_check) : '');
        $data['trans_group'] = ($param->transportation_group ? $this->getMaster('trans_group', $param->transportation_group) : '');
        $data['loading_group'] = ($param->loading_group ? $this->getMaster('loading_group', $param->loading_group) : '');
        $data['profit_center'] = ($param->profit_center ? $this->getMaster('profit_center', $param->profit_center) : '');
        $data['mrp_type'] = ($param->mrp_type ? $this->getMaster('mrp_type', $param->mrp_type) : '');
        $data['sle'] = ($param->period_sle ? $this->getMaster('sle', $param->period_sle) : '');
        $data['sales_org'] = ($param->sales_org ? $this->getMaster('sales_org', $param->sales_org) : '');
        $data['store_loc'] = $param->store_loc;
        $data['price_unit'] = $param->price_unit;
        $data['plant_id'] = $param->plant;
        $data['cash_discount'] = ($param->cash_discount == 0 ? 'No':'yes');
        $data['mat_group_name'] = ($param->mat_group ? $this->material_group($param->mat_group):'');
        $data['store_loc_name'] = ($param->store_loc ? $this->store_loc($param->store_loc, $param->plant):'');
        $data['material'] = $param;

        return view('materialrequest/edit', $data);
    }

    function getMaster($gen_code, $code) {
        $data = DB::table('tm_general_data')->where(array("general_code" => $gen_code, "description_code" => $code))->pluck('description');
        return $data[0];
    }

    function material_group($id) {
        $service = API::exec(array(
            'request' => 'GET',
            'host' => 'ldap',
            'method' => "material_group"
        ));

        $data = $service;
     
        $mat_group = '';
        foreach ($data->data as $row) {
          foreach($row as $detail) {
                if ($detail->MATKL === $id) {
                    $mat_group = $detail->MATKL . " - " . str_replace("_", " ", $detail->WGBEZ);
                } 
          }
        }

        return $mat_group;
    }

    public function get_files()
    {
        $no_document = $_REQUEST['doc_no'];
        $service = API::exec(array(
            'request' => 'GET',
            'method' => 'tr_files/' . str_replace('/','_', $no_document)
        ));
        $data = $service;
        if ($data->status === "failed") {
            $arr = array();
        } else {
            $arr = $data->data;
        }

        return response()->json(array('data' =>$arr));
    }

    function store_loc($id, $plant) {
        $service = API::exec(array(
            'request' => 'GET',
            'host' => 'ldap',
            'method' => "store_loc/" . $plant . '/' .$plant
        ));
        $data = $service;

        $store_loc = '';
        if($data) {
            if(count($data->data) > 0) {
                foreach ($data->data as $row) {
                    if( $row->LGOR === $id) {
                        $store_loc = $row->LGOR . " - " . str_replace("_", " ", $row->LGOBE);
                    }
                }
            }
        }   
        return $store_loc;
    }


    function material($id) {
        $result = array();
        $service = API::exec(array(
            'request' => 'GET',
            'method' => 'tr_materials/' . $id
        ));

        $res = $service;
        if ($res->status === 'success') {
            $result = $res->data;
        }

        return $result;
    } 

    public function edit($id)
    {
        //
    }

}
