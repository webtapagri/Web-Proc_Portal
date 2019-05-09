<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\TmRole;
use function GuzzleHttp\json_encode;
use Session;
use API;
use AccessRight;

class MenuController extends Controller
{

    public function index()
    {
        if (empty(Session::get('authenticated')))
            return redirect('/login');
            
        if (AccessRight::granted() == false)
            return response(view('errors.403'), 403);;

        $access = AccessRight::access();
        return view('usersetting.menu')->with(compact('access'));
    }

    public function dataGrid()
    {
        $service =API::exec(array(
            'request' => 'GET',
            'method' => "tm_menu"
        ));
        $data = $service;

        return response()->json(array('data' => $data->data));
    }

    public function store(Request $request)
    {
        try {
            $param["menu_code"] = $request->code;
            $param["menu_name"] = $request->name;
            $param["url"] = $request->url;
            $param["sorting"] = $request->sorting;

            if ($request->edit_id) {
                $param["updated_at"] = date('Y-m-d H:i:s');
                $param["updated_by"] = Session::get('user');
                $data =API::exec(array(
                    'request' => 'PUT',
                    'method' => 'tm_menu/' . $request->edit_id,
                    'data' => $param
                ));
            } else {
                if($this->validateCode($request->code)) {
                    $param["created_at"] = date('Y-m-d H:i:s');
                    $param["created_by"] = Session::get('user');
                    $data =API::exec(array(
                        'request' => 'POST',
                        'method' => 'tm_menu',
                        'data' => $param
                    ));
                } else {
                    return response()->json(['status' => false, "message" => "Menu code sudah digunakan"]);
                    exit();
                }
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

    function validateCode($code) {
        $service =API::exec(array(
            'request' => 'GET',
            'method' => "tm_menu/" . $code
        ));
        $res = $service;
        if ($res->data) {
            return false;
        } else {
            return true;
        }
    }

    public function show()
    {
        $param = $_REQUEST;
        $service =API::exec(array(
            'request' => 'GET',
            'method' => "tm_menu/" . $param["id"]
        ));
        $data = $service;

        return response()->json(array('data' => $data->data));
        
    }

    public function inactive(Request $request)
    {
        try {
            $data =API::exec(array(
                'request' => 'DELETE',
                'method' => 'tm_menu/' . $request->id,
            ));

            $res = $data;

            if ($res->code == '201') {
                return response()->json(['status' => true, "message" => 'Data is successfully deleted']);;
            } else {
                return response()->json(['status' => false, "message" => $res->message]);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => false, "message" => $e->getMessage()]);
        }
    }
}
