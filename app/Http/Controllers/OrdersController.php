<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderDetailsSession;
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
        $ordersSession = session()->get('orders');

        if (Auth::check() and $ordersSession)
        {
            foreach ($ordersSession as $localOrder)
            {
                $order = new Order();

                $order->user_id = Auth::id();
                $order->type = $localOrder['type'];
                $order->total = $localOrder['total'];
                $order->status = "Processed";

                $order->save();

                $allSessionDetails = OrderDetailsSession::all()->where('order_id', '=', $localOrder['id']);

                foreach ($allSessionDetails as $pizza)
                {
                    $order_details = new OrderDetails();

                    $order_details->order_id = $localOrder['id'];
                    $order_details->pizza_name = $pizza->pizza_name;
                    $order_details->pizza_description = $pizza->pizza_description;
                    $order_details->pizza_size = $pizza->pizza_size;
                    $order_details->pizza_price = $pizza->pizza_price;

                    $order_details->save();
                    $pizza->delete();
                }
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
        //session()->flush();
        // Create objects
        $order = new Order();
        $order_details = new OrderDetails();
        $order_details_session = new OrderDetailsSession();

        // Main variables
        $basketSession = session()->get('basket');
        $ordersSession = session()->get('orders');
        $orderType = $request->getOrderType;

        // If user is not logged in, save the order to the local session storage
        if (!Auth::check())
        {
            if ($ordersSession == null)
            {
                $oID = 1;
            }
            else
            {
                $lastOrder = end($ordersSession);
                $oID = $lastOrder['id'] + 1;
            }

            if ($ordersSession == null)
            {
                $dID = 1;
            }
            else
            {
                $lastOrder = end($ordersSession);
                $dID = $lastOrder['id'] + 1;
            }

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

            foreach ((array) $basketSession as $pizza)
            {
                $order_details_session = new OrderDetailsSession();

                $order_details_session->order_id = $oID;
                $order_details_session->pizza_name = $pizza['name'];
                $order_details_session->pizza_description = $pizza['description'];
                $order_details_session->pizza_size = $pizza['size'];
                $order_details_session->pizza_price = $pizza['price'];

                $order_details_session->save();
            }

            session()->put('orders', $ordersSession);

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

            foreach ((array) $basketSession as $pizza)
            {
                $order_details = new OrderDetails();

                $order_details->order_id = $order->id;
                $order_details->pizza_name = $pizza['name'];
                $order_details->pizza_description = $pizza['description'];
                $order_details->pizza_size = $pizza['size'];
                $order_details->pizza_price = $pizza['price'];

                $order_details->save();
            }

            Session::forget('basket');
        }

        return redirect('orders');
    }

    public function deleteOrder(Order $order)
    {
        $order->delete();

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
