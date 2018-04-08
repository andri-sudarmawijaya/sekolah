<?php

namespace Bantenprov\Sekolah\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\Sekolah\Facades\SekolahFacade;
use App\User;
/* Models */
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Sekolah;
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\JenisSekolah;

/* Etc */
use Validator;

/**
 * The SekolahController class.
 *
 * @package Bantenprov\Sekolah
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class SekolahController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user;
    protected $jenis_sekolah;
    public function __construct(Sekolah $sekolah, User $user, JenisSekolah $jenis_sekolah)
    {
        $this->sekolah          = $sekolah;
        $this->user             = $user;
        $this->jenis_sekolah    = $jenis_sekolah;
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

            $query = $this->sekolah->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->sekolah->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('label', 'like', $value)
                    ->orWhere('npsn', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->with('user')->with('jenis_sekolah')->paginate($perPage);

        /*foreach($response as $user){
            array_set($response->data, 'user', $user->user->name);
        }
        foreach($response as $jenis_sekolah){
            array_set($response->data, 'jenis_sekolah', $jenis_sekolah->jenis_sekolah);
        }   */

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $response = [];

        $jenis_sekolahs  = $this->jenis_sekolah->all();
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

        foreach($jenis_sekolahs as $jenis_sekolah){
            array_set($jenis_sekolah, 'label', $jenis_sekolah->jenis_sekolah);
        }

        $response['jenis_sekolah'] = $jenis_sekolahs;
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
        $sekolah = $this->sekolah;

        $validator = Validator::make($request->all(), [
            'label'             => 'required',
            'jenis_sekolah_id'  => 'required',
            'npsn'              => 'required|unique:sekolahs,npsn',
            'alamat'            => 'required',
            'logo'              => 'required',
            'foto_gedung'       => 'required',
            'user_id'           => 'required|unique:sekolahs,user_id',
        ]);

        if($validator->fails()){
            $check = $sekolah->where('user_id',$request->user_id)->orWhere('npsn', $request->npsn)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, Username or npsn already exists';

            } else {
                $sekolah->label             = $request->input('label');
                $sekolah->jenis_sekolah_id  = $request->input('jenis_sekolah_id');
                $sekolah->npsn              = $request->input('npsn');
                $sekolah->alamat            = $request->input('alamat');
                $sekolah->logo              = $request->input('logo');
                $sekolah->foto_gedung       = $request->input('foto_gedung');
                $sekolah->user_id           = $request->input('user_id');
                $sekolah->save();

                $response['message'] = 'success';
            }
        } else {
                $sekolah->label             = $request->input('label');
                $sekolah->jenis_sekolah_id  = $request->input('jenis_sekolah_id');
                $sekolah->npsn              = $request->input('npsn');
                $sekolah->alamat            = $request->input('alamat');
                $sekolah->logo              = $request->input('logo');
                $sekolah->foto_gedung       = $request->input('foto_gedung');
                $sekolah->user_id           = $request->input('user_id');
                $sekolah->save();

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
        $sekolah = $this->sekolah->findOrFail($id);

        array_set($sekolah, 'user', $sekolah->user->name);
        array_set($sekolah, 'jenis_sekolah', $sekolah->jenis_sekolah);

        $response['sekolah'] = $sekolah;
        $response['status'] = true;

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
        $sekolah = $this->sekolah->findOrFail($id);

        array_set($sekolah->jenis_sekolah, 'label', $sekolah->jenis_sekolah->jenis_sekolah);
        array_set($sekolah->user, 'label', $sekolah->user->name);

        $response['sekolah'] = $sekolah;
        $response['user'] = $sekolah->user;
        $response['jenis_sekolah'] = $sekolah->jenis_sekolah;
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
        $response = array();
        $message  = array();

        $sekolah = $this->sekolah->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'label'               => 'required',
                'user_id'             => 'required|unique:sekolahs,user_id,'.$id,
                'jenis_sekolah_id'    => 'required',
                'npsn'                => 'required|unique:sekolahs,npsn,'.$id,
                'alamat'              => 'required',
                'logo'                => 'required',
                'foto_gedung'         => 'required',

            ]);

            if($validator->fails()){

                foreach($validator->messages()->getMessages() as $key => $error){
                    foreach($error AS $error_get) {
                        array_push($message, $error_get);
                    }
                }

                $check_user   = $this->sekolah->where('id','!=', $id)->where('user_id', $request->user_id);
                $check_npsn   = $this->sekolah->where('id','!=', $id)->where('npsn', $request->npsn);


                if($check_npsn->count() > 0 || $check_user->count() > 0){
                    $response['message'] = implode("\n",$message);

                } else {
                    $sekolah->label                 = $request->input('label');
                    $sekolah->jenis_sekolah_id      = $request->input('jenis_sekolah_id');
                    $sekolah->user_id               = $request->input('user_id');
                    $sekolah->npsn                  = $request->input('npsn');
                    $sekolah->alamat                = $request->input('alamat');
                    $sekolah->logo                  = $request->input('logo');
                    $sekolah->foto_gedung           = $request->input('foto_gedung');
                    $sekolah->save();
                    $response['message'] = 'success';
            }

        } else {
            $sekolah->label                  = $request->input('label');
            $sekolah->jenis_sekolah_id       = $request->input('jenis_sekolah_id');
            $sekolah->user_id                = $request->input('user_id');
            $sekolah->npsn                   = $request->input('npsn');
            $sekolah->alamat                 = $request->input('alamat');
            $sekolah->logo                   = $request->input('logo');
            $sekolah->foto_gedung            = $request->input('foto_gedung');
            $sekolah->save();
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
        $sekolah = $this->sekolah->findOrFail($id);

        if ($sekolah->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        return json_encode($response);
    }
}
