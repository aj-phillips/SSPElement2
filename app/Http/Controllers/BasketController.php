<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BasketController extends Controller
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
        return view('basket');
    }

    public function showBasket()
    {
        $sessionBasket = session()->get('basket');

        if ($sessionBasket)
        {
            return view('basket', ['basket'=>$sessionBasket]);
        }

        return view('basket');
    }

    public function addDealToBasket(Request $request)
    {
        $selectedDeals = session()->get('selected_deals');

        // Check if empty and add the first item
        $selectedDeals = [
            1 => [
                "id" => 1,
                "name" => $request->deal_name,
                "price" => $request->deal_price,
            ]
        ];

        session()->put('selected_deals', $selectedDeals);

        return redirect()->back()->with('success', 'Deal successfully added to basket!');
    }

    public function clearDeals()
    {
        Session::forget('selected_deals');

        return redirect('menu');
    }

    public function addToBasket(Request $request)
    {
        //session()->flush();
        // New objects
        $pizza = new Pizza();
        $basket = session()->get('basket');
        $sizeSelection = null;

        if ($basket == null)
        {
            $id = 1;
        }
        else
        {
            $lastPizza = end($basket);
            $id = $lastPizza['id'] + 1;
        }

        // Prices for pizza based on size
        $smallPrice = 0;
        $mediumPrice = 0;
        $largePrice = 0;

        // If the pizza name is create your own when add pizza is pressed
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
                case "Large":
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
                $id => [
                    "id" => $id,
                    "pizza_id" => $request->pizza_id,
                    "name" => $pizza->name,
                    "description" => $pizza->description,
                    "size" => $pizza->size,
                    "price" => $pizza->price
                ]
            ];

            session()->put('basket', $basket);
        }

        $basket[$id] = [
            "id" => $id,
            "pizza_id" => $request->pizza_id,
            "name" => $pizza->name,
            "description" => $pizza->description,
            "size" => $pizza->size,
            "price" => $pizza->price
        ];

        session()->put('basket', $basket);

        return redirect()->back()->with('success', 'Pizza successfully added to basket!');
    }

    public function removeAllFromBasket()
    {
        Session::forget('basket');
        Session::forget('selected_deals');

        return redirect('basket');
    }

    public static function getBasketCount()
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

    public static function getTotalCost()
    {
        $sessionBasket = session()->get('basket');
        $selectedDeals = session()->get('selected_deals');
        $totalCost = 0.00;

        if ($selectedDeals == null)
        {
            foreach ((array) $sessionBasket as $pizza)
            {
                $totalCost += $pizza['price'];
            }
        }
        else
        {
            switch ($selectedDeals[1]['name'])
            {
                case "Buy One Get One Free":
                    if ($sessionBasket[1]['size'] == "Medium" and $sessionBasket[2]['size'] == "Medium" or $sessionBasket[1]['size'] == "Large" and $sessionBasket[2]['size'] == "Large")
                    {
                        $totalCost = max($sessionBasket[1]['price'], $sessionBasket[2]['price']);
                    }
                    break;
                case "Three For Two":
                    $pizzaPrices = array();
                    if ($sessionBasket[1]['size'] == "Medium" and $sessionBasket[2]['size'] == "Medium" and $sessionBasket[3]['size'] == "Medium")
                    {
                        $pizzaPrices[] = [$sessionBasket[1]['price'], $sessionBasket[2]['price'], $sessionBasket[3]['price']];
                        rsort($pizzaPrices, SORT_NUMERIC);

                        $totalCost = $pizzaPrices[0][1] + $pizzaPrices[0][2];
                    }
                    break;
                case "Family Feast":
                    if (count($sessionBasket) == 4)
                    {
                        if ($sessionBasket[1]['size'] == "Medium" and $sessionBasket[2]['size'] == "Medium" and $sessionBasket[3]['size'] == "Medium" and $sessionBasket[4]['size'] == "Medium")
                        {
                            if ($sessionBasket[1]['name'] != "Create Your Own" or $sessionBasket[2] != "Create Your Own" and $sessionBasket[3]['name'] != "Create Your Own" or $sessionBasket[4] != "Create Your Own")
                            {
                                $totalCost = 30.00;
                            }
                        }
                        else
                        {
                            foreach ((array) $sessionBasket as $pizza)
                            {
                                $totalCost += $pizza['price'];
                            }
                        }
                    }
                    else
                    {
                        foreach ((array) $sessionBasket as $pizza)
                        {
                            $totalCost += $pizza['price'];
                        }
                    }
                    break;
                case "Two Large":
                    if (count($sessionBasket) == 2)
                    {
                        if ($sessionBasket[1]['size'] == "Large" and $sessionBasket[2]['size'] == "Large")
                        {
                            if ($sessionBasket[1]['name'] != "Create Your Own" or $sessionBasket[2] != "Create Your Own")
                            {
                                $totalCost = 25.00;
                            }
                        }
                        else
                        {
                            foreach ((array) $sessionBasket as $pizza)
                            {
                                $totalCost += $pizza['price'];
                            }
                        }
                    }
                    else
                    {
                        foreach ((array) $sessionBasket as $pizza)
                        {
                            $totalCost += $pizza['price'];
                        }
                    }
                    break;
                case "Two Medium":
                    if (count($sessionBasket) == 2)
                    {
                        if ($sessionBasket[1]['size'] == "Medium" and $sessionBasket[2]['size'] == "Medium")
                        {
                            if ($sessionBasket[1]['name'] != "Create Your Own" or $sessionBasket[2] != "Create Your Own")
                            {
                                $totalCost = 18.00;
                            }
                        }
                        else
                        {
                            foreach ((array) $sessionBasket as $pizza)
                            {
                                $totalCost += $pizza['price'];
                            }
                        }
                    }
                    else
                    {
                        foreach ((array) $sessionBasket as $pizza)
                        {
                            $totalCost += $pizza['price'];
                        }
                    }
                    break;
                case "Two Small":
                    if (count($sessionBasket) == 2)
                    {
                        if ($sessionBasket[1]['size'] == "Small" and $sessionBasket[2]['size'] == "Small")
                        {
                            if ($sessionBasket[1]['name'] != "Create Your Own" or $sessionBasket[2] != "Create Your Own")
                            {
                                $totalCost = 12.00;
                            }
                        }
                        else
                        {
                            foreach ((array) $sessionBasket as $pizza)
                            {
                                $totalCost += $pizza['price'];
                            }
                        }
                    }
                    else
                    {
                        foreach ((array) $sessionBasket as $pizza)
                        {
                            $totalCost += $pizza['price'];
                        }
                    }
                    break;
            }
        }

        return $totalCost;
    }
}
