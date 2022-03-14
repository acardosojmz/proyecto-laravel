<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidato;

class CandidatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidatos = Candidato::all();
        return view ('candidato/list',compact('candidatos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('candidato/create');
    }

    function validateData(Request $request)
    {
        $request->validate([
            'nombrecompleto' => 'required|max:200',
            'sexo' => 'required',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateData($request);

        $fotocandidato = "";
        $perfilcandidato = "";
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotocandidato = $foto->getClientOriginalName();
        }
        if ($request->hasFile('perfil')) {
            $perfil = $request->file('perfil');
            $perfilcandidato = $perfil->getClientOriginalName();
        }
        $campos=[
                'nombrecompleto' => $request->nombrecompleto,
                'sexo'           => $request->sexo,
                'foto'           => $fotocandidato,
                'perfil'         => $perfilcandidato,
        ];
        if ($request->hasFile('foto')) $foto->move(public_path('image'), $fotocandidato);
        if ($request->hasFile('perfil')) $perfil->move(public_path('pdf'), $perfilcandidato);
        //print_r($campos);
        $candidato = Candidato::create($campos);
        //echo $candidato->nombrecompleto . " se guardo correctamente ... ";
        return redirect("candidato");
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
        $candidato = Candidato::find($id);
        return view ('candidato/edit', compact('candidato')); 
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
        $this->validateData($request);

        $fotoCandidato = "";
        $perfilCandidato = "";
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoCandidato = $foto->getClientOriginalName();
        }
        if ($request->hasFile('perfil')) {
            $perfil = $request->file('perfil');
            $perfilCandidato = $perfil->getClientOriginalName();
        }

        $currentValue = Candidato::find($id);
        
        if (empty($fotoCandidato)) $fotoCandidato = $currentValue->foto;
        if (empty($perfilCandidato)) $perfilCandidato = $currentValue->perfil;

        $campos=[
                'nombrecompleto' => $request->nombrecompleto,
                'sexo'           => $request->sexo,
                'foto'           => $fotoCandidato,
                'perfil'         => $perfilCandidato,
        ];
        if ($request->hasFile('foto')) $foto->move(public_path('image'), $fotoCandidato);
        if ($request->hasFile('perfil')) $perfil->move(public_path('pdf'), $perfilCandidato);

        Candidato::whereId($id)->update($campos);
        return redirect('candidato')->with('success', 'Actualizado correctamente...');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Candidato::whereId($id)->delete();
        return redirect('candidato');
    }
}
