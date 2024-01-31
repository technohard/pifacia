<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
            $items = Category::latest()->paginate($limit);
        }else{
            $items = Category::where('name', 'like', '%'.$keywords.'%')
            ->paginate($limit);
        }

        $response = [
            'code' => 200,
            'message' => 'success get category',
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
                'name' => 'required|unique:categories',
            ],[
                'name.required' => 'nama harap diisi ',
                'name.unique' => 'nama tersebut sudah digunakan ',
            ]);

            if ($validator->passes()) {


                $result = Category::create([
                    'name' => $request->name,
                    'created_by' =>   Auth::user()->email,
                ]);

                if($result){

                    return response()->json([
                        'code' => 200,
                        'message' => 'tambah kategori berhasil',
                        'data' => $result,
                    ],200);
                }

            }else{

                return response()->json([
                    'code' => 401,
                    'message' => 'tambah kategori gagal',
                    'error' => implode('<br>',$validator->errors()->all()),
                ],401);

            }


        }else{

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => "required|unique:categories,name,{$request->id}",
            ],[
                'id.required' => 'id harap diisi',
                'name.required' => 'nama harap diisi',
                'name.unique' => 'kategori tersebut sudah digunakan',
            ]);

            if ($validator->passes()) {


                $data_array = [
                    'name' => $request->name,
                    'updated_by' =>   Auth::user()->email,
                ];

                $result=Category::where('id', $request->id)
                    ->update($data_array);

                if($result){

                    return response()->json([
                        'code' => 200,
                        'message' => 'ubah kategori berhasil',
                        'data' => $result,
                    ]);
                }

            }else{

                return response()->json([
                    'code' => 401,
                    'message' => 'ubah kategori gagal',
                    'error' => implode(',',$validator->errors()->all()),
                ]);

            }

        }

        return response()->json([
            'code' => 401,
            'message' => 'simpan kategori gagal',
        ],401);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id = null)
    {
        $data=Category::where('id',$id)->first();
        if($data){
            return response()->json([
                'code' => 200,
                'message' => 'mengambil data kategori berhasil',
                'data' => $data,
            ],200);
        }
        return response()->json([
            'code' => 400,
            'message' => 'mengambil data kategori gagal',
        ],401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $deleted=Category::destroy($request->id);
        if($deleted){
            return response()->json([
                'code' => 200,
                'message' => 'hapus kategori berhasil',
                'data' => $deleted,
            ],200);
        }
        return response()->json([
            'code' => 400,
            'message' => 'hapus kategori gagal',
        ],401);
    }
}
