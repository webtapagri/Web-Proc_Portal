<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use function GuzzleHttp\json_encode;
use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Session;
use AccessRight;
use API;


class AccessRightController extends Controller
{
    public function index()
    {
        if (empty(Session::get('authenticated')))
            return redirect('/login');

        if (AccessRight::granted() == false)
            return response(view('errors.403'), 403);;

        $access = AccessRight::access();
        
        return view('usersetting.accessright')->with(compact('access'));
    }

    public function dataGrid()
    {
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tr_role_accessright"
        ));
        $data = $service->data;

        return response()->json(array('data' => $data));
    }

    public function show()
    {
        $param = $_REQUEST;
        $data = explode('-', $param["id"]);
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tr_role_accessright/" . $data[0] .'/'. $data[1] .'/'. $data[2]
        ));
        $data = $service->data;

        return response()->json(array('data' => $data));

    }

    public function store(Request $request)
    {
        try {
            $param["menu_code"] = \trim($request->menu) ;
            $param["id_role"] = \trim($request->role_id);
            $param["operation"] = trim($request->operation);
            $param["description"] = $request->description;

            if ($request->edit_id) {
                $data = explode('-', $request->edit_id);

                $param["updated_at"] = date('Y-m-d H:i:s');
                $param["updated_by"] = Session::get('user');

                $data = API::exec(array(
                    'request' => 'PUT',
                    'method' => "tr_role_accessright/" . $data[0] . '/' . $data[1] . '/' . $data[2],
                    'data' => $param
                ));
            } else {
                $param["created_at"] = date('Y-m-d H:i:s');
                $param["created_by"] = Session::get('user');
                $data = API::exec(array(
                    'request' => 'POST',
                    'method' => 'tr_role_accessright',
                    'data' => $param
                ));
            }
            $res = $data;
            if ($res->code == '201') {
                if($res->status == 'failed') {
                    return response()->json(['status' => true, "exist"=>true, "message" => $res->message]);
                }else {
                    return response()->json(['status' => true, "exist" => false, "message" => 'Data is successfully ' . ($request->edit_id ? 'updated' : 'added')]);
                }
            } else {
                return response()->json(['status' => false, "message" => $res->message]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, "message" => $e->getMessage()]);
        }
    }

    public function inactive(Request $request)
    {
        try {
            $param = explode('-', $request->id);
            $data = API::exec(array(
                'request' => 'DELETE',
                'method' => "tr_role_accessright/" . $param[0] . '/' . $param[1] . '/' . $param[2]
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

    public function get_menu()
    {
        $service = API::exec(array(
            'request' => 'GET',
            'method' => "tm_menu"
        ));
        $data = $service->data;
        $item = array();
        foreach ($data as $row) {
            $item[] = array(
                'id' => $row->menu_code,
                'text' => $row->menu_name
            );
        }

        return response()->json(array('data' => $item));
    }
}
