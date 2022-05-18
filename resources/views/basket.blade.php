@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Basket') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive pt-2">
                        <table class="table table-striped table-sm text-center">
                            <thead>
                            <tr>
                                <th scope="col">Pizza Name</th>
                                <th scope="col">Pizza Size</th>
                                <th scope="col">Pizza Price</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($basket as $pizza)
                                <tr>
                                    <td>{{ $pizza->pizza_name }}</td>
                                    <td>{{ $pizza->pizza_size }}</td>
                                    <td>£{{ number_format($pizza->pizza_price, 2) }}</td>
                                    <td><a href="/basket/delete/{{ $pizza->id }}" class="btn btn-danger">Remove</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <?php
                        use App\Http\Controllers\MenuController;
                        $totalCost = MenuController::getTotalCost();
                    ?>

                    <h3>Total Cost: £{{ number_format($totalCost, 2) }}</h3>

                    <div class="mt-3">
                        <label for="getOrderTypes">Collection/Delivery</label>
                        <select id="getOrderTypes" class="form-select w-25" aria-label="Order retrieval type">
                            <option selected>...</option>
                            <option value="collection">Collection</option>
                            <option value="delivery">Delivery</option>
                        </select>
                    </div>

                    <div class="text-center mb-3 mt-3">
                        <form action="">
                            <Button class="btn btn-primary w-75">Confirm Order</Button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
