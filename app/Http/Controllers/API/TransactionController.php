<?php

namespace App\Http\Controllers\API;

use Ramsey\Uuid\Uuid;
use App\Model\Product;
use App\Model\Transaction;
use Illuminate\Http\Request;
use App\Model\TransactionDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TransactionCollection;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        // $search = $r->get('search');
        // return new TransactionCollection(Transaction::whereHas('details')->with(['details' => function($query) use ($id){
        //     $query->with('product' => function($query) use ($id){
        //             $query->where('product.id',$id);
        //     });
        // }])->where('id','LIKE',"%$search%")->orderBy('id','desc')->paginate(10));
    }


    public function newTransaction(Request $request)
    {
        $order = Transaction::create([
            'invoice' => Uuid::uuid4(),
            'user_id' => Auth::user()->id,
            'total' => 0,
            'bayar' => $request->bayar,
            'kembalian' => $request->kembalian,
            'payment_method' => $request->payment_method,
            'customer_id' => $request->customer,
        ]);
        $totalPrice = 0;
        foreach ($request->cart as $data_cart) {
            if ($data_cart['discount'] !== null) {
                $realPrice = $data_cart['realPrice'] -
                    ($data_cart['discount']['amount'] /
                        100) *
                    $data_cart['realPrice'] +
                    0.1 *
                    ($data_cart['realPrice'] -
                        ($data_cart['discount']['amount'] /
                            100) *
                        $data_cart['realPrice']);
                $ppn = (0.1 * ($data_cart['realPrice'] -
                    ($data_cart['discount']['amount'] /
                        100) *
                    $data_cart['realPrice']));
            } else {
                $realPrice = $data_cart['realPrice'] +
                    0.1 *
                    $data_cart['realPrice'];
                $ppn = (0.1 * $data_cart['realPrice']);
            }
            $subtotal = $realPrice * $data_cart['quantity'];
            TransactionDetail::create([
                'order_id' => $order->id,
                'product_id' => $data_cart['id'],
                'quantity' => $data_cart['quantity'],
                'price' => $realPrice,
                'ppn' => $ppn,
                'subtotal' => $subtotal
            ]);
            $totalPrice += $subtotal;
            $product = Product::find($data_cart['id']);
            $product->stock = $product->stock - $data_cart['quantity'];
            $product->save();
        }
        Transaction::find($order->id)->update(['total' => $totalPrice]);

        return response()->json(['status' => true, 'message' => '<b>Transaksi Sukses!</b> <br>Total Harga: <b>Rp' . number_format($totalPrice) . "</b><br>Jumlah Bayar: <b>Rp " . number_format($request->bayar) . "</b><br>Kembalian: <b>Rp " . number_format($request->kembalian) . "</b><br>Invoice: <a href='" . url("transaksi/invoice/" . $order->invoice) . "'>Klik Disini</a>"]);
    }

    public function history()
    {
        return new TransactionCollection(Transaction::with(['details.product', 'customer'])->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10));
    }

    public function allHistory()
    {
        return new TransactionCollection(Transaction::with(['details.product', 'cashier', 'customer'])->orderBy('id', 'desc')->paginate(10));
    }

    public function invoice($invoice_id)
    {
        return Transaction::with(['details.product', 'customer'])->where('invoice', $invoice_id)->orderBy('id', 'desc')->first();
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
        //
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
