@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
    <div class="container mx-auto md:flex p-5">
        <div class="md:w-1/2">
            <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}"
                style="border-radius: 10px;">

            <div class="p-3 flex items-center gap-2">

                @auth
                    <livewire:like-post :post="$post"/>

                    {{--@if ($post->checkLike(auth()->user()))
                        <!--<p>Este Usuario ya dio like</p>-->
                        <form method="POST" action="{{ route('posts.like.destroy', $post) }}">
                            @method('DELETE')
                            @csrf
                            <div class="my-4">
                                <!-- Botón con animación de pulsación -->
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    @else
                        <style>
                            /* Define la animación de pulso */
                            @keyframes pulse {

                                /* Define el estado inicial de la animación */
                                0% {
                                    transform: scale(1);
                                    /* Escala del elemento al 100% */
                                }

                                /* Define el estado intermedio de la animación */
                                50% {
                                    transform: scale(1.05);
                                    /* Escala del elemento al 105% */
                                }

                                /* Define el estado final de la animación */
                                100% {
                                    transform: scale(1);
                                    /* Escala del elemento al 100% (vuelve al tamaño original) */
                                }
                            }

                            /* Aplica la animación al botón al hacer hover */
                            /* Transición suave de la propiedad 'transform' */
                            button[type="submit"] svg {
                                transition: transform 0.2s ease-in-out;
                            }

                            /* Aplica la animación 'pulse' al hacer hover sobre el botón */
                            button[type="submit"]:hover svg {
                                animation: pulse 0.5s infinite alternate;
                                /* Aplica la animación 'pulse' con una duración de 0.5 segundos,
                                                                                              se repite infinitamente y alterna entre los estados definidos */
                            }
                        </style>

                        <form method="POST" action="{{ route('posts.like.store', $post) }}">
                            @csrf
                            <div class="my-4">
                                <!-- Botón con animación de pulsación -->
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    @endif--}}
                @endauth
            </div>

            <div>
                <p class="font-bold"> {{ $post->user->username }} </p>
                <p class="text-sm text-gray-500">
                    {{ $post->created_at->diffForHumans() }}
                </p>
                <p class="mt-5">
                    {{ $post->descripcion }}
                </p>
            </div>

            @auth
                @if ($post->user_id === auth()->user()->id)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" value="Eliminar Publicación"
                            class="bg-red-500 hover:bg-red-600 rounded text-white font-bold mt-4 cursor-pointer">
                    </form>
                @endif
            @endauth
        </div>

        <div class="md:w-1/2 p-5">
            <div class="shadow bg-white p-5 mb-5">

                @auth
                    <p class="text-xl font-bold text-center mb-4"> Agrega un nuevo comentario </p>

                    @if (session('mensaje'))
                        <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                            {{ session('mensaje') }}
                        </div>
                    @endif

                    <form action="{{ route('comentarios.store', ['post' => $post, 'user' => $user]) }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">
                                Añade un comentario
                            </label>

                            <textarea name="comentario" id="comentario" placeholder="Agrega un comentario"
                                class="border p-3 w-full rounded-lg @error('name')
                                border-red-500
                            @enderror"></textarea>

                            <input type="submit" value="Comentar"
                                class="bg-sky-600 hover:bg-sky-700 transitions-colors cursor-pointer uppercase font-bold w-full p-4 mt-2 text-white rounded-lg">
                        </div>
                    </form>
                @endauth

                <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
                    @if ($post->comentarios->count())
                        @foreach ($post->comentarios as $comentario)
                            <div class="p-5 border-gray-300 border-b">
                                <!--  Para ir al muro del usuario-->
                                <a href="{{ route('posts.index', $comentario->user) }}" class="font-bold">
                                    {{ $comentario->user->username }}
                                </a>
                                <p> {{ $comentario->comentario }} </p>
                                <p class="text-sm text-gray-500"> {{ $comentario->created_at->diffForHumans() }} </p>
                            </div>
                        @endforeach
                    @else
                        <p class="p-10 text-center">No Hay Comentarios Aún</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
