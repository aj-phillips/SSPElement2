<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $toppings = ["Cheese", "Tomato sauce", "Pepperoni", "Ham", "Chicken", "Minced beef", "Onions", "Green peppers", "Mushrooms", "Sweetcorn", "Jalapeno peppers", "Pineapple", "Sausage", "Bacon"];
        return view('menu')->with('t', $toppings);
    }
}
