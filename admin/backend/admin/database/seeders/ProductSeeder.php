<?php

namespace Database\Seeders;

use App\Models\Product;
use DB;
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
        $products = DB::connection('old_mysql')->table('products')->get();
        foreach ($products as $product){
            Product::create([
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'image' => $product->image,
                'price' => $product->price,
                'stock' => $product->stock,
                'status' => $product->status,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ]);
        }
    }
}
