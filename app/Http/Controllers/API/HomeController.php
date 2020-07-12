<?php

namespace App\Http\Controllers\API;

use App\User;
use Carbon\Carbon;
use App\Model\Product;
use App\Model\Category;
use App\Model\Customer;
use Barryvdh\DomPDF\PDF;
use App\Model\Transaction;
use Illuminate\Http\Request;
use App\Model\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data = [];
        $thisMonth = Carbon::now()->format('Y-m');
        $lastMonth = Carbon::now()->subMonth(1)->format('Y-m');

        $data['transaksi_bulan_ini'] = Transaction::where('created_at', 'LIKE', '%' . $thisMonth . '%')->count();
        $data['transaksi_bulan_lalu'] = Transaction::where('created_at', 'LIKE', '%' . $lastMonth . '%')->count();
        $diff = $data['transaksi_bulan_ini'] - $data['transaksi_bulan_lalu'];
        $more_less = $diff > 0 ? "+" : "-";
        $diff = abs($diff);
        $data['peningkatan_transaksi'] = $more_less . (($diff / ($data['transaksi_bulan_lalu'] !== 0 ?: 1)) * 100) . "%";
        $data['average_price'] = Product::selectRaw("AVG(price+ (price * 0.1) ) as average")->first()->average;
        $data['product_sold'] = TransactionDetail::selectRaw('SUM(quantity) as quantity')->first()->quantity;
        $data['product_sold_lastmo'] = TransactionDetail::selectRaw('SUM(quantity) as quantity')->where('created_at', 'LIKE', "%$lastMonth%")->first()->quantity;
        $data['pendapatan_bulan_ini'] =  DB::table('order_details')
            ->select(DB::raw("SUM(quantity * ppn) as fee"))
            ->where('order_details.created_at', 'LIKE', '%' . $thisMonth . '%')
            ->first()->fee;
        $data['pendapatan_bulan_lalu'] =  DB::table('order_details')
            ->select(DB::raw("SUM(quantity * ppn) as fee"))
            ->where('order_details.created_at', 'LIKE', '%' . $lastMonth . '%')
            ->first()->fee;
        $diff = $data['pendapatan_bulan_ini'] - $data['pendapatan_bulan_lalu'];
        $more_less = $diff >= 0 ? "+" : "-";
        $diff = abs($diff);
        $data['peningkatan_pendapatan'] = $more_less . (($diff / ($data['pendapatan_bulan_lalu'] !== 0 ?: 1)) * 100) . "%";

        return response()->json($data);
    }

    public function report()
    {
        $data = [];
        $data['total']['transaction'] = Transaction::count();
        $data['total']['transaction_thismo'] = Transaction::whereMonth('created_at', Carbon::now()->format('m'))->count();
        $data['total']['category'] = Category::count();
        $data['total']['product'] = Product::count();
        $data['total']['product_sold'] = TransactionDetail::count();
        $data['total']['product_sold_thismo'] = TransactionDetail::whereMonth('created_at', Carbon::now()->format('m'))->count();
        $data['total']['product'] = Product::count();
        $data['total']['customer'] = Customer::count();
        $data['transaction']['chart'] = DB::table('orders')->select(DB::raw("COUNT(*) as a, DATE(created_at) as y"))->where('created_at', '>=', Carbon::now()->subDays(7)->format('Y-m-d'))->groupBy(DB::raw('DATE(created_at)'))->get();
        return response()->json($data);
    }

    public function pdf_transaction()
    {
        $transactions = Transaction::all();
        $pdf = PDF::loadView('pdf.transaction', ['transactions' => $transactions]);
        return $pdf->stream();
    }

    public function pdf_users()
    {
        $users = User::all();
        $pdf = PDF::loadView('pdf.users', ['users' => $users]);
        return $pdf->stream();
    }

    public function pdf_products()
    {
        $products = Product::all();
        $pdf = PDF::loadView('pdf.products', ['products' => $products])->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
