@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
<h2>Administra los comentarios</h2>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título del artículo</th>
                    <th>Comentario</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
              @foreach ($comments as $comment)
                  
              @endforeach
                <tr>
                    <td>{{ $comment->title }}</td>
                    <td>{{ $comment->description }}</td>
                    {{-- fecha de publicación --}}
                    <td>{{ Auth::user()->full_name }}</td>
                    <td>{{ $comment->created_at }}</td>
                    <td width="10px">
                        <form action="#" method="POST">
                            <input type="submit" value="Eliminar" class="btn btn-danger btn-sm">
                        </form>
                    </td>
            </tbody>
    </div>
</div>
@endsection