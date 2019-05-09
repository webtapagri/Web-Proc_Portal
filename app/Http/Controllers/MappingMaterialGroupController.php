<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\TrUser;
use function GuzzleHttp\json_encode;
use Session;
use API;
use AccessRight;
class MappingMaterialGroupController extends Controller
{
    public function index()
    {
        if (empty(Session::get('authenticated')))
            return redirect('/login');

        if (AccessRight::granted() == false)
            return response(view('errors.403'), 403);

        $access = AccessRight::access();

        return view('mapping.mat_group')->with(compact('access')); 
    }

    public function dataGrid() {
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tm_mapping_matgroup"
        ));
        $data = $service;

        return response()->json(array('data' => $data->data));

    }

    public function store(Request $request)
    {
       try {
            $param["mat_group"] = $request->mat_group;
            $param["valuation_class"] = $request->valuation_class;
            $param["material_type"] = $request->material_type;
            
            if($request->edit_id) {
                $param["updated_at"] = date('Y-m-d H:i:s');
                $param["updated_by"] = Session::get('user');
                $data = API::exec(array(
                    'request' => 'PUT',
                    'method' => 'tm_mapping_matgroup/' . $request->edit_id,
                    'data' => $param
                ));

                $res = $data;
                if ($res->code == '201') {
                    return response()->json(['status' => true, "message" => 'Data is successfully ' . ($request->edit_id ? 'updated' : 'added')]);;
                } else {
                    return response()->json(['status' => false, "message" => $res->message]);
                }
            } else {
                if($this->validateMatGroup($request->mat_group)) {
                    $param["created_at"] = date('Y-m-d H:i:s');
                    $param["created_by"] = Session::get('user');
                    $data = API::exec(array(
                        'request' => 'POST',
                        'method' => 'tm_mapping_matgroup',
                        'data' => $param
                    ));

                    $res = $data;
                    if ($res->code == '201') {
                        return response()->json(['status' => true, "message" => 'Data is successfully ' . ($request->edit_id ? 'updated' : 'added')]);;
                    } else {
                        return response()->json(['status' => false, "message" => $res->message]);
                    }
                } else{
                    return response()->json(['status' => false, "message" => 'Material Group already already exist!']);
                }
            }
            
       } catch (\Exception $e) {
            return response()->json(['status' => false, "message" => $e->getMessage()]);
       }
    }

    public function validateMatGroup($matgroup) {
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tm_mapping_matgroup/" . $matgroup
        ));
        $profile = $service->data;    
        if($profile) {
            return false;
        } else {
            return true;
        }

    }

    public function show()
    {
        $param = $_REQUEST;
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tm_mapping_matgroup/" . $param["id"]
        ));
        $data = $service;
        return response()->json(array('data' => $data->data));
    }

    public function inactive(Request $request) {
        try {
            $param["updated_by"] = Session::get('user');
            $data = API::exec(array( 
                'request' => 'DELETE',
                'method' => 'tm_mapping_matgroup/' . $request->id ,
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

}
