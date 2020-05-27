<?php

use App\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = new  Product;
        $product->name = 'Camisa Nike';
        $product->slug = 'camisa-nike';
        $product->description = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab, vero odio pariatur quaerat molestiae modi. Nisi, placeat error! Facere sequi aliquam veniam nemo incidunt minus alias sapiente pariatur. Laboriosam, quod.';
        $product->created_by = User::first()->id;
        $product->save();

        $product->variations()->create([
            'type' => 1,
            'name' => 'Azul',
            'initial_inventary' => 100,
            'actual_inventary' => 100,
            'price' => 44.50,
            'created_by' => User::first()->id,
        ]);
        
        $product->variations()->create([
            'type' => 1,
            'name' => 'Preto',
            'initial_inventary' => 150,
            'actual_inventary' => 150,
            'price' => 45.90,
            'created_by' => User::first()->id,
        ]);
        
        $product = new  Product;
        $product->name = 'Camisa Adidas';
        $product->slug = 'camisa-adidas';
        $product->description = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab, vero odio pariatur quaerat molestiae modi. Nisi, placeat error! Facere sequi aliquam veniam nemo incidunt minus alias sapiente pariatur. Laboriosam, quod.';
        $product->created_by = User::first()->id;
        $product->save();

        $product->variations()->create([
            'type' => 1,
            'name' => 'Unico',
            'initial_inventary' => 100,
            'actual_inventary' => 100,
            'price' => 44.50,
            'created_by' => User::first()->id,
        ]);
        
    }
}
