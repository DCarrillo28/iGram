@extends('layouts.app')

@section('titulo')
    Editar Perfil: {{ auth()->user()->username }}
@endsection


@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form method="POST" action="{{route('perfil.store')}}" enctype="multipart/form-data" class="mt-10
            md:mt-0">
            @csrf
                <div>
                    <label for="username" id="username" class="md-2 block uppercase text-gray-500 font-bold">
                        Username
                    </label>
                    <input
                        id="username"
                        type="text"
                        name="username"
                        placeholder="Tu Nombre de Usuario"
                        class="borde p-3 w-full rounded-lg @error('username') border-red-500 @enderror"
                        value="{{auth()->user()->username}}"
                    />

                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"> {{ $message }} </p>
                    @enderror
                </div>

                <div>
                    <label for="imagen" id="username" class="md-2 block uppercase text-gray-500 font-bold">
                        Imagen Perfil
                    </label>
                    <input
                        id="imagen"
                        type="file"
                        name="imagen"
                        class="borde p-3 w-full rounded-lg
                        value=""
                        accept=".jpg, .jpeg, .png"
                    />
                </div>
                <input
                    type="submit"
                    name="submit"
                    value="Guardar Cambios"
                    class="bg-sky-600 hover:bg-sky-700 transitions-colors cursor-pointer uppercase font-bold w-full
                    p-3 text-white rounded-lg mt-5">
            </form>
        </div>
    </div>
@endsection
