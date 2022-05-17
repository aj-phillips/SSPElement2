<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pizzas')->insert([
            [
                'name'=>'Original',
                'description'=>'Cheese, tomato sauce',
                'size'=>'',
                'toppings'=>'',
                'price'=>8.00,
            ],
            [
                'name'=>'Gimme The Meat',
                'description'=>'Cheese, tomato sauce, pepperoni, ham, chicken, minced beef, sausage, bacon',
                'size'=>'',
                'toppings'=>'',
                'price'=>11.00,

            ],
            [
                'name'=>'Veggie Delight',
                'description'=>'Cheese, tomato sauce, onions, green peppers, mushrooms, sweetcorn',
                'size'=>'',
                'toppings'=>'',
                'price'=>10.00,
            ],
            [
                'name'=>'Make Mine Hot',
                'description'=>'Cheese, tomato sauce, chicken, onions, green peppers, jalapeno peppers',
                'size'=>'',
                'toppings'=>'',
                'price'=>11.00,
            ],
            [
                'name'=>'Create Your Own',
                'description'=>'Create your own pizza with your choice of toppings!',
                'size'=>'',
                'toppings'=>'',
                'price'=>8.00,
            ],
        ]);
    }
}
