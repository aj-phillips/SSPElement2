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
                                        <h5 class="card-title text-center">Buy One Get One Free</h5>
                                        <p class="card-text text-center">Buy two medium or large pizzas and get one free!</p>
                                        <a href="#" class="btn btn-primary w-100">Select Deal</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Three For Two</h5>
                                        <p class="card-text text-center">Buy three medium pizzas for the price of two!</p>
                                        <a href="#" class="btn btn-primary w-100">Select Deal</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Family Feast</h5>
                                        <p class="card-text text-center">Buy any four medium pizzas for the family to enjoy!</p>
                                        <p class="card-text text-center">Price: £30</p>
                                        <a href="#" class="btn btn-primary w-100">Select Deal</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Two Large</h5>
                                        <p class="card-text text-center">Buy any two large pizzas and have a night indoors!</p>
                                        <p class="card-text text-center">Price: £25</p>
                                        <a href="#" class="btn btn-primary w-100">Select Deal</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Two Medium</h5>
                                        <p class="card-text text-center">Buy any two medium pizzas for the missus to enjoy!</p>
                                        <p class="card-text text-center">Price: £18</p>
                                        <a href="#" class="btn btn-primary w-100">Select Deal</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Two Small</h5>
                                        <p class="card-text text-center">Buy any two small pizzas for the kids to enjoy!</p>
                                        <p class="card-text text-center">Price: £12</p>
                                        <a href="#" class="btn btn-primary w-100">Select Deal</a>
                                    </div>
                                </div>
                            </div>
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
                                        <label for="cyoPizzaSize">Pizza Size:</label>
                                        <select id="cyoPizzaSize" class="form-select" aria-label="Create your own pizza sizes">
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
                                        <form action="/add_to_basket" method="POST">
                                            @csrf
                                            <input type="hidden" name="pizza_id" value="5">
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
