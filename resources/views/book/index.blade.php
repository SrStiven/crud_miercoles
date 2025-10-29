@extends('layouts.app')
@section('content')

    <div class="container p-3 my-3 border">
        <div class="mx-auto" style="width:200px">
            <h2>Crear libros</h2>
        </div>
        
        <form action="{{ route('book.create') }}" method="POST">
        @csrf
        <div class="form-group">
            <label> Nombre del autor</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Titulo del libro</label>
            <input type="text" name="title" required>
        </div>
        <div class="form-group">
            <label>Cantidad de libros</label>
            <input type="number" name="count" required min="0">
        </div>
        <div class="form-group">
            <label>Fecha de vencimiento del libro</label>
            <input type="date" name="due_date" required>
        </div>
        <div class="form-group">
            <label>Genero del libro</label>
            <select name="gender" class="form-control">
                <option value="">Seleccinar</option>
                <option value="accion">Accion</option>
                <option value="comedia">Comedia</option>
                <option value="ficcion">Ficcion</option>
            </select>
        </div>
        <button type="submit">Enviar</button>
    </form>
    </div>
 
    <hr>
    <form action="{{ route('book.destroy') }}" method="POST" onsubmit="return confirm('Estas seguro')?">
        @csrf
        <div>
            <label>Eliminar todos los libros</label>
            <button type="submit" class="btn btn-danger"> Eliminar</button>
        </div>
    </form>
    <hr>
    <div class="container">
        <div class="container p-3 my-3 border">
            <h2>Export</h2>
            <label>Export excel</label>
            <a href="{{ route('book.export') }}"  class="btn btn-light">Exportar excel</a>
    </div>

    <div class="container p-3 my-3 border">
        <h2>Import</h2>
        <form action="{{ route('book.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Importar excel</label>
            <input type="file" name="file">
            <button type="submit" class="btn btn-secondary">Cargar</button>
        </div>
        </form>
    </div>

</div>


<div class="container">
   <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Titulo</th>
                <th>Cantidad</th>
                <th>Genero</th>
                <th>Fecha</th>
                <th>Accion</th>
                <th>Accion</th>
            </tr>
        </thead>
        @foreach ($books as $book )
            <tbody>
                <tr style="{{ $book->active ? '' : 'background-color:red' }}">
                    <th>{{$book->name}}</th>
                    <th>{{$book->title}}</th>
                    <th>{{$book->count}}</th>
                    <th>{{$book->gender}}</th>
                    <th>{{$book->due_date}}</th>
                    <th><a href="{{ route('book.edit', $book->id) }}">Editar</a></th>
                    <th><a href="{{ route('book.delete', $book->id) }}">Eliminar</a></th>
                </tr>
            </tbody>
            
        @endforeach
    </table>
</div>
@endsection
