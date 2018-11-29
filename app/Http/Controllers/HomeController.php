<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Afiliado;
use App\FUA;
use View;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //$fuas = FUA::where('estado','=',1)->get();
        $fuas = DB::table('fuas as f')
            ->leftJoin('afiliados as a', 'a.id', '=', 'f.id_afiliado')
            ->leftJoin('users as u', 'u.id', '=', 'f.fua_profesional')
            ->where('f.estado','=',1)
            ->select(
                'f.id',
                'f.fua_NumFormato', 
                'a.afi_ApePaterno', 
                'a.afi_ApeMaterno', 
                'a.afi_Nombres', 
                'a.afi_SegNombre', 
                'a.afi_Dni',
                'u.name',
                'u.lastname'
            )
            ->get();
        View::share('i', 0);
        return view('fuas.index',compact('fuas'));

    }

    public function afiliados(Request $request)
    {

        $queryWord = strtoupper($request->q);
        $searchedBooks = null;
        if($queryWord != ""){
            $searchedBooks = Afiliado::where('afi_NroFormato', '=', $queryWord)
            ->get();
        }
        View::share('q', $request->q);
        View::share('searchedBooks', $searchedBooks );
        return view('home');

    }

    public function fuas(Request $request)
    {

        $queryWord = strtoupper($request->fn);
        $fuas = null;
        if($queryWord != ""){

            $fuas = DB::table('fuas as f')
            ->leftJoin('afiliados as a', 'a.id', '=', 'f.id_afiliado')
            ->leftJoin('users as u', 'u.id', '=', 'f.fua_profesional')
            ->where('f.fua_NumFormato','=',$queryWord)
            ->select(
                'f.id',
                'f.fua_NumFormato', 
                'a.afi_ApePaterno', 
                'a.afi_ApeMaterno', 
                'a.afi_Nombres', 
                'a.afi_SegNombre', 
                'a.afi_Dni',
                'u.name',
                'u.lastname'
            )
            ->get();
        }
        View::share('i', 0);
        View::share('fn', $request->fn);
        View::share('fuas', $fuas );
        return view('fuas');

    }
}
