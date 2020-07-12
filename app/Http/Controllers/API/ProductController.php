<?php

namespace App\Http\Controllers\API;

use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return new ProductCollection(Product::where('name', 'LIKE', "%$request->search%")->where('code', 'LIKE', "%$request->search%")->orderBy('id', 'desc')->paginate(10));
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
            'category' => 'required|exists:category,id',
            'description' => 'required',
            'stock' => 'required',
            'price' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        if ($request->hasFile('photo') == true) {
            $photo = $request->file('photo');
            $photo_name = date('siHdmY') . '_' . $photo->getClientOriginalName();
            $photo->move('images/products/', $photo_name);
            $image = '/images/products/' . $photo_name;
        } else {
            $image = $request->image;
        }

        $kalimat = explode(" ", $request->name);
        for ($i = 0; $i < count($kalimat); $i++) {
            $str_kode = str_split($kalimat[$i][0]);
            $kode[$i] = strtoupper(implode($str_kode));
        }
        $kode = implode($kode);

        if ($request->id == true) {
            $data_nomor = Product::find($request->id)->first();
            $nomor = $data_nomor->nomor;
        } else {
            $max = Product::max('nomor');
            $angka = $max + 1;
            if (strlen($angka) == 1) {
                $nomor = "0000" . $angka;
            } else if (strlen($angka) == 2) {
                $nomor = "000" . $angka;
            } else if (strlen($angka) == 3) {
                $nomor = "00" . $angka;
            } else if (strlen($angka) == 4) {
                $nomor = "0" . $angka;
            } else {
                $nomor = $angka;
            }
        }

        Product::UpdateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'name' => $request->name,
                'nomor' => $nomor,
                'code' => $kode . '-' . $nomor,
                'slug' => Str::slug($request->name),
                'category_id' => $request->category,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'image' => $image,
            ]
        );

        return response(['success' => true], 200);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $products = Product::with('discount')->where('name', 'LIKE', "%$search%")->orWhere('code', 'LIKE', "%$search%")->orderBy('name', 'ASC')->limit(5)->get();
        return response()->json($products);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Product::findOrFail($id);
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
        Product::find($id)->delete();
        return response()->json(['status' => true]);
    }
}
