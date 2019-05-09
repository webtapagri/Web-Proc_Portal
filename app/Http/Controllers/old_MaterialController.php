<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\GroupMaterial;
use App\Material;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Stub\Exception;
use function GuzzleHttp\json_encode;
use Vyuldashev\XmlToArray\XmlToArray;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('materials.index');
    }


    public function groupMaterialGroup()
    {
        $data = DB::table('group_materials')->select('id', 'name', 'description', 'status')->where('status',0)->get();
        $json = '{"data":[';
        $no = 1;
        foreach ($data as $row) {
            if ($no > 1) {
                $json .= ",";
            }

            $arr = array(
                "no" => $no,
                "id" => $row->id,
                "name" => $row->name,
                "description" => str_replace(",", "<br>", ucwords(str_replace("-"," ",$row->description))),
                "action" => '
                    <button class="btn btn-xs btn-success btn-action" select="select data '.$row->name.'" onClick="SelectGroup(\''.$row->id.'\',\''.$row->name.'\',\''.$row->description.'\')">select</button>
                '
            );

            $json .= json_encode($arr);
            $no++;
        }
        $json .= ']}';
        echo $json;
    }

    public function getData()
    {
        $data = DB::table('materials')
        ->join('group_materials', 'materials.group_material_id','=', 'group_materials.id')
        ->select(
                "materials.id",
                "materials.material_no",
                "materials.sector_industry",
                "group_materials.name as group_material",
                "materials.description",
                "materials.part_no",
                "materials.specification",
                "materials.brand",
                "materials.material_sap",
                "materials.uom",
                "materials.status"
        )->get();

        $json = '{"data": [';
        $no = 1;
        foreach ($data as $row) {
            if ($no > 1) {
                $json .= ",";
            }

            if ($row->status == 1) {
                $status = '<span class="label label-danger status" data-status="'.$row->status.'">inactive</span>';
            } else {
                $status = '<span class="label label-success status" data-status="'.$row->status.'">active</span>';
            }

            $arr = array(
                "id" => $row->id,
                "no" => $no,
                "material_no" => $row->material_no,
                "sector_industry" => $row->sector_industry,
                "group_material" => $row->group_material,
                "description" => $row->description,
                "part_no" => $row->part_no,
                "specification" => $row->specification,
                "brand" => $row->brand,
                "material_sap" => $row->material_sap,
                "uom" => $row->uom,
                "status" => $status,
                "action" => '
                    <button class="btn btn-xs btn-success btn-action btn-edit"  onClick="edit('.$row->id.')"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-xs btn-danger btn-action btn-activated '.($row->status == 0 ? '' : 'hide').'" onClick="inactive('.$row->id.')"><i class="fa fa-trash"></i></button>
                    <button class="btn btn-xs btn-success btn-action btn-inactivated '.($row->status == 1 ? '' : 'hide').'" onClick="active('.$row->id.')"><i class="fa fa-check"></i></button>
                '
            );

            $json .= json_encode($arr);
            $no++;
        }
        $json .= ']}';
        echo $json;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if ($request->edit_id) {
                $material = Material::find($request->edit_id);
            } else {
                $material = new Material();
            }

            $material->material_no = $request->material_no;
            $material->sector_industry = $request->sector_industry;
            $material->group_material_id = $request->group_material_id;
            $material->description = $request->description;
            $material->part_no = $request->part_no;
            $material->specification = $request->specification;
            $material->brand = $request->brand;
            $material->material_sap = $request->material_sap;
            $material->uom = $request->uom;
            $material->status = 0;

            $material->save();

            return response()->json(['status' => true, "message" => 'Data is successfully ' . ($request->edit_id ? 'updated' : 'added')]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, "message" => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $param = $_REQUEST;
        $json = '{"data":[';
        $data = DB::table('materials')->where('id', $param["id"])->get();
        foreach ($data as $row) {
            $json .= json_encode($row);
        }
        $json .= ']}';
        echo $json;
    }

    public function inactive(Request $request)
    {
        $group_material = Material::find($request->id);
        $group_material->status = 1;
        $group_material->save();
        return response()->json(['status' => true, "message" => 'Data is successfully inactived']);
    }

    public function active(Request $request)
    {
        $group_material = Material::find($request->id);
        $group_material->status = 0;
        $group_material->save();
        return response()->json(['status' => true, "message" => 'Data is successfully actived']);
    }

    public function sap_group_material()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://10.20.1.140:8000/sap/bc/soap/wsdl11?services=ZFMDB_GROUPMATERIAL&sap-client=700');
        $data = simplexml_load_string($res->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);

        $xml = XmlToArray::convert($res->getBody());
        echo '<pre>'; print_r($xml);
        exit();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
