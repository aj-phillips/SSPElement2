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
        $toppings = ["Cheese", "Tomato sauce", "Pepperoni", "Ham", "Chicken", "Minced beef", "Onions", "Green peppers",
            "Mushrooms", "Sweetcorn", "Jalapeno peppers", "Pineapple", "Sausage", "Bacon"];
        return view('menu', ['pizzas'=>$pizzaData])->with('t', $toppings);
    }

    public function addToBasket(Request $request)
    {
        //session()->flush();
        // New objects
        $pizza = new Pizza();
        $basket = session()->get('basket');
        $sizeSelection = null;

        // Prices for pizza based on size
        $smallPrice = 0;
        $mediumPrice = 0;
        $largePrice = 0;

        if ($request->pizza_name == "Create Your Own")
        {
            // Get the pizza size
            $sizeSelection = $request->cPizzaSize;

            // Initialise empty array for storage of selected toppings
            $selectedToppings = array();

            // Iterate through all selected toppings and add them to the array
            foreach ((array) $request->cToppings as $topping)
            {
                array_push($selectedToppings, $topping);
            }

            // Make a comma separated string for the array values
            $toppingString = implode(', ', $selectedToppings);

            // Set pizza object values
            $pizza->name = $request->pizza_name;
            $pizza->description = ucfirst(strtolower($toppingString));
            $pizza->size = $sizeSelection;

            // Do the price
            switch ($pizza->size)
            {
                case "Small":
                    $smallPrice = 8.00;
                    $amountOfToppings = count($selectedToppings);
                    $pizzaCost = (0.90 * $amountOfToppings) + $smallPrice;

                    $pizza->price = $pizzaCost;
                    break;
                case "Medium":
                    $mediumPrice = 9.00;
                    $amountOfToppings = count($selectedToppings);
                    $pizzaCost = (1.00 * $amountOfToppings + $mediumPrice);

                    $pizza->price = $pizzaCost;
                    break;
                case "Larger":
                    $largePrice = 11.00;
                    $amountOfToppings = count($selectedToppings);
                    $pizzaCost = (1.15 * $amountOfToppings + $largePrice);

                    $pizza->price = $pizzaCost;
                    break;
            }
        }
        else
        {
            // Data from request
            $nameZeroString = substr($request->pizza_name, 0, 1);
            $sizeSelection = $request->{$nameZeroString."PizzaSize"};

            // Set pizza object variable
            $pizza->name = $request->pizza_name;
            $pizza->description = $request->pizza_description;
            $pizza->size = $sizeSelection;

            // Sets price variables to the correct prices based on size
            switch ($pizza->name)
            {
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

            // Identifies what size was selected and sets the Pizza object price to the correct one
            switch ($sizeSelection)
            {
                case "Small":
                    $pizza->price = $smallPrice;
                    break;
                case "Medium":
                    $pizza->price = $mediumPrice;
                    break;
                case "Large":
                    $pizza->price = $largePrice;
                    break;
            }
        }

        // Check if empty and add the first item
        if (!$basket)
        {
            $basket = [
                $request->pizza_id => [
                    "pizza_id" => $request->pizza_id,
                    "name" => $pizza->name,
                    "description" => $pizza->description,
                    "size" => $pizza->size,
                    "price" => $pizza->price
                ]
            ];

            session()->put('basket', $basket);
        }

        $basket[$request->pizza_id] = [
            "pizza_id" => $request->pizza_id,
            "name" => $pizza->name,
            "description" => $pizza->description,
            "size" => $pizza->size,
            "price" => $pizza->price
        ];

        session()->put('basket', $basket);

        return redirect()->back()->with('success', 'Pizza successfully added to basket!');
    }

    public static function basketItem()
    {
        $sessionBasket = session()->get('basket');

        if (!$sessionBasket == null)
        {
            return count($sessionBasket);
        }
        else
        {
            return 0;
        }
    }

    public function basketList()
    {
        $sessionBasket = session()->get('basket');

        return view('basket', ['basket'=>$sessionBasket]);
    }

    public static function getTotalCost()
    {
        $sessionBasket = session()->get('basket');
        $totalCost = 0.00;

        foreach ($sessionBasket as $pizza)
        {
            $totalCost += $pizza['price'];
        }

        return $totalCost;
    }

    public function removeFromBasket($id)
    {
        $basket = session()->get('basket');
        if (isset($basket[$id]))
        {
            unset($basket[$id]);
            session()->put('basket', $basket);
        }

        session()->flash('success', 'Pizza successfully removed');

        return redirect('basket');
    }
}
