<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Services\UserServices;

use App\Models\User;


class UserController extends Controller
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
            $items = User::latest()->paginate($limit);
        }else{
            $items = User::where('name', 'like', '%'.$keywords.'%')
            ->orWhere('email', 'like', '%'.$keywords.'%')
            ->orWhere('username', 'like', '%'.$keywords.'%')
            ->orWhere('role', 'like', '%'.$keywords.'%')
            ->paginate($limit);
        }

        $response = [
            'code' => 200,
            'message' => 'success get user',
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
                'email' => 'required|email|unique:users',
                'name' => 'required',
                'username' => 'required|unique:users',
                'role' => 'required',
                'password' => 'required',
            ],[
                'email.unique' => 'email tersebut sudah digunakan',
                'email.required' => 'email harap diisi ',
                'email.email' => 'format email tidak valid',
                'name.required' => 'nama harap diisi ',
                'username.required' => 'username harap diisi ',
                'username.unique' => 'username tersebut sudah digunakan ',
                'role.required' => 'role harap diisi ',
                'password.required' => 'password harap diisi ',
            ]);

            if ($validator->passes()) {


                $result = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'created_by' =>   Auth::user()->email,
                ]);

                if($result){

                    return response()->json([
                        'code' => 200,
                        'message' => 'tambah user berhasil',
                        'data' => $result,
                    ],200);
                }

            }else{

                return response()->json([
                    'code' => 401,
                    'message' => 'tambah user gagal',
                    'error' => implode('<br>',$validator->errors()->all()),
                ],401);

            }


        }else{

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'email' => "required|unique:users,email,{$request->id}",
                'username' => "required|unique:users,username,{$request->id}",
                'role' => 'required',
            ],[
                'id.required' => 'id harap diisi',
                'email.required' => 'email harap diisi',
                'email.unique' => 'email tersebut sudah digunakan',
                'username.required' => 'username harap diisi',
                'username.unique' => 'username tersebut sudah digunakan',
                'name.required' => 'nama harap diisi',
                'role.required' => 'role harap diisi',
            ]);

            if ($validator->passes()) {


                $data_array = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'role' => $request->role,
                    'updated_by' =>   Auth::user()->email,
                ];

                if($request->has('password') && !empty($request->password)){
                    $data_passw['password'] = Hash::make($request->password);
                    $data_array = array_merge($data_array, $data_passw);
                }

                $result=User::where('id', $request->id)
                    ->update($data_array);

                if($result){

                    return response()->json([
                        'code' => 200,
                        'message' => 'ubah user berhasil',
                        'data' => $result,
                    ]);
                }

            }else{

                return response()->json([
                    'code' => 401,
                    'message' => 'ubah user gagal',
                    'error' => implode(',',$validator->errors()->all()),
                ]);

            }

        }

        return response()->json([
            'code' => 401,
            'message' => 'simpan user gagal',
        ],401);

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id = null)
    {
        $user=User::where('id',$id)->first();
        if($user){
            return response()->json([
                'code' => 200,
                'message' => 'mengambil data user berhasil',
                'data' => $user,
            ],200);
        }
        return response()->json([
            'code' => 400,
            'message' => 'mengambil data user gagal',
        ],401);
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
    public function destroy(Request $request)
    {
        $deleted=User::destroy($request->id);
        if($deleted){
            return response()->json([
                'code' => 200,
                'message' => 'hapus user berhasil',
                'data' => $deleted,
            ],200);
        }
        return response()->json([
            'code' => 400,
            'message' => 'hapus user gagal',
        ],401);
    }


}
