<?php

namespace Bantenprov\Sekolah\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\Sekolah\Facades\SekolahFacade;
use App\User;
/* Models */
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Sekolah;
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\ProdiSekolah;
use Bantenprov\ProgramKeahlian\Models\Bantenprov\ProgramKeahlian\ProgramKeahlian;

/* Etc */
use Validator;

/**
 * The SekolahController class.
 *
 * @package Bantenprov\Sekolah
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ProdiSekolahController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user;
    protected $prodi_sekolah;
    protected $sekolah;
    protected $program_keahlian;
    public function __construct(Sekolah $sekolah, User $user, ProdiSekolah $prodi_sekolah, ProgramKeahlian $program_keahlian)
    {
        $this->sekolah          = $sekolah;
        $this->user             = $user;
        $this->prodi_sekolah    = $prodi_sekolah;
        $this->program_keahlian = $program_keahlian;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);

            $query = $this->prodi_sekolah->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->prodi_sekolah->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('keterangana', 'like', $value)                    
                    ->orWhere('kuota_siswa', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->with('user')->with('sekolah')->with('program_keahlian')->paginate($perPage);
        
        
        /*foreach($response as $sekolah){
            array_set($response->data, 'sekolah', $sekolah->sekolah->label);
        }         

        foreach($response as $user){
            array_set($response->data, 'user', $user->user->name);
        }

        foreach($response as $program_keahlian){
            array_set($response->data, 'program_keahlian', $program_keahlian->program_keahlian->label);
        }*/


        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    
     /** Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response*/
     
    public function create()
    {        
        $users              = $this->user->all();
        $sekolahs           = $this->sekolah->all();
        $program_keahlians  = $this->program_keahlian->all();

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }

        foreach($program_keahlians as $program_keahlian){
            array_set($program_keahlian, 'program_keahlian', $program_keahlian->program_keahlian);
        }

        
        $response['sekolah'] = $sekolahs;
        $response['program_keahlian'] = $program_keahlians;
        $response['user'] = $users;
        $response['status'] = true;
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prodi_sekolah = $this->prodi_sekolah;

        $validator = Validator::make($request->all(), [
            'keterangan'            => 'required',
            'kuota_siswa'           => 'required',
            'program_keahlian_id'   => 'required',
            'sekolah_id'            => 'required',
            'user_id'               => 'required|unique:prodi_sekolahs,user_id',
        ]);

        if($validator->fails()){
            $check = $prodi_sekolah->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, user  already exists';

            } else {
                $prodi_sekolah->sekolah_id            = $request->input('sekolah_id');
                $prodi_sekolah->user_id               = $request->input('user_id');
                $prodi_sekolah->program_keahlian_id   = $request->input('program_keahlian_id');
                $prodi_sekolah->keterangan            = $request->input('keterangan');
                $prodi_sekolah->kuota_siswa           = $request->input('kuota_siswa');
                $prodi_sekolah->save();

                $response['message'] = 'success';
            }
        } else {
                $prodi_sekolah->sekolah_id            = $request->input('sekolah_id');
                $prodi_sekolah->user_id               = $request->input('user_id');
                $prodi_sekolah->program_keahlian_id   = $request->input('program_keahlian_id');
                $prodi_sekolah->keterangan            = $request->input('keterangan');
                $prodi_sekolah->kuota_siswa           = $request->input('kuota_siswa');
                $prodi_sekolah->save();

            $response['message'] = 'success';
        }

        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
     {
         $prodi_sekolah = $this->prodi_sekolah->findOrFail($id);

         array_set($prodi_sekolah, 'user', $prodi_sekolah->user->name);
         array_set($prodi_sekolah, 'sekolah', $prodi_sekolah->sekolah->label);
         array_set($prodi_sekolah, 'program_keahlian', $prodi_sekolah->program_keahlian->label);

         $response['sekolah']           = $prodi_sekolah;
         $response['program_keahlian']  = $prodi_sekolah;
         $response['status']            = true;

         return response()->json($response);
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prodi_sekolah = $this->prodi_sekolah->findOrFail($id);

        array_set($prodi_sekolah->user, 'label', $prodi_sekolah->user->name);
        array_set($prodi_sekolah->program_keahlian, 'program_keahlian', $prodi_sekolah->program_keahlian->label);

        $response['user']               = $prodi_sekolah->user;
        $response['sekolah']            = $prodi_sekolah;
        $response['prodi_sekolah']      = $prodi_sekolah->sekolah;
        $Response['program_keahlian']   = $prodi_sekolah->program_keahlian;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $prodi_sekolah = $this->prodi_sekolah->findOrFail($id);

        if ($request->input('old_user_id') == $request->input('user_id'))
        {
            $validator = Validator::make($request->all(), [
                'sekolah_id'             => 'required',
                'user_id'                => 'required',
                'keterangan'             => 'required',
                'kuota_siswa'            => 'required',
                'program_keahlian_id'    => 'required',


            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'sekolah_id'             => 'required',
                'user_id'                => 'required|unique:prodi_sekolahs,user_id',
                'keterangan'             => 'required',
                'kuota_siswa'            => 'required',
                'program_keahlian_id'    => 'required',
            ]);
        }

        if ($validator->fails()) {
            $check = $prodi_sekolah->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, user  already exists';
            } else {
                $prodi_sekolah->sekolah_id          = $request->input('sekolah_id');
                $prodi_sekolah->user_id             = $request->input('user_id');
                $prodi_sekolah->program_keahlian_id = $request->input('program_keahlian_id');
                $prodi_sekolah->keterangan          = $request->input('keterangan');
                $prodi_sekolah->kuota_siswa         = $request->input('kuota_siswa');
                $prodi_sekolah->save();

                $response['message'] = 'success';
            }
        } else {
                $prodi_sekolah->sekolah_id      = $request->input('sekolah_id');
                $prodi_sekolah->user_id         = $request->input('user_id');
                $prodi_sekolah->program_keahlian_id = $request->input('program_keahlian_id');
                $prodi_sekolah->keterangan      = $request->input('keterangan');
                $prodi_sekolah->kuota_siswa     = $request->input('kuota_siswa');
                $prodi_sekolah->save();

            $response['message'] = 'success';
        }

        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prodi_sekolah = $this->prodi_sekolah->findOrFail($id);

        if ($prodi_sekolah->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        return json_encode($response);
    }
}
