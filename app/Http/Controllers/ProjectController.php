<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        $keywords = (isset($request['keywords']))?$request['keywords']:'';
        $limit = (isset($request['limit']))?$request['limit']:20;
        if(empty($keywords)){
            $items = Project::latest()->paginate($limit);
        }else{
            $items = Project::where('name', 'like', '%'.$keywords.'%')
            ->orWhere('code', 'like', '%'.$keywords.'%')
            ->orWhere('vendor', 'like', '%'.$keywords.'%')
            ->paginate($limit);
        }

        $response = [
            'code' => 200,
            'message' => 'success get project',
            'data' => $items,
        ];
        return response()->json($response, 200);

    }

    public function getTrash(Request $request){

        $keywords = (isset($request['keywords']))?$request['keywords']:'';
        $limit = (isset($request['limit']))?$request['limit']:20;
        if(empty($keywords)){
            $items = Project::onlyTrashed()->latest()->paginate($limit);
        }else{
            $items = Project::onlyTrashed()->where('name', 'like', '%'.$keywords.'%')
            ->orWhere('code', 'like', '%'.$keywords.'%')
            ->orWhere('vendor', 'like', '%'.$keywords.'%')
            ->paginate($limit);
        }

        $response = [
            'code' => 200,
            'message' => 'success get project trash',
            'data' => $items,
        ];
        return response()->json($response, 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->mode=='add'){

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:projects',
                'vendor' => 'required',
            ],[
                'name.required' => 'nama harap diisi ',
                'name.unique' => 'nama tersebut sudah digunakan ',
                'vendor.required' => 'vendor harap diisi ',
            ]);

            if ($validator->passes()) {


                $result = Project::create([
                    'code' => strtoupper(uniqid('PRO-')),
                    'name' => $request->name,
                    'vendor' => $request->vendor,
                    'created_by' =>   Auth::user()->email,
                ]);

                if($result){

                    return response()->json([
                        'code' => 200,
                        'message' => 'tambah proyek berhasil',
                        'data' => $result,
                    ],200);
                }

            }else{

                return response()->json([
                    'code' => 401,
                    'message' => 'tambah proyek gagal',
                    'error' => implode('<br>',$validator->errors()->all()),
                ],401);

            }


        }else{

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => "required|unique:projects,name,{$request->id}",
                'vendor' => 'required',
            ],[
                'id.required' => 'id harap diisi',
                'name.required' => 'nama harap diisi',
                'name.unique' => 'kategori tersebut sudah digunakan',
                'vendor.required' => 'vendor harap diisi',
            ]);

            if ($validator->passes()) {

                $data_array = [
                    'name' => $request->name,
                    'vendor' => $request->vendor,
                    'updated_by' =>   Auth::user()->email,
                ];

                $result=Project::where('id', $request->id)
                    ->update($data_array);

                if($result){

                    return response()->json([
                        'code' => 200,
                        'message' => 'ubah proyek berhasil',
                        'data' => $result,
                    ]);
                }

            }else{

                return response()->json([
                    'code' => 401,
                    'message' => 'ubah proyek gagal',
                    'error' => implode(',',$validator->errors()->all()),
                ]);

            }

        }

        return response()->json([
            'code' => 401,
            'message' => 'simpan proyek gagal',
        ],401);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id = null)
    {
        $data=Project::where('id',$id)->first();
        if($data){
            return response()->json([
                'code' => 200,
                'message' => 'mengambil data proyek berhasil',
                'data' => $data,
            ],200);
        }
        return response()->json([
            'code' => 400,
            'message' => 'mengambil data proyek gagal',
        ],401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $deleted=Project::withTrashed()->where('id', $request->id)->forceDelete();
        if($deleted){
            return response()->json([
                'code' => 200,
                'message' => 'hapus permanen proyek berhasil',
                'data' => $deleted,
            ],200);
        }
        return response()->json([
            'code' => 400,
            'message' => 'hapus permanen proyek gagal',
        ],401);
    }

    public function delete(Request $request)
    {
        $deleted=Project::find($request->id)->delete();
        if($deleted){
            return response()->json([
                'code' => 200,
                'message' => 'hapus proyek berhasil',
                'data' => $deleted,
            ],200);
        }
        return response()->json([
            'code' => 400,
            'message' => 'hapus proyek gagal',
        ],401);
    }

    public function restore(Request $request)
    {
        $deleted=Project::withTrashed()->where('id', $request->id)->restore();
        if($deleted){
            return response()->json([
                'code' => 200,
                'message' => 'restore proyek berhasil',
                'data' => $deleted,
            ],200);
        }
        return response()->json([
            'code' => 400,
            'message' => 'restore proyek gagal',
        ],401);
    }
}
