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
        $pizzaData = Pizza::all();
        $toppings = ["Cheese", "Tomato sauce", "Pepperoni", "Ham", "Chicken", "Minced beef", "Onions", "Green peppers", "Mushrooms", "Sweetcorn", "Jalapeno peppers", "Pineapple", "Sausage", "Bacon"];
        return view('menu', ['pizzas'=>$pizzaData])->with('t', $toppings);
    }

    public function addToBasket(Request $request)
    {
        // New objects
        $basket = new Basket();
        $pizza = new Pizza();

        // Prices for pizza based on size
        $smallPrice = 0;
        $mediumPrice = 0;
        $largePrice = 0;

        // Data from request
        $nameZeroString = substr($request->pizza_name, 0, 1);
        $sizeSelection = $request->{$nameZeroString."PizzaSize"};

        // Set pizza object variable
        $pizza->name = $request->pizza_name;
        $pizza->description = $request->description;
        $pizza->size = $sizeSelection;

        switch ($request->pizza_name)
        {
            case "Create Your Own":
            case "Original":
                $smallPrice = 8.00;
                $mediumPrice = 9.00;
                $largePrice = 11.00;
                break;
            case "Gimme The Meat":
                $smallPrice = 11.00;
                $mediumPrice = 14.50;
                $largePrice = 16.50;
                break;
            case "Veggie Delight":
                $smallPrice = 10.00;
                $mediumPrice = 13.00;
                $largePrice = 15.00;
                break;
            case "Make Mine Hot":
                $smallPrice = 11.00;
                $mediumPrice = 13.00;
                $largePrice = 15.00;
                break;
        }

        switch ($sizeSelection)
        {
            case "small":
                $pizza->price = $smallPrice;
                break;
            case "medium":
                $pizza->price = $mediumPrice;
                break;
            case "large":
                $pizza->price = $largePrice;
                break;
        }

        // Set basket object properties
        $basket->pizza_id = $request->pizza_id;
        $basket->pizza_name = $request->pizza_name;
        $basket->pizza_size = $sizeSelection;
        $basket->pizza_price = $pizza->price;
        $basket->session_id = session()->getId();

        $basket->save();
        return redirect('/');
    }

    public static function basketItem()
    {
        $sessionID = session()->getId();
        return Basket::where('session_id', $sessionID)->count();
    }
}
