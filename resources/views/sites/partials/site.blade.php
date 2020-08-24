<tr>
<td>
  <a href="/sites/{{ $site->id }}">{{ $site->dominio }}{{ config('sites.dnszone') }}</a> 
  <a href="/sites/{{ $site->id }}/edit"> <i class="fas fa-edit"></i> </a> <br>
  <b>categoria: </b>{{ $site->categoria }}<br>
  <b>status: </b>
    @if ($site->status == 'Solicitado') 
        Aguardando aprovação 
    @elseif ($site->status == 'Aprovado') 
        Aprovado - {{ $site->status_aegir }}
    @endif
  <br>
  <b>chamados: </b> <a href="/chamados/{{ $site->id }}"> {{ $site->chamados->where('status','aberto')->count() }} abertos</a> <a href="/chamados/{{ $site->id }}/create"> <i class="fas fa-plus"></i> </a><br>
</td>

<td>
  <b>Responsável:</b> {{ $site->owner }}
  @if(config('sites.usar_replicado') == true)
     - {{ \Uspdev\Replicado\Pessoa::dump($site->owner)['nompes'] }}
  @endif
  <br><br>
  <ul class="list-group">
    @if(!empty($site->numeros_usp)) <li class="list-group-item"> <b>Administradores:</b> </li> @endif
    @foreach(explode(',', $site->numeros_usp) as $numero_usp)
      @if(!empty($numero_usp))
      
          <li class="list-group-item">
               @can('sites.update',$site)
                    <form method="POST" action="/sites/{{ $site->id }}" style="display:inline">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="deleteadmin" value="{{ $numero_usp }}">
                    <button type="submit" class="delete-item btn"><i class="fas fa-trash-alt"></i></button>
                    </form>
               @endcan
{{ $numero_usp }}
  @if(config('sites.usar_replicado') == true)
   - {{ \Uspdev\Replicado\Pessoa::dump($numero_usp)['nompes'] }}
  @endif
          </li>
      @endif
    @endforeach
  </ul>
</td>

<td>
    <ul class="list-group">
        @if(config('app.env') == 'production')
          @php($port = '')
        @else
          @php($port = ':8088')
        @endif
        @if($site->status != "Solicitado")
          <li class="list-group-item">
            <a href="http://{{ $site->dominio }}{{ config('sites.dnszone') }}{{$port}}/loginbytoken/?temp_token={{$hashlogin}}&codpes={{ Auth::user()->codpes }}" class="" target="_blank">
              Logon <i class="fas fa-sign-in-alt"></i>
            </a></li>
        @endif

        @can('sites.update',$site)
           <li class="list-group-item"><a href="/sites/{{ $site->id }}/novoadmin">Adicionar administrador <i class="fas fa-user-plus"></i></a></li>
        @endcan

        @can('sites.update',$site)
            <li class="list-group-item"><a href="/sites/{{ $site->id }}/changeowner" class="">Mudar responsável </a></li>
        @endcan

        @can('admin')
            <li class="list-group-item">
                <form method="POST" action="/sites/{{ $site->id }}">
                @csrf
                @method('delete')
                <button type="submit" class="delete-item btn btn-danger">Deletar<i class="fas fa-trash-alt"></i></button>
                </form>
            </li>

            @if($site->status == 'Solicitado')
                <li class="list-group-item">
                    <form method="POST" action="/sites/{{ $site->id }}">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="aprovar" value="aprovar">
                    <button type="submit" class="btn btn-success">Aprovar<i class="fas fa-thumbs-up"></i></button>
                    </form>
                </li>
            @endif

            @if ($site->status_aegir == "Habilitado")
              <li class="list-group-item">
              <form method="POST" action="/sites/{{ $site->id }}/disable">
              @csrf
              <button type="submit" class="btn btn-info">Desabilitar</button>
              </form>
              </li>
            @elseif ($site->status_aegir == "Desabilitado")
              <li class="list-group-item">
              <form method="POST" action="/sites/{{ $site->id }}/enable">
              @csrf
              <button type="submit" class="btn btn-success">Habilitar</button>
              </form>
              </li>
              <li class="list-group-item">
              <form method="POST" action="/sites/{{ $site->id }}/delete">
              @csrf
              <button type="submit" class="btn btn-dark">Deletar</button>
              </form>
              </li>
            @elseif($site->status_aegir != "Servidor Offline" && $site->status == "Aprovado")
              <li class="list-group-item">
              <form method="POST" action="/sites/{{ $site->id }}/install">
              @csrf
              <button type="submit" class="btn btn-primary">(Re)Criar</button>
              </form>
              </li>
            @endif

        @endcan
</form>
    </ul>
</td>
</tr>