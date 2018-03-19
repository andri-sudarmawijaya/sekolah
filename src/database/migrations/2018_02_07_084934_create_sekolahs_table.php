<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('sekolahs', function(Blueprint $table) {
			$table->increments('id');
			$table->string('label');
			$table->string('npsn');
			$table->integer('jenis_sekolah_id');
			$table->string('alamat');
			//$table->integer('kelurahan_id')->unsigned()->index();
			//$table->integer('kecamatan_id')->unsigned()->index();
			//$table->integer('kabkota_id')->unsigned()->index();
			$table->string('logo');
			$table->string('foto_gedung');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('user_id');
		});
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
	{
		Schema::drop('sekolahs');
	}
}
