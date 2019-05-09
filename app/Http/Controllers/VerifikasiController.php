<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use Session;
use API;
use AccessRight;

class VerifikasiController extends Controller
{
    public function index()
    {
        if(empty(Session::get('authenticated')))
            return redirect('/login');

        if (AccessRight::granted() == false)
            return response(view('errors.403'), 403);;

        $access = AccessRight::access();    
        return view('verifikasi')->with(compact($access));
    }

    public function dataGrid()
    {
        $role_id = Session::get('role_id');
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "outstanding/" . $role_id 
        ));
        $data = $service;

        return response()->json(array('data' => $data->data));

    }

    public function store(Request $request) {
       try {
            $param["user_id"] = trim(Session::get('user_id'));
            $param["role_id"] = trim(Session::get('role_id'));
            $param["approve"] = $request->status;
            $param["execution_status"] = 'C';
            $param["document_code"] =  str_replace('/','_', $request->no_document);
            $param["updated_at"] = date('Y-m-d H:i:s');
            $param["updated_by"] = Session::get('user');
            $data =API::exec(array(
                'request' => 'PUT',
                'method' => 'tr_approval_update/' . $request->approval_id,
                'data' => $param
            ));

            $res = $data;

            if ($res->code == '201') {
                return response()->json(['status' => true, "message" => 'Data is updated successfully ']);;
            } else {
                return response()->json(['status' => false, "message" => $res->message]);
            }
       } catch (\Throwable $e) {
            return response()->json(['status' => false, "message" => $e->getMessage()]);
       }
    }
}