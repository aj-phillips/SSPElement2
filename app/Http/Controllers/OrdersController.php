<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrdersController extends Controller
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
        $order = new Order();
        $order_details = new OrderDetails();

        $ordersSession = session()->get('orders');
        $orderDetailsSession = session()->get('order_details');

        if (!Order::exists())
        {
            DB::update("UPDATE SQLITE_SEQUENCE SET SEQ=0 WHERE NAME='orders';");
        }

        if (Auth::check() and $ordersSession)
        {
            foreach ($ordersSession as $localOrder)
            {
                $order->user_id = Auth::id();
                $order->type = $localOrder['type'];
                $order->total = $localOrder['total'];
                $order->status = "Processed";

                $order->save();
            }

            session()->forget('orders');

            $ordersInDB = Order::where('user_id', '=', Auth::id())->get();
            return view('orders', ['orders'=>$ordersInDB]);
        }
        elseif (Auth::check())
        {
            $ordersInDB = Order::where('user_id', '=', Auth::id())->get();
            return view('orders', ['orders'=>$ordersInDB]);
        }

        return view('orders');
    }

    public function createOrder(Request $request)
    {
        // Create objects
        $order = new Order();
        $order_details = new OrderDetails();

        // Main variables
        $basketSession = session()->get('basket');
        $ordersSession = session()->get('orders');
        $orderDetailsSession = session()->get('order_details');
        $orderType = $request->getOrderType;
        $sessionId = session()->getId();

        if ($ordersSession == null)
        {
            $oID = 1;
        }
        else
        {
            $lastOrder = end($ordersSession);
            $oID = $lastOrder['id'] + 1;
        }

        if ($orderDetailsSession == null)
        {
            $dID = 1;
        }
        else
        {
            $lastDetails = end($orderDetailsSession);
            $dID = $lastDetails['id'] + 1;
        }

        if (!Order::exists())
        {
            DB::update("UPDATE SQLITE_SEQUENCE SET SEQ=0 WHERE NAME='orders';");
        }

        // If user is not logged in, save the order to the local session storage
        if (!Auth::check())
        {
            // Check if empty and add the first item
            if (!$ordersSession)
            {
                $ordersSession = [
                    $oID => [
                        "id" => $oID,
                        "type" => $orderType,
                        "total" => MenuController::getTotalCost(),
                        "status" => "Created"
                    ]
                ];
            }
            else
            {
                $ordersSession[$oID] = [
                    "id" => $oID,
                    "type" => $orderType,
                    "total" => MenuController::getTotalCost(),
                    "status" => "Created"
                ];
            }

            foreach ($basketSession as $pizza)
            {
                $orderDetailsSession = [
                    $dID => [
                        "details_id" => $dID,
                        "order_id" => $oID,
                        "pizza_id" => $pizza->id,
                        "pizza_name" => $pizza->name,
                        "pizza_size" => $pizza->size,
                        "pizza_price" => $pizza->price
                    ]
                ];
            }

            session()->put('orders', $ordersSession);
            session()->put('order_details', $orderDetailsSession);

            Session::forget('basket');

            return redirect('orders')->with('success', 'Pizza successfully added to basket!');
        }
        else
        {
            $order->user_id = Auth::id();
            $order->type = $orderType;
            $order->total = MenuController::getTotalCost();
            $order->status = "Processed";

            $order->save();

            foreach ($basketSession as $pizza)
            {
                $order_details->order_id = $order->id;
                $order_details->pizza_name = $pizza['name'];
                $order_details->pizza_size = $pizza['size'];
                $order_details->pizza_price = $pizza['price'];

                $order_details->save();
            }

            Session::forget('basket');
        }

        return redirect('orders');
    }

    public function deleteOrder($id)
    {
        Order::where('id', $id)->delete();

        return redirect('orders');
    }

    public function deleteOrderFromSession($id)
    {
        $orderSession = session()->get('orders');
        if (isset($orderSession[$id]))
        {
            unset($orderSession[$id]);
            session()->put('orders', $orderSession);
        }

        session()->flash('success', 'Order successfully removed');

        return redirect('orders');
    }
}
