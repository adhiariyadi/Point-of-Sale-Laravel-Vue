<?php

namespace App\Http\Controllers\API;

use App\Model\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CustomerCollection;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return new CustomerCollection(Customer::where('name', 'LIKE', "%$request->search%")->orderBy('id', 'DESC')->paginate(10));
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
            'name' => 'required',
            'alamat' => 'required',
            'phone' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'email' => 'required|email',
            'photo' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        if ($request->hasFile('photo') == true) {
            $photo = $request->file('photo');
            $photo_name = date('siHdmY') . '_' . $photo->getClientOriginalName();
            $photo->move('images/customers/', $photo_name);
            $image = '/images/customers/' . $photo_name;
        } else {
            $image = $request->image;
        }

        Customer::UpdateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'provinsi' => $request->provinsi,
                'level' => $request->level,
                'image' => $image,
            ]
        );

        return response(['success' => true], 200);
    }

    public function all()
    {
        return new CustomerCollection(Customer::orderBy('name', 'asc')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Customer::findorfail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Customer::findorfail($id);
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
        Customer::find($id)->delete();
        return response(['success' => true], 200);
    }
}
