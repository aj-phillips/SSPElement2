<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewOrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    }

    public function viewOrder($id)
    {
        $pizzas = OrderDetails::where('order_id', $id)->get();
        $pizza1 = $pizzas->first();

//        if ($pizza1->user_id != Auth::id())
//        {
//            return redirect('orders');
//        }

        return view('vieworder', compact('pizzas'))->with('order_id', $id);
    }
}
