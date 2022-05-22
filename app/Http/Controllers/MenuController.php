<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;
use App\Models\Basket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
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
        //Session()->flush();
        $pizzaData = Pizza::all();
        $toppings = ["Cheese", "Tomato sauce", "Pepperoni", "Ham", "Chicken", "Minced beef", "Onions", "Green peppers",
            "Mushrooms", "Sweetcorn", "Jalapeno peppers", "Pineapple", "Sausage", "Bacon"];
        return view('menu', ['pizzas'=>$pizzaData])->with('t', $toppings);
    }

    public static function getSelectedDeal()
    {
        $selectedDeals = session()->get('selected_deals');

        if ($selectedDeals == null)
        {
            return "";
        }

        return $selectedDeals[1]['name'];
    }


}
