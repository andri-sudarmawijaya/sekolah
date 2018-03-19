<?php

/* Require */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/* Models */
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\JenisSekolah;

class BantenprovJenisSekolahSeederJenisSekolah extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
        Model::unguard();

        $jenis_sekolahs = (object) [
            (object) [
                'jenis_sekolah' => 'SMA',
                'user_id' => '1' 
            ],
            (object) [
                'jenis_sekolah' => 'SMK',
                'user_id' => '2' 
            ]
        ];

        foreach ($jenis_sekolahs as $jenis_sekolah) {
            $model = JenisSekolah::updateOrCreate(
                [
                    'jenis_sekolah' => $jenis_sekolah->jenis_sekolah,
                    'user_id' => $jenis_sekolah->user_id,
                ]
            );
            $model->save();
        }
	}
}
