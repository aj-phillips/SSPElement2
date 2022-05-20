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

                        <!-- Pizza Deals section -->
                        <hr>
                        <p class="text-start text-center" style="font-size: 25px">Pizza Deals</p>
                        <hr>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="/add_deal_to_basket" method="post">
                                            @csrf
                                            <h5 class="card-title text-center">Buy One Get One Free</h5>
                                            <p class="card-text text-center">Buy two medium or large pizzas and get one free!</p>
                                            <input type="hidden" name="deal_name" id="deal_name" value="Buy One Get One Free">
                                            <input type="hidden" name="deal_price" id="deal_price" value="0">
                                                @if(\App\Http\Controllers\MenuController::getSelectedDeal() == "Buy One Get One Free")
                                                    <Button class="btn btn-primary w-100" disabled>Deal Selected</Button>
                                                @else
                                                    <Button class="btn btn-primary w-100">Select Deal</Button>
                                                @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="/add_deal_to_basket" method="post">
                                            @csrf
                                            <h5 class="card-title text-center">Three For Two</h5>
                                            <p class="card-text text-center">Buy three medium pizzas for the price of two!</p>
                                            <input type="hidden" name="deal_name" id="deal_name" value="Three For Two">
                                            <input type="hidden" name="deal_price" id="deal_price" value="0">
                                            @if(\App\Http\Controllers\MenuController::getSelectedDeal() == "Three For Two")
                                                <Button class="btn btn-primary w-100" disabled>Deal Selected</Button>
                                            @else
                                                <Button class="btn btn-primary w-100">Select Deal</Button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="/add_deal_to_basket" method="post">
                                            @csrf
                                            <h5 class="card-title text-center">Family Feast</h5>
                                            <p class="card-text text-center">Buy any four medium pizzas for the family to enjoy!</p>
                                            <p class="card-text text-center">Price: £30</p>
                                            <input type="hidden" name="deal_name" id="deal_name" value="Family Feast">
                                            <input type="hidden" name="deal_price" id="deal_price" value="30.00">
                                            @if(\App\Http\Controllers\MenuController::getSelectedDeal() == "Family Feast")
                                                <Button class="btn btn-primary w-100" disabled>Deal Selected</Button>
                                            @else
                                                <Button class="btn btn-primary w-100">Select Deal</Button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="/add_deal_to_basket" method="post">
                                            @csrf
                                            <h5 class="card-title text-center">Two Large</h5>
                                            <p class="card-text text-center">Buy any two large pizzas and have a night indoors!</p>
                                            <p class="card-text text-center">Price: £25</p>
                                            <input type="hidden" name="deal_name" id="deal_name" value="Two Large">
                                            <input type="hidden" name="deal_price" id="deal_price" value="25.00">
                                            @if(\App\Http\Controllers\MenuController::getSelectedDeal() == "Two Large")
                                                <Button class="btn btn-primary w-100" disabled>Deal Selected</Button>
                                            @else
                                                <Button class="btn btn-primary w-100">Select Deal</Button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="/add_deal_to_basket" method="post">
                                            @csrf
                                            <h5 class="card-title text-center">Two Medium</h5>
                                            <p class="card-text text-center">Buy any two medium pizzas for the missus to enjoy!</p>
                                            <p class="card-text text-center">Price: £18</p>
                                            <input type="hidden" name="deal_name" id="deal_name" value="Two Medium">
                                            <input type="hidden" name="deal_price" id="deal_price" value="18.00">
                                            @if(\App\Http\Controllers\MenuController::getSelectedDeal() == "Two Medium")
                                                <Button class="btn btn-primary w-100" disabled>Deal Selected</Button>
                                            @else
                                                <Button class="btn btn-primary w-100">Select Deal</Button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="/add_deal_to_basket" method="post">
                                            @csrf
                                            <h5 class="card-title text-center">Two Small</h5>
                                            <p class="card-text text-center">Buy any two small pizzas for the kids to enjoy!</p>
                                            <p class="card-text text-center">Price: £12</p>
                                            <input type="hidden" name="deal_name" id="deal_name" value="Two Small">
                                            <input type="hidden" name="deal_price" id="deal_price" value="12.00">
                                            @if(\App\Http\Controllers\MenuController::getSelectedDeal() == "Two Small")
                                                <Button class="btn btn-primary w-100" disabled>Deal Selected</Button>
                                            @else
                                                <Button class="btn btn-primary w-100">Select Deal</Button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <form action="/cleardeals" method="post">
                                @csrf
                                <Button class="btn btn-danger mt-3 w-100">Clear Deals</Button>
                            </form>
                        </div>

                        <!-- Pizza section -->
                        <hr>
                        <p class="text-start text-center" style="font-size: 25px">Choose Your Pizza(s)</p>
                        <hr>

                        <div class="row">
                            <!-- Original -->
                            @foreach($pizzas as $pizza)
                                @if($pizza->name == "Create Your Own")
                                    @break
                                @endif
                                <div class="col-md-6 mt-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{ $pizza->name }}</h5>
                                            <label class="mt-2">Toppings:</label>
                                            <p class="card-text">{{ $pizza->description }}</p>
                                            <form action="/add_to_basket" method="post">
                                                @csrf
                                                <label for="{{ substr($pizza->name, 0, 1) }}PizzaSize">Pizza Size:</label>
                                                <select name="{{ substr($pizza->name, 0, 1) }}PizzaSize" id="{{ substr($pizza->name, 0, 1) }}PizzaSize" class="form-select" aria-label="{{ $pizza->name }} pizza sizes">
                                                    <option>Pizza size</option>
                                                    <option value="Small" selected>Small</option>
                                                    <option value="Medium">Medium</option>
                                                    <option value="Large">Large</option>
                                                </select>
                                                <input type="hidden" name="pizza_id" value="{{ $pizza->id }}">
                                                <input type="hidden" name="pizza_name" value="{{ $pizza->name }}">
                                                <input type="hidden" name="pizza_description" value="{{ $pizza->description }}">
                                                <input type="hidden" name="pizza_price" value="{{ $pizza->price }}">
                                                <Button class="btn btn-primary mt-3 w-100">Add Pizza</Button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- Create Your Own -->
                            <div class="col mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Create Your Own</h5>
                                        <form action="/add_to_basket" method="post">
                                            @csrf
                                            <label class="mt-2">Toppings:</label>
                                            @foreach($t as $topping)
                                                <div class="form-check">
                                                    <input name="cToppings[]" class="form-check-input" type="checkbox" value="{{ $topping }}">
                                                    <label class="form-check-label" for="cToppings[]">
                                                        {{ $topping }}
                                                    </label>
                                                </div>
                                            @endforeach
                                            <label for="cPizzaSize" class="mt-3">Pizza Size:</label>
                                            <select name="cPizzaSize" id="cPizzaSize" class="form-select" aria-label="Create your own pizza sizes">
                                                <option>Pizza size</option>
                                                <option value="Small" selected>Small</option>
                                                <option value="Medium">Medium</option>
                                                <option value="Large">Large</option>
                                            </select>
                                            <input type="hidden" name="pizza_id" value="5">
                                            <input type="hidden" name="pizza_name" value="Create Your Own">
                                            <Button class="btn btn-primary mt-3 w-100">Add Pizza</Button>
                                        </form>
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
