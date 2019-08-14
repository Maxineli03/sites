<?php

namespace App\Http\Controllers;

use App\Chamado;
use App\Site;
use Illuminate\Http\Request;

class ChamadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Site $site)
    {
        dd("to aqui $site->dominio");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Site $site)
    {
        $this->authorize('sites.update',$site);
        return view('chamados/create',compact('site')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Site $site)
    {
        $request->validate([
          'descricao'  => ['required'],
          'tipo'       => ['required'],
        ]);

        $chamado = new Chamado;
        $chamado->descricao = $request->descricao;
        $chamado->tipo = $request->tipo;
        $chamado->status = 'aberto';
        $chamado->site_id = $site->id;
        $chamado->user_id = \Auth::user()->id;
        $chamado->save();

        $request->session()->flash('alert-info', 'Chamado cadastrado com sucesso');
        return redirect("/sites/$site->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chamado  $chamado
     * @return \Illuminate\Http\Response
     */
    public function show(Chamado $chamado, Site $site)
    {
        dd("to aqui");

        $this->authorize('sites.view',$site);
        return view('chamados/show',compact('site','chamado')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chamado  $chamado
     * @return \Illuminate\Http\Response
     */
    public function edit(Chamado $chamado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chamado  $chamado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chamado $chamado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chamado  $chamado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chamado $chamado)
    {
        //
    }
}
