<?php

namespace Database\Seeders;

use App\Models\LinkProducts;
use DB;
use Illuminate\Database\Seeder;

class LinkProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $linkProducts = DB::connection('old_mysql')->table('link_products')->get();
        foreach ($linkProducts as $linkProduct){
            LinkProducts::create([
                'id' => $linkProduct->id,
                'links_id' => $linkProduct->links_id,
                'product_id' => $linkProduct->product_id,
                'created_at' => $linkProduct->created_at,
                'updated_at' => $linkProduct->updated_at,
            ]);
        }
    }
}
