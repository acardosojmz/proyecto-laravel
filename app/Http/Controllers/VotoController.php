<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidato;
use App\Models\Casilla;
use App\Models\Eleccion;
use App\Models\Voto;
use App\Models\Votocandidato;


class VotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $casillas = Casilla::all();
        $candidatos = Candidato::all();
        $elecciones = Eleccion::all();
        return view('voto/create',compact('casillas','candidatos','elecciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $candidatos=[];
        foreach($request->all() as $k=>$v){
           
            if (substr($k,0,10)=="candidato_")
                $candidatos[substr($k,10)]=$v;
        }

  
        $data['eleccion_id']=$request->eleccion_id;
        $data['casilla_id']=$request->casilla_id;
        $evidenceFileName ="";
        if ($request->hasFile('evidencia')) {
            $evidenceFileName = $request->file('evidencia')->getClientOriginalName();
        }
        if ($request->hasFile('evidencia')) $request->file('evidencia')->move(public_path('pdf'), $evidenceFileName);

        $data['evidencia']=$evidenceFileName;
        
        $voto =Voto::create($data);
        print("ID: ". $voto->id);

        //--- save to votocandidato
        foreach($candidatos as $k=>$v){
            $votocandidato=[];
            $votocandidato['voto_id']= $voto->id;
            $votocandidato['candidato_id'] = $k;
            $votocandidato['votos']=$v;
            Votocandidato::create($votocandidato);
        }
        echo "Guardado ....";
        
    }  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
