<?php

namespace Database\Seeders;

use App\Models\Links;
use DB;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = DB::connection('old_mysql')->table('links')->get();
        foreach ($links as $link){
            Links::create([
                'id' => $link->id,
                'link' => $link->link,
                'user_id' => $link->user_id,
                'created_at' => $link->created_at,
                'updated_at' => $link->updated_at,
            ]);
        }
    }
}
