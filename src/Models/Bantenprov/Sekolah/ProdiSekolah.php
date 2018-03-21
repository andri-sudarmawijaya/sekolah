<?php

namespace Bantenprov\Sekolah\Models\Bantenprov\Sekolah;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdiSekolah extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'prodi_sekolahs';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'sekolah_id',
        'user_id',
        'keterangan',
        'kuota_siswa',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

        public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

      public function sekolah()
    {
        return $this->belongsTo('Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Sekolah','sekolah_id');
    }

}
