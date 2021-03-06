<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Http\Resources\Artist as ArtistRes;
use App\Http\Resources\ArtistCollection;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    private static $messages = [
        'required' => 'El campo :attribute es obligatorio.',
        'ciOrPassport.unique' => 'CI o Pasaporte ya existe',
        'max' => 'Número de digitos excedidos',
        'mail.unique' => ':attribute ya existe',
        'email' => ':attribute no válido',
        'boolean' => ':attribute solo puede ser "true" o "false"',
        'numeric' => 'el campo :attribute debe ser un número'
    ];

    //Vamos a hacer controladores, tareas que debe realizar
    public function index(){
        //return response()->json(new ArtistCollection(Artist::paginate()),200); //data + pagination
        //return new ArtistCollection(Artist::paginate()); //data + pagination
        return response()->json(new ArtistCollection(Artist::all()),200);  //no data + metadata
    }

    public function show(Artist $artist){
        //Tiene permiso:
        $this->authorize('view', $artist);
        return response()->json(new ArtistRes($artist),200);
    }

    public function store(Request $request){
        //Tiene permiso:
        $this->authorize('create', Artist::class);

        $request->validate([
            'ciOrPassport' => 'required|string|unique:artists|max:15',
            //'ciOrPassport' => 'required|string|max:15',
            'artisticOrGroupName' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'mail' => 'required|string|unique:artists|email|max:255',
            //'mail' => 'required|string|email|max:255',
            'phone' => 'required|string|max:10',
            'passage' => 'required',
            'instruments' => 'required|string',
            'emergencyPhone' => 'required|string|max:25',
            'emergencyMail' => 'required|string|email|max:255',
            'foodGroup' => 'required|string|max:255',
            'observation' => 'required|string',
        ], self::$messages);

        $artist = Artist::create($request ->all());
        return response() -> json($artist, 201); //codigo 201 correspodnde a create
    }

    public function update(Request $request, Artist $artist){
        //Tiene permiso:
        $this->authorize('update', $artist);

        $request->validate([
            'ciOrPassport' => 'string|max:15', //No lo hago unique porque se compara consigo mismo...
            'artisticOrGroupName' => 'string|max:255',
            'name' => 'string|max:255',
            'lastName' => 'string|max:255',
            'nationality' => 'string|max:255',
            'mail' => 'string|email|max:255',
            'phone' => 'string|max:10',
            'passage' => 'required',
            'instruments' => 'string',
            'emergencyPhone' => 'string|max:25',
            'emergencyMail' => 'string|email|max:255',
            'foodGroup' => 'string|max:255',
            'observation' => 'string',
        ], self::$messages);

        $artist -> update($request->all());
        return response() -> json($artist, 200); //codigo 200 correspodnde a modificacion exitosa
    }

    public function delete(Request $request, Artist $artist){
        //Tiene permiso:
        $this->authorize('delete', $artist);
        $artist -> delete();
        return response() -> json(null, 204); //codigo 204 correspodnde a not found
    }

}
