<?php namespace Bantenprov\Sekolah\Http\Controllers;

/* require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\Sekolah\Facades\Sekolah;

/* Models */
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Sekolah as SekolahModel;
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Province;
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Regency;

/* etc */
use Validator;

/**
 * The SekolahController class.
 *
 * @package Bantenprov\Sekolah
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class SekolahController extends Controller
{

    protected $province;

    protected $regency;

    protected $sekolah;

    public function __construct(Regency $regency, Province $province, SekolahModel $sekolah)
    {
        $this->regency  = $regency;
        $this->province = $province;
        $this->sekolah     = $sekolah;
    }

    public function index(Request $request)
    {
        /* todo : return json */

        return 'index';

    }

    public function create()
    {

        return response()->json([
            'provinces' => $this->province->all(),
            'regencies' => $this->regency->all()
        ]);
    }

    public function show($id)
    {

        $sekolah = $this->sekolah->find($id);

        return response()->json([
            'negara'    => $sekolah->negara,
            'province'  => $sekolah->getProvince->name,
            'regencies' => $sekolah->getRegency->name,
            'tahun'     => $sekolah->tahun,
            'data'      => $sekolah->data
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'negara'        => 'required',
            'province_id'   => 'required',
            'regency_id'    => 'required',
            'kab_kota'      => 'required',
            'tahun'         => 'required|integer',
            'data'          => 'required|integer',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'title'     => 'error',
                'message'   => 'add failed',
                'type'      => 'failed',
                'errors'    => $validator->errors()
            ]);
        }

        $check = $this->sekolah->where('regency_id',$request->regency_id)->where('tahun',$request->tahun)->count();

        if($check > 0)
        {
            return response()->json([
                'title'         => 'error',
                'message'       => 'Data allready exist',
                'type'          => 'failed',
            ]);

        }else{
            $data = $this->sekolah->create($request->all());

            return response()->json([
                    'type'      => 'success',
                    'title'     => 'success',
                    'id'      => $data->id,
                    'message'   => 'Sekolah '. $this->regency->find($request->regency_id)->name .' tahun '. $request->tahun .' successfully created',
                ]);
        }

    }

    public function update(Request $request, $id)
    {
        /* todo : return json */
        return '';

    }

    public function destroy($id)
    {
        /* todo : return json */
        return '';

    }
}

