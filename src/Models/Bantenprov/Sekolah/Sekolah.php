<?php

namespace Bantenprov\Sekolah\Models\Bantenprov\Sekolah;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sekolah extends Model
{

    protected $table = 'sekolahs';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('negara', 'province_id', 'kab_kota', 'regency_id', 'tahun', 'data');

    public function getProvince()
    {
        return $this->hasOne('Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Province','id','province_id');
    }

    public function getRegency()
    {
        return $this->hasOne('Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Regency','id','regency_id');
    }

}

