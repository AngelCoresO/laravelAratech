@extends('layouts.app')
@section('content')
    @php

        session()->get('succes');

    @endphp
    <div class="container">
        @if(session()->get('success'))
        <div class="mt-3 mb-3" style="color:black;font-weight:bold;font-size:20px;text-align:center;background-color:rgba(0,255,0,0.76);">
            <p>{{session()->get('success')}}</p>
        </div>
        @else
        <div class="mt-3 mb-3" style="color:black;font-weight:bold;font-size:20px;text-align:center;background-color:rgba(255,0,0,0.76);">
            <p>{{session()->get('error')}}</p>
        </div>
        @endif
        <div class="mt-5">
            <h1>Listar Ficheros</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Usuario</th>
                        <th scope='col'>Imagen</th>
                        <th scope='col'>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($data as $index => $item)
                    <tr>
                        <td scope="row">{{$item->id}}</td>
                        <td scope="row"><a href="storage/files/{{$item->nombre}}" download="{{$item->nombre}}">{{$item->nombre}}</a></td>
                        <td scope="row">{{$item->tipoFichero}}</td>
                        <td scope="row">{{$item->userId}}</td>
                        <td scope="row"><img src="storage/files/{{$item->nombre}}"></td>
                        <td>
                            <a href="{{route('eliminar.fichero',$item->id)}}" class="btn btn-danger" 
                            onclick="confirm('¿Deseas eliminar este fichero?')">Eliminar</a>
                        </td>
                    </tr>
                @empty
                    <p>No hay elementos en la lista</p>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

