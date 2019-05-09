<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\GroupMaterial;
use Session;
use API;
use AccessRight;

class SetMaterialController extends Controller
{

    public function index()
    {
        if (empty(Session::get('authenticated')))
            return redirect('/login');

        $access = AccessRight::access();
        return view('setmaterial.index')->with(compact('access'));
    }

    public function dataGrid() {

        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tm_set_material"
        ));
        $data = $service;
        return response()->json(array('data' => $data->data));
    }

    public function store(Request $request)
    {
        try {
            $param["mat_group"] = trim($request->material_group);
            $param["description"] = trim( $request->description);
            $param["latest_code"] = trim($request->latest_code);
            $param["status"] = 1;

            if($request->edit_id) {
                $data = API::exec(array(
                    'request' => 'PUT',
                    'method' => 'tm_set_material/' . $request->edit_id,
                    'data' => $param
                ));
            } else {
                $data = API::exec(array(
                    'request' => 'POST',
                    'method' => 'tm_set_material',
                    'data' => $param
                ));
            }

            $res = $data;
            if ($res->code == '201') {
                return response()->json(['status' => true, "message" => 'Data is successfully ' . ($request->edit_id ? 'updated' : 'added')]);
             } else {
                return response()->json(['status' => false, "message" => $res->message]);
            }
            
       } catch (\Exception $e) {
            return response()->json(['status' => false, "message" => $e->getMessage()]);
       }
    }

    public function show()
    {
        $param = $_REQUEST;
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tm_set_material/" . $param["id"]
        ));
        $data = $service;

        return response()->json(array('data' => $data->data));
    }

    public function inactive(Request $request)
    {
        try {
            $param["updated_by"] = Session::get('user');
            $data = API::exec(array(
                'request' => 'ACTIVE',
                'method' => 'tm_set_material/' . $request->id . '/0',
                'data' => $param
            ));

            $res = $data;

            if ($res->code == '201') {
                return response()->json(['status' => true, "message" => 'Data is successfully inactived']);;
            } else {
                return response()->json(['status' => false, "message" => $res->message]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, "message" => $e->getMessage()]);
        }
    }

    public function active(Request $request)
    {
        try {
            $param["updated_by"] = Session::get('user');
            $data = API::exec(array(
                'request' => 'ACTIVE',
                'method' => 'tm_set_material/' . $request->id . '/1',
                'data' => $param
            ));

            $res = $data;

            if ($res->code == '201') {
                return response()->json(['status' => true, "message" => 'Data is successfully inactived']);;
            } else {
                return response()->json(['status' => false, "message" => $res->message]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, "message" => $e->getMessage()]);
        }
    }

    public function get_material_group()
    {
        $url = "http://tap-ldapdev.tap-agri.com/data-sap/material_group";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);

        $result = $response->getBody()->getContents();
        $data = json_decode($result);
        $json = '{"data":[';
        for ($i=0; $i < count($data->data[0]); $i++) { 

            if($i>0) {
                $json .= ",";
            }
            $arr = array(
                "id"=> $data->data[0][$i]->MATKL,
                "text"=> $data->data[0][$i]->MATKL." - ". str_replace("_"," ", $data->data[0][$i]->WGBEZ60)
            );
            $json .= json_encode($arr); 
        }    

        $json .="]}";
        echo $json;
    }
}
