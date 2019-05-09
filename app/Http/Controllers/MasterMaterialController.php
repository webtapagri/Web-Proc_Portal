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

class MasterMaterialController extends Controller
{
    public function index() {
        if (empty(Session::get('authenticated')))
            return redirect('/login');
        
        if (AccessRight::granted() == false)
            return response(view('errors.403'), 403);;

        $access = AccessRight::access();   
        return view('mastermaterial/index')->with(compact('access'));
    }

    public function getMaterial() {
        $data = DB::table("tm_material")->get();
        return $data;
    }

    public function get_material_user_grid(Request $request) {
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tr_materials_union/" . $request->length . '/' . $request->start .'/'. $request->draw .'/' .($request->search_material ? \str_replace('/','_', $request->search_material):'null')
        ));
       
        $data = $service;

        return response()->json( $data);
    }
    
    public function get_material_user_grid_search() {
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tr_materials_union_limit/".(!empty($_REQUEST['search']) ? $_REQUEST['search'] : '')
        ));

        $data = $service;
        return response()->json(array('data' => $data->data));
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
}