<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidato;
use App\Models\Casilla;
use App\Models\Eleccion;
use App\Models\Voto;
use App\Models\Votocandidato;
use Exception;
use Illuminate\Support\Facades\DB;

class VotoController extends Controller
{   
    private $DUPLICATE_KEY_CODE=23000;
    private $DUPLICATE_KEY_MESSAGE="Ya existe un dato igual en la BD, ". 
            "no se permiten duplicados";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $votos = Voto::all();
        return view('voto/list', compact('votos'));
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

    private function validateVote($request){
        foreach($request->all() as $key=>$value){
            if (substr($key,0,10)=="candidato_")
                if ($value<0){
                    return false;
                }
        }
        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            if (!($this->validateVote($request))){
                return "Lo votos no pueden ser negativos";
            }
            $candidatos=[];
            foreach($request->all() as $key=>$value){
                if (substr($key,0,10)=="candidato_")
                    $candidatos[substr($key,10)]=$value;
            }

    
            $data['eleccion_id']=$request->eleccion_id;
            $data['casilla_id']=$request->casilla_id;
            $evidenceFileName ="";
            if ($request->hasFile('evidencia')) {
                $evidenceFileName = $request->file('evidencia')->getClientOriginalName();
            }
            if ($request->hasFile('evidencia')) $request->file('evidencia')->move(public_path('pdf'), $evidenceFileName);

            $data['evidencia']=$evidenceFileName;
            
            $message="save successfull";
            $success=true;
            DB::beginTransaction();
            try {
                //--- save to voto
                $voto =Voto::create($data);
    
                //--- save to votocandidato
                foreach($candidatos as $key=>$value){
                    $votocandidato=[];
                    $votocandidato['voto_id']= $voto->id;
                    $votocandidato['candidato_id'] = $key;
                    $votocandidato['votos']=$value;
                    Votocandidato::create($votocandidato);
                }
                DB::commit();
                
            } catch (\Exception $e) {
                $success=false;
                DB::rollback();
                if ($e->getCode()==$this->DUPLICATE_KEY_CODE)
                    $message=$this->DUPLICATE_KEY_MESSAGE;
                else
                    $message=$e->getMessage();
            }
        
        return view('message',compact('message','success'));
        
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
        $voto= Voto::find($id);
        if ($voto){
            return view ('voto/edit',compact('voto'));
        } else {
            $message= "No se localizó voto $id";
            return view('message',$message);
        }
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
        if (!($this->validateVote($request))){
            return "Lo votos no pueden ser negativos";
        }
        $candidatos=[];
        foreach($request->all() as $key=>$value){
            if (substr($key,0,10)=="candidato_")
                $candidatos[substr($key,10)]=$value;
        }

        $data['eleccion_id']=$request->eleccion_id;
        $data['casilla_id']=$request->casilla_id;
        $evidenceFileName ="";
        if ($request->hasFile('evidencia')) {
            $evidenceFileName = $request->file('evidencia')->getClientOriginalName();
        }
        if ($request->hasFile('evidencia')) $request->file('evidencia')->move(public_path('pdf'), $evidenceFileName);

        $data['evidencia']=$evidenceFileName;
        
        $message="save successfull";
        $success=true;
        DB::beginTransaction();
        try {
            //--- save to voto
            Voto::whereId($id)->update($data);
            //--- save to votocandidato
            foreach($candidatos as $key=>$value){
                Votocandidato::where("voto_id","=",$id) 
                    ->where("candidato_id","=",$key) 
                    ->update(["votos"=>$value]);
            }
            DB::commit();
            
        } catch (\Exception $e) {
            $success=false;
            DB::rollback();
            $message=$e->getMessage();
        }
    
        return view('message',compact('message','success'));
    
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $success=true;
        try {
            Votocandidato::where('voto_id', '=', $id)->delete();
            Voto::whereId($id)->delete();
            DB::commit();
            $message="Operacion exitosa";

        } catch (\Exception $ex){
            DB::rollBack();
            $message = $ex->getMessage();
            $success=false;
        }     
        return view ('message',compact('message','success'));
    }
}
