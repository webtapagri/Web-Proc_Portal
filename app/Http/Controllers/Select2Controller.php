<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use API;
use Session;

class Select2Controller extends Controller
{

    public function get(Request $request){
         $table = $request->get('table');
         $id = $request->get('id');
         $text = $request->get('text');
        $where = '';
        if( $request->get('wheres')) {
            $no = 1;
            foreach( $request->get('wheres') as $row) {
                $param = explode(',',$row);
                if($no>1) {
                    $where .= ' AND';
                }
                if($param[1] == 'equal') {
                    $where .= $param[0]."= '".$param[2]."'";
                }
                $no++;
            }
        }
        
         $data = DB::table("$table")
         ->select($id . ' as id', $text . ' as text')
         ->whereRaw($where)
         ->get();

        $arr = array();
        foreach ($data as $row) {
            $arr[] = array(
                "id" => $row->id,
                "text" => $row->id .'-' . $row->text
            );
        }

        return response()->json(array('data' => $arr));
    }
}
