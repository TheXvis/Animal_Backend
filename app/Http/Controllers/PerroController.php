<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerroRequest;
use App\Models\Perromodel;
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
     
    public function perroAleatorio(){
        $response = Http::get('https://dog.ceo/api/breeds/image/random');

        if($response->successful()){
            return response()->json($response->json());
        }
        return response()->json(['error' => 'No se pudo obtener la imagen'], 500);
    }
}
