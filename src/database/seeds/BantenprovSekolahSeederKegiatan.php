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
                'label' => 'Sekolah 1',
                'description' => 'Sekolah 1',
            ],
            (object) [
                'label' => 'Sekolah 2',
                'description' => 'Sekolah 2',
            ]
        ];

        foreach ($sekolahs as $sekolah) {
            $model = Sekolah::updateOrCreate(
                [
                    'label' => $sekolah->label,
                ],
                [
                    'description' => $sekolah->description,
                ]
            );
            $model->save();
        }
	}
}
