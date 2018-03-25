<?php

/* Require */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/* Models */
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\ProdiSekolah;

class BantenprovProdiSekolahSeederProdiSekolah extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $prodi_sekolahs = (object) [
            (object) [
                'sekolah_id'            => '1',
                'user_id'               => '1',
                'program_keahlian_id'   => '1',
                'keterangan'            => 'Keterangan1',
                'kuota_siswa'           => '50'
            ],
            (object) [
                'sekolah_id'            => '2',
                'user_id'               => '2',
                'program_keahlian_id'   => '2',
                'keterangan'            => 'Keterangan2',
                'kuota_siswa'           => '50' 
            ]
        ];

        foreach ($prodi_sekolahs as $prodi_sekolah) {
            $model = ProdiSekolah::updateOrCreate(
                [
                    'sekolah_id'            => $prodi_sekolah->sekolah_id,
                    'user_id'               => $prodi_sekolah->user_id,
                    'program_keahlian_id'   => $prodi_sekolah->program_keahlian_id,
                    'keterangan'            => $prodi_sekolah->keterangan,
                    'kuota_siswa'           => $prodi_sekolah->kuota_siswa,
                ]
            );
            $model->save();
        }
    }
}