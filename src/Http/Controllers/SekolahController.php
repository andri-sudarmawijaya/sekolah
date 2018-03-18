<?php

namespace Bantenprov\Sekolah\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\Sekolah\Facades\SekolahFacade;
use App\User;
/* Models */
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Sekolah;

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
    public function __construct(Sekolah $sekolah, User $user)
    {
        $this->sekolah = $sekolah;
        $this->user = $user;
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
                    ->orWhere('description', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->paginate($perPage);

        foreach($response as $user){
            array_set($response->data, 'user', $user->user->name);
        }

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
        $users = $this->user->all();

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }
        
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
        $sekolah = $this->sekolah;

        $validator = Validator::make($request->all(), [
            'label'         => 'required|max:16|unique:sekolahs,label',
            'description'   => 'required',
            'npsn'          => 'required',
            'alamat'        => 'required',
            'logo'          => 'required',
            'foto_gedung'   => 'required',
            'user_id'       => 'required',
        ]);

        if($validator->fails()){
            $check = $sekolah->where('label',$request->label)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, label ' . $request->label . ' already exists';
            } else {
                $sekolah->label         = $request->input('label');
                $sekolah->description   = $request->input('description');
                $sekolah->npsn          = $request->input('npsn');
                $sekolah->alamat        = $request->input('alamat');
                $sekolah->logo          = $request->input('logo');
                $sekolah->foto_gedung   = $request->input('foto_gedung');
                $sekolah->user_id       = $request->input('user_id');
                $sekolah->save();

                $response['message'] = 'success';
            }
        } else {
                $sekolah->label         = $request->input('label');
                $sekolah->description   = $request->input('description');
                $sekolah->npsn          = $request->input('npsn');
                $sekolah->alamat        = $request->input('alamat');
                $sekolah->logo          = $request->input('logo');
                $sekolah->foto_gedung   = $request->input('foto_gedung');
                $sekolah->user_id       = $request->input('user_id');
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

        $response['sekolah'] = $sekolah;
        $response['user'] = $sekolah->user;
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
        $sekolah = $this->sekolah->findOrFail($id);

        if ($request->input('old_label') == $request->input('label'))
        {
            $validator = Validator::make($request->all(), [
                'label'         => 'required',
                'description'   => 'required',
                'user_id'       => 'required',
                'npsn'          => 'required',
                'alamat'        => 'required',
                'logo'          => 'required',
                'foto_gedung'   => 'required',

            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'label'         => 'required',
                'description'   => 'required',
                'user_id'       => 'required',
                'npsn'          => 'required',
                'alamat'        => 'required',
                'logo'          => 'required',
                'foto_gedung'   => 'required',
            ]);
        }

        if ($validator->fails()) {
            $check = $sekolah->where('label',$request->label)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, label ' . $request->label . ' already exists';
            } else {
                $sekolah->label         = $request->input('label');
                $sekolah->description   = $request->input('description');
                $sekolah->user_id       = $request->input('user_id');
                $sekolah->npsn          = $request->input('npsn');
                $sekolah->alamat        = $request->input('alamat');
                $sekolah->logo          = $request->input('logo');
                $sekolah->foto_gedung   = $request->input('foto_gedung');
                $sekolah->save();

                $response['message'] = 'success';
            }
        } else {
            $sekolah->label         = $request->input('label');
            $sekolah->description   = $request->input('description');
            $sekolah->user_id       = $request->input('user_id');
            $sekolah->npsn          = $request->input('npsn');
            $sekolah->alamat        = $request->input('alamat');
            $sekolah->logo          = $request->input('logo');
            $sekolah->foto_gedung   = $request->input('foto_gedung');
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
