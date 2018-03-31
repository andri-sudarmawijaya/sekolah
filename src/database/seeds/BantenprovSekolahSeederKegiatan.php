<?php

/* Require */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
        Model::unguard();

        $sekolahs = (object) [
            (object) [
                'label'     => 'label1',
                'npsn'      => '1',
                'jenis_sekolah_id'   => '1',
                'alamat' => 'indonesia',
                'logo' => 'indonesia',
                'foto_gedung' => 'indonesia',
                'user_id' => '1', 
            ],
            (object) [
                'label'     => 'label2',
                'npsn'      => '2',
                'jenis_sekolah_id'   => '2',
                'alamat' => 'indonesia',
                'logo' => 'indonesia',
                'foto_gedung' => 'indonesia',
                'user_id' => '2', 
            ]
        ];

        foreach ($sekolahs as $sekolah) {
            $model = Sekolah::updateOrCreate(
                [
                    'jenis_sekolah_id' => $sekolah->jenis_sekolah_id,
                    'user_id' => $sekolah->user_id,
                    'label' => $sekolah->label,
                    'alamat' => $sekolah->alamat,
                    'logo' => $sekolah->logo,
                    'foto_gedung' => $sekolah->foto_gedung,
                    'npsn' => $sekolah->npsn,

                ]
            );
            $model->save();
        }       
    }
}