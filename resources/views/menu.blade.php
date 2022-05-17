@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Menu') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-center">Welcome to the menu page!</p>
                    <p class="text-center">Please select from one of the deals or any of the pizzas below!</p>

                    <hr>
                    <p class="text-start text-center" style="font-size: 25px">Pizza Deals</p>
                    <hr>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Buy One Get One Free</h5>
                                    <p class="card-text text-center">Buy two medium or large pizzas and get one free!</p>
                                    <a href="#" class="btn btn-primary">Select Deal</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Three For Two</h5>
                                    <p class="card-text text-center">Buy three medium pizzas for the price of two!</p>
                                    <a href="#" class="btn btn-primary">Select Deal</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Family Feast</h5>
                                    <p class="card-text text-center">Buy any four medium pizzas for the family to enjoy!</p>
                                    <a href="#" class="btn btn-primary">Select Deal</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Two Large</h5>
                                    <p class="card-text text-center">Buy any two large pizzas and have a night indoors!</p>
                                    <a href="#" class="btn btn-primary">Select Deal</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Two Medium</h5>
                                    <p class="card-text text-center">Buy any two medium pizzas for the missus to enjoy!</p>
                                    <a href="#" class="btn btn-primary">Select Deal</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Two Small</h5>
                                    <p class="card-text text-center">Buy any two small pizzas for the kids to enjoy!</p>
                                    <a href="#" class="btn btn-primary">Select Deal</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <p class="text-start text-center" style="font-size: 25px">Choose Your Pizza(s)</p>
                    <hr>

                    <div class="row">
                        <!-- Original -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Original</h5>
                                    <label for="originalPizzaSize">Pizza Size:</label>
                                    <select id="originalPizzaSize" class="form-select" aria-label="Original pizza sizes">
                                        <option>Pizza size</option>
                                        <option value="small" selected>Small</option>
                                        <option value="medium">Medium</option>
                                        <option value="large">Large</option>
                                    </select>
                                    <label class="mt-3">Toppings:</label>
                                    <p class="card-text">Cheese and Tomato Sauce</p>
                                    <a href="#" class="btn btn-primary mt-1">Add Pizza</a>
                                </div>
                            </div>
                        </div>
                        <!-- Gimme The Meat -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Gimme The Meat</h5>
                                    <label for="originalPizzaSize">Pizza Size:</label>
                                    <select id="meatPizzaSize" class="form-select" aria-label="Gimme The Meat pizza sizes">
                                        <option>Pizza size</option>
                                        <option value="small" selected>Small</option>
                                        <option value="medium">Medium</option>
                                        <option value="large">Large</option>
                                    </select>
                                    <label class="mt-3">Toppings:</label>
                                    <p class="card-text" style="font-size: 13px">Pepperoni, Ham, Chicken, Minced Beef, Sausage and Bacon</p>
                                    <a href="#" class="btn btn-primary mt-1">Add Pizza</a>
                                </div>
                            </div>
                        </div>
                        <!-- Veggie Delight -->
                        <div class="col-md-6 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Veggie Delight</h5>
                                    <label for="veggiePizzaSize">Pizza Size:</label>
                                    <select id="veggiePizzaSize" class="form-select" aria-label="Veggie Delight pizza sizes">
                                        <option>Pizza size</option>
                                        <option value="small" selected>Small</option>
                                        <option value="medium">Medium</option>
                                        <option value="large">Large</option>
                                    </select>
                                    <label class="mt-3">Toppings:</label>
                                    <p class="card-text" style="font-size: 13px">Onions, Green Peppers, Mushrooms and Sweetcorn</p>
                                    <a href="#" class="btn btn-primary mt-1">Add Pizza</a>
                                </div>
                            </div>
                        </div>
                        <!-- Make Mine Hot -->
                        <div class="col-md-6 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Make Mine Hot</h5>
                                    <label for="mmhPizzaSize">Pizza Size:</label>
                                    <select id="mmhPizzaSize" class="form-select" aria-label="Make Mine Hot pizza sizes">
                                        <option>Pizza size</option>
                                        <option value="small" selected>Small</option>
                                        <option value="medium">Medium</option>
                                        <option value="large">Large</option>
                                    </select>
                                    <label class="mt-3">Toppings:</label>
                                    <p class="card-text">Chicken, Onions, Green Peppers and Jalapeno Peppers</p>
                                    <a href="#" class="btn btn-primary mt-1">Add Pizza</a>
                                </div>
                            </div>
                        </div>
                        <!-- Create Your Own -->
                        <div class="col mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Create Your Own</h5>
                                    <label for="mmhPizzaSize">Pizza Size:</label>
                                    <select id="mmhPizzaSize" class="form-select" aria-label="Make Mine Hot pizza sizes">
                                        <option>Pizza size</option>
                                        <option value="small" selected>Small</option>
                                        <option value="medium">Medium</option>
                                        <option value="large">Large</option>
                                    </select>
                                    <label class="mt-3">Toppings:</label>
                                    @foreach($t as $topping)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="cyo{{$topping}}">
                                            <label class="form-check-label" for="cyo{{$topping}}">
                                                {{ $topping }}
                                            </label>
                                        </div>
                                    @endforeach
                                    <a href="#" class="btn btn-primary mt-3">Add Pizza</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
