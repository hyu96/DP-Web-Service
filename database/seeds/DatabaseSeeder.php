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
        $this->call(DisabilitiesTableSeeder::class);
        $this->call(NeedsTableSeeder::class);
        $this->call(DistrictsTableSeeder::class);
        $this->call(SubdistrictTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
