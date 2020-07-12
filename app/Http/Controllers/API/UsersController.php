<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return new UserCollection(User::where('name', 'LIKE', "%" . $request->search . "%")->orderBy('id', 'desc')->paginate(10));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'username' => 'required|min:6',
            'level' => 'required|in:Admin,Kasir',
            'address' => 'required',
            'phone' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        if ($request->hasFile('photo') == true) {
            $photo = $request->file('photo');
            $photo_name = date('siHdmY') . '_' . $photo->getClientOriginalName();
            $photo->move('images/users/', $photo_name);
            $image = '/images/users/' . $photo_name;
        } else {
            $image = $request->image;
        }

        if ($request->id == true) {
            if ($request->password == true) {
                $dataUser = [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'level' => $request->level,
                    'image' => $image,
                    'password' => Hash::make($request->password),
                ];
            } else {
                $dataUser = [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'level' => $request->level,
                    'image' => $image,
                ];
            }
        } else {
            $username = User::where('username', $request->username)->count();
            $email = User::where('email', $request->email)->count();
            if ($username > 0) {
                return response("username sudah terdaftar", 400);
            } elseif ($email > 0) {
                return response("email sudah terdaftar", 400);
            } else {
                $dataUser = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'level' => $request->level,
                    'image' => $image,
                    'password' => Hash::make($request->password),
                ];
            }
        }

        User::UpdateOrCreate(['id' => $request->id], $dataUser);

        return response(['success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::findorfail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return User::findorfail($id);
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
        User::find($id)->delete();
        return response(['status' => true]);
    }
}
