<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use function GuzzleHttp\json_encode;
use Session;
use API;
use AccessRight;

class RolesController extends Controller
{

    public function index()
    {
        if (empty(Session::get('authenticated')))
            return redirect('/login');

        if (AccessRight::granted() == false)
            return response(view('errors.403'), 403);;

        $access = AccessRight::access();    
        return view('usersetting.roles')->with(compact('access'));
    }

    public function dataGrid()
    {
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tm_role"
        ));
        $data = $service;

        return response()->json(array('data' => $data->data));
    }

    public function store(Request $request)
    {
        try {
            $param["id"] = $request->role_id;
            $param["role_name"] = $request->name;
            $param["role_active"] = 1;

            if ($request->edit_id) {
                $param["updated_at"] = date('Y-m-d H:i:s');
                $param["updated_by"] = Session::get('user');
                $data = API::exec(array(
                    'request' => 'PUT',
                    'method' => 'tm_role/' . $request->edit_id,
                    'data' => $param
                ));
            } else {
                $param["created_at"] = date('Y-m-d H:i:s');
                $param["created_by"] = Session::get('user');
                $data = API::exec(array(
                    'request' => 'POST',
                    'method' => 'tm_role',
                    'data' => $param
                ));
            }

            $res = $data;
            if ($res->code == '201') {
                return response()->json(['status' => true, "message" => 'Data is successfully ' . ($request->edit_id ? 'updated' : 'added')]);;
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
            'method' => "tm_role/" . $param["id"]
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
                'method' => 'tm_role/' . $request->id . '/0',
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
                'method' => 'tm_role/' . $request->id . '/1',
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
