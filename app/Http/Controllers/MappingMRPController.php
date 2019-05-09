<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\TrUser;
use function GuzzleHttp\json_encode;
use Session;
use API;
use AccessRight;
class MappingMRPController extends Controller
{
    public function index()
    {
        if (empty(Session::get('authenticated')))
            return redirect('/login');

        if (AccessRight::granted() == false)
            return response(view('errors.403'), 403);

        $access = AccessRight::access();

        return view('mapping.mrp')->with(compact('access'));
    }

    public function dataGrid() {
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tm_mapping_mrp"
        ));
        $data = $service;

        return response()->json(array('data' => $data->data));

    }

    public function store(Request $request)
    {
       try {
            $param["mat_group"] = $request->mat_group;
            $param["plant"] = $request->plant;
            $param["mrp_controller"] = $request->mrp_controller;
            
            if($request->edit_id) {
                var_dump('01');
                $data = API::exec(array(
                    'request' => 'PUT',
                    'method' => 'tm_mapping_mrp/' . $request->edit_id,
                    'data' => $param
                ));

                $res = $data;
                if ($res->code == '201') {
                    return response()->json(['status' => true, "message" => 'Data is successfully ' . ($request->edit_id ? 'updated' : 'added')]);;
                } else {
                    return response()->json(['status' => false, "message" => $res->message]);
                }
            } else {
                $data = API::exec(array(
                    'request' => 'POST',
                    'method' => 'tm_mapping_mrp',
                    'data' => $param
                ));

                $res = $data;
                if ($res->code == '201') {
                    return response()->json(['status' => true, "message" => 'Data is successfully ' . ($request->edit_id ? 'updated' : 'added')]);;
                } else {
                    return response()->json(['status' => false, "message" => $res->message]);
                    }
            }
            
       } catch (\Exception $e) {
            return response()->json(['status' => false, "message" => $e->getMessage()]);
       }
    }

    public function validateMatGroup($matgroup) {
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tm_mapping_mrp/" . $matgroup
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
            'method' => "tm_mapping_mrp/" . $param["id"]
        ));
        $data = $service;
        return response()->json(array('data' => $data->data));
    }

    public function inactive(Request $request) {
        try {
            $param["updated_by"] = Session::get('user');
            $data = API::exec(array( 
                'request' => 'DELETE',
                'method' => 'tm_mapping_mrp/' . $request->id ,
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
