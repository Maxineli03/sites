@extends('master')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
@parent

<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Site</th>
        <th>Autor(a)</th>
        <th>Em</th>
        <th>Status</th>
        <th>Tipo</th>
        <th>Descrição</th>
      </tr>
    </thead>

    <tbody>

@forelse ($chamados->sortByDesc('created_at') as $chamado)
      <tr>
        <td> {{ $chamado->id }}</td>
        <td> <b> {{ $chamado->site->dominio.config('sites.dnszone') }}</b></td>
        <td>{{ $chamado->user->name }}</td>
        <td>{{ Carbon\Carbon::parse($chamado->created_at)->format('d/m/Y H:i') }}</td>
        <td><b>{{ $chamado->status }}</b></td>
        <td>{{ $chamado->tipo }}</td>
        <td><a href="/chamados/{{$chamado->site_id}}/{{$chamado->id}}">{!! $chamado->descricao !!}</a></td>
      </tr>
@empty
    <tr>
        <td colspan="7">Não há chamados abertos</td>
    </tr>
@endforelse
</tbody>
</table>

</div>


@stop