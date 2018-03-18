<?php

/* Require */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

/* Models */
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Sekolah;

class BantenprovSekolahSeederSekolah extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
        $faker = Faker::create();

        foreach (range(1,10) as $index) {
            DB::table('sekolahs')->insert([
                'label' => $faker->word,
                'npsn' => $faker->unique()->randomNumber($nbDigits = NULL, $strict = false),
                //'jenis_sekolah_id' => $faker->unique()->randomNumber($nbDigits = NULL, $strict = false),
                'alamat' => $faker->streetAddress,
                //'kelurahan_id' => $faker->streetAddress,
                //'kecamatan_id' => $faker->streetAddress,
                //'kebkota_id' => $faker->streetAddress,
                'logo'          => 'logo', 
                'foto_gedung'   => 'foto gedung',
                'description'   => $faker->text($maxNbChars = 200),
                'user_id'       => $faker->unique()->randomNumber($nbDigits = NULL, $strict = false)                            
            ]); 
        }       
    }
}