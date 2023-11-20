<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerroRequest;
use App\Models\Perromodel;
use App\Models\Interaccionmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PerroController extends Controller{
    public function crear(PerroRequest $request)
    {
        $response = Http::get('https://dog.ceo/api/breeds/image/random');

        if ($response->successful()) {
        $perro = new Perromodel;
        $perro->nombre = $request->nombre;
        $perro->edad = $request->edad; 
        $perro->raza = $request->raza;
        $perro->descripcion = $request->descripcion;
        $perro->url = $response->json()['message'];
        $perro->save();

        return response()->json($perro, 201);
        }

        return response()->json(['error' => 'No se puede crear'], 500);
    }

    public function eliminar($id){
        $perro = Perromodel::find($id);

        if($perro){
            $perro->delete();
            return response()->json(['message' => 'Perro eliminado con éxito'], 200);
        }

        return response()->json(['error' => 'Perro no encontrado'], 404);
    }

    public function verPerros(){
        $perros = Perromodel::all();
        return response()->json($perros, 200);
    }

    public function update(Request $request, $id){
    $perro = Perromodel::find($id);
    if ($perro) {
        $perro->nombre = $request->nombre;
        $perro->edad = $request->edad; 
        $perro->raza = $request->raza;
        $perro->descripcion = $request->descripcion;
        $perro->url = $request->url;
        $perro->save();

        return response()->json($perro, 200);
    }

    return response()->json(['error' => 'Perro no encontrado'], 404);
    }
     
    public static function imagenRandom(){
        $response = Http::get('https://dog.ceo/api/breeds/image/random');

        if($response->successful()){
            $data = $response->json();
            return $data['message'];
        }
        return null;
    }

    public function perroRandom(){
        $perro = Perromodel::inRandomOrder()->first(['id', 'nombre']);
        if ($perro) {
            return response()->json($perro);
        }
    
        return response()->json(['error' => 'No hay perros disponibles'], 404);
    }

    public function obtenerCandidatos($id){
    $perros = Perromodel::where('id', '!=', $id)->get(['id', 'nombre']);
    return response()->json($perros);
    }

    public function guardarPreferencias(Request $request, $id){
        try{
        foreach ($request->likes as $like){
        $interaccion = new Interaccionmodel;
        $interaccion->perro_interesado_id = $id;
        $interaccion->perro_candidato_id = $like;
        $interaccion->preferencia = 'like';
        $interaccion->save();
        }
    

        foreach ($request->dislikes as $dislike){
        $interaccion = new Interaccionmodel;
        $interaccion->perro_interesado_id = $id;
        $interaccion->perro_candidato_id = $dislike;
        $interaccion->preferencia = 'dislike';
        $interaccion->save();
        }
        return response()->json(['message' => 'Preferencias guardadas correctamente']);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error al guardar las preferencias: ' . $e->getMessage()], 500);
        }
    }

    public function match($id1, $id2){
        $interaccion1 = Interaccionmodel::where('perro_interesado_id', $id1)->where('perro_candidato_id', $id2)->first();
        $interaccion2 = Interaccionmodel::where('perro_interesado_id', $id2)->where('perro_candidato_id', $id1)->first();

        if ($interaccion1 && $interaccion2){
        return response()->json(['message' => 'hay match']);
        }else {
        return response()->json(['message' => 'No hay match']);
        }
    }

    public function aceptados($id){
    $interacciones = Interaccionmodel::where('perro_interesado_id', $id)->where('preferencia', 'like')->get();
    return response()->json($interacciones);
}

    public function rechazados($id){
    $interacciones = Interaccionmodel::where('perro_interesado_id', $id)->where('preferencia', 'dislike')->get();
    return response()->json($interacciones);
    }
};