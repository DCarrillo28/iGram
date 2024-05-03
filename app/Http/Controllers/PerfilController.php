<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        //dd('Aqui se muestra el formulario');
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        //dd('Guardando Cambios');

        //Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required', 'unique:users,username,' .auth()->user()->id,'min:3', 'max:20',
            'not_in:twitter,editar-perfil'],
        ]);

        if($request->imagen){
            $imagen=$request->file('imagen');

            $nombreImagen=Str::uuid() . "." . $imagen->extension();

            $imagenServidor=Image::make($imagen);
            $imagenServidor->fit(1000,1000);
            $imagenPath=public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        //Guardar Cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user() ?? null;
        $usuario->save();

        //Redireccionar al usuario.
        return redirect()->route('posts.index',$usuario->username);
    }
}
