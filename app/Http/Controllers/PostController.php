<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except( 'show','index');
    }

    public function index(User $user){
        //dd($user);

        //$posts = Post::where('user_id', $user->id)->get();
        //$posts = Post::where('user_id', $user->id)->latest()->paginate(8);
        $posts = Post::where('user_id', $user->id)->latest()->simplePaginate(8);
        //dd($posts);
        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create(){
        //dd('creando post');
        return view('posts.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        /*Post::create([
            'titulo' => $request -> titulo,
            'descripcion' => $request -> descripcion,
            'imagen' => $request -> imagen,
            'user_id' => auth()->user()->id
        ]);

        //Otra Forma
        /*$post = new Post;
        $post->titulo=$request->titulo;
        $post->descripcion = $request->descripcion;
        $post->imagen = $request->imagen;
        $post->user_id = auth()->user()->id;
        $post->save();*/

        $request->user()->posts()->create([
            'titulo'=>$request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }

    /*public function show(User $user, Post $post){
        return view('posts.show', [
            'post'=>$post,
            'user'=>$user
        ]);
    }*/
    /*public function show($username, $postId){
        // Obtener el usuario por su nombre de usuario
        $user = User::where('username', $username)->firstOrFail();

        // Obtener el post por su ID y perteneciente al usuario
        $post = Post::where('id', $postId)->where('user_id', $user->id)->first();

        // Verificar si el post existe y pertenece al usuario
        if (!$post) {
            // Si el post no existe o no pertenece al usuario, redirigir a una página de error o a la página principal del usuario al que sigue
            return redirect()->route('posts.index', $username);
        }

        // Retornar la vista con el post y el usuario
        return view('posts.show', compact('post', 'user'));
    }*/

    public function show($username, $postId){
        // Obtener el usuario por su nombre de usuario
        $user = User::where('username', $username)->firstOrFail();

        // Obtener el post por su ID y perteneciente al usuario
        $post = Post::where('id', $postId)->where('user_id', $user->id)->first();

        // Verificar si el post existe y pertenece al usuario
        if (!$post) {
            // Si el post no existe o no pertenece al usuario, redirigir a la página principal (home)
            return redirect()->route('home');
        }

        // Retornar la vista con el post y el usuario
        return view('posts.show', compact('post', 'user'));
    }


    public function destroy(Post $post){
        //dd('Eliminando', $post->id);
        /*if($post->user_id === auth()->user()->id){
            dd('Si es la misma persona');
        }else{
            dd('No es la misma persona');
        }*/

        $this->authorize('delete', $post);
        $post->delete();

        //Eliminar la imagen
        $imagen_path = public_path('uploads/' .$post->imagen);

        if(File::exists($imagen_path)){
            unlink($imagen_path);
        }
        return redirect()->route('posts.index', auth()->user()->username);
    }
}


