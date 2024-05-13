<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use \App\Models\Fichero;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FicheroController extends Controller
{
    public function index()
    {     
        $ficheros=Fichero::all();
        return view("ficheroViews.index",["data"=>$ficheros]);
    }
    public function showFormFichero(): View
    {
        return view("ficheroViews.create");
    }
    public function store(Request $request)
    {
        $validacion = Validator::make($request->all(), [
            'fichero'=> 'max:10240',
        ]);
        
        if ($validacion->fails()) {
            return ('Supera el tamaño máximo permitido.'); 
        } else {
            $uploadedFile = $request->file('fichero');
            $fileName = $uploadedFile->getClientOriginalName();
            $randomName=Str::random(10).substr($fileName,-4);
    
            Fichero::create([
                'nombre'=>$randomName,
                'tipoFichero'=>$uploadedFile->getClientMimeType(),
                'userId'=>Auth::user()->id,
            ]);
            
            Storage::putFileAs('public/files', $uploadedFile,$randomName);
    
            return redirect()->route('volver.index');
        }
    }

    public function destroy(string $id){
        $fichero=Fichero::find($id);

        if($fichero!=null && Storage::disk('public')->exists('files/'.$fichero->nombre)){
            Storage::disk('public')->delete('files/'.$fichero->nombre);
            $fichero->delete();
            return redirect()->route('listar.ficheros')->with('success','Fichero eliminado correctamente.');
        }else{
            return redirect()->route('listar.ficheros')->with('error','Fichero no encontrado.');
        }

    }
}