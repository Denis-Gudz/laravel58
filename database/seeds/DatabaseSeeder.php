<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ShopCategoriesTableSeeder::class);
        factory(\App\Models\ShopItem::class, 100)->create();
    }
}
