<?php

namespace Bantenprov\Sekolah\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\Sekolah\Facades\SekolahFacade;

/* Models */
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\ProdiSekolah;
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Sekolah;
use Bantenprov\ProgramKeahlian\Models\Bantenprov\ProgramKeahlian\ProgramKeahlian;
use App\User;

/* Etc */
use Validator;
use Auth;

/**
 * The ProdiSekolahController class.
 *
 * @package Bantenprov\Sekolah
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ProdiSekolahController extends Controller
{
    protected $prodi_sekolah;
    protected $sekolah;
    protected $program_keahlian;
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->prodi_sekolah    = new ProdiSekolah;
        $this->sekolah          = new Sekolah;
        $this->program_keahlian = new ProgramKeahlian;
        $this->user             = new User;
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

                $q->where('keterangan', 'like', $value)
                    ->orWhere('kuota_siswa', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;

        $response = $query->with('sekolah', 'program_keahlian', 'user')->paginate($perPage);

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }


     /** Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response*/

    public function create()
    {
        $response = [];

        $sekolahs           = $this->sekolah->all();
        $program_keahlians  = $this->program_keahlian->all();
        $users_special = $this->user->all();
        $users_standar = $this->user->find(\Auth::User()->id);
        $current_user = \Auth::User();

        $role_check = \Auth::User()->hasRole(['superadministrator','administrator']);

        if($role_check){
            $response['user_special'] = true;
            foreach($users_special as $user){
                array_set($user, 'label', $user->name);
            }
            $response['user'] = $users_special;
        }else{
            $response['user_special'] = false;
            array_set($users_standar, 'label', $users_standar->name);
            $response['user'] = $users_standar;
        }

        array_set($current_user, 'label', $current_user->name);

        $response['current_user'] = $current_user;

        foreach($program_keahlians as $program_keahlian){
            array_set($program_keahlian, 'program_keahlian', $program_keahlian->program_keahlian);
        }

        $response['sekolah'] = $sekolahs;
        $response['program_keahlian'] = $program_keahlians;
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
     * Display the specified resource.
     *
     * @param  \App\ProdiSekolah  $prodi_sekolah
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prodi_sekolah = $this->prodi_sekolah->with(['sekolah', 'program_keahlian', 'user'])->findOrFail($id);

        $response['prodi_sekolah']  = $prodi_sekolah;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;

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
        $prodi_sekolah = $this->prodi_sekolah->with(['sekolah', 'program_keahlian', 'user'])->findOrFail($id);

        $response['prodi_sekolah']  = $prodi_sekolah;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;

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
        $response = array();
        $message  = array();

        $prodi_sekolah = $this->prodi_sekolah->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'sekolah_id'             => 'required',
                'user_id'                => 'required|unique:prodi_sekolahs,user_id,'.$id,
                'keterangan'             => 'required',
                'kuota_siswa'            => 'required',
                'program_keahlian_id'    => 'required',
            ]);

            if($validator->fails()){

                foreach($validator->messages()->getMessages() as $key => $error){
                    foreach($error AS $error_get) {
                        array_push($message, $error_get);
                    }
                }

                $check_user   = $this->prodi_sekolah->where('id','!=', $id)->where('user_id', $request->user_id);

            if($check_user->count() > 0){
                    $response['message'] = implode("\n",$message);

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
                $prodi_sekolah->sekolah_id          = $request->input('sekolah_id');
                $prodi_sekolah->user_id             = $request->input('user_id');
                $prodi_sekolah->program_keahlian_id = $request->input('program_keahlian_id');
                $prodi_sekolah->keterangan          = $request->input('keterangan');
                $prodi_sekolah->kuota_siswa         = $request->input('kuota_siswa');
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
            $response['message']    = 'Success';
            $response['success']    = true;
            $response['status']     = true;
        } else {
            $response['message']    = 'Failed';
            $response['success']    = false;
            $response['status']     = false;
        }

        return json_encode($response);
    }
}
