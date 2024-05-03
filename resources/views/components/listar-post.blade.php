<div>
    @if ($posts->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
        @foreach ($posts as $post)
            <div>
                <a href="{{ route('posts.show', ['post' => $post, 'user' =>$post->user]) }}">
                    <!--<img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}" style="border-radius: 10px;">-->
                    <img src="{{ asset('uploads') . '/' . $post->imagen }}"
                        alt="Imagen del post {{ $post->titulo }}" class="post-image">
                </a>
            </div>
        @endforeach
    </div>
    <style>
        .post-image {
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .post-image:hover {
            transform: scale(1.1);
        }
    </style>

    <div class="my-10">
        {{ $posts->links('') }}
    </div>
    @else
        <p class="text-center">No hay posts, sigue a alguien para poder mostrar sus posts</p>
    @endif
</div>
