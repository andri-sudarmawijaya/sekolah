<?php

use Illuminate\Database\Seeder;

class BantenprovSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(BantenprovSekolahSeederSekolah::class);
    }
}
