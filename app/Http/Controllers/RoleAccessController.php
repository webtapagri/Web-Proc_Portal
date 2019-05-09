<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\TmRole;
use function GuzzleHttp\json_encode;
use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Session;

class RoleAccessController extends Controller
{

    public function index()
    {
        if (empty(Session::get('authenticated')))
            return redirect('/login');

        return view('usersetting.role_access');
    }


    public function store(Request $request)
    {

        try {
            if ($request->edit_id) {
                $data = TmRole::find($request->edit_id);
                $data->updated_at = date('Y-m-d');
                $data->updated_by = Session::get('user');
            } else {
                $data = new TmRole();
                $data->created_at = date('Y-m-d');
                $data->created_by = Session::get('user');
            }

            $data->role_name = $request->name;
            $data->id = $request->role_id;
            $data->role_active = 1;

            $data->save();

            return response()->json(['status' => true, "message" => 'Data is successfully ' . ($request->edit_id ? 'updated' : 'added')]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, "message" => $e->getMessage()]);
        }
    }


    public function show()
    {
        $param = $_REQUEST;
        $data = DB::table('tm_role')->where('id', $param["id"])->get();
        return response()->json(array('data' => $data));
    }
}
