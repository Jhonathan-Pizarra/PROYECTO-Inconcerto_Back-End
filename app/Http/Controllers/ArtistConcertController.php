<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Concert;
use App\Http\Resources\Artist as ArtistConcertRes;
use App\Http\Resources\ArtistCollection;
use Illuminate\Http\Request;

class ArtistConcertController extends Controller
{
    private static $messages = [
        'required' => 'El campo :attribute es obligatorio.',
    ];

    public function index(Concert $concert){
        return response()->json(new ArtistCollection($concert->artists),200);
    }

    public function show(Concert $concert, Artist $artist){
        $concertArtist = $concert->artists()->where('id', $artist->id)->firstOrFail();
        return response()->json($concertArtist, 200);
    }

    public function store(Request $request){

        $request->validate([
            'artist_id' => 'exists:artists,id',
            'concert_id' => 'exists:concerts,id',
        ], self::$messages);

        $concert = Concert::findOrFail($request->concert_id);
        $concert->artists()->attach($request->artist_id);
        return response()->json($concert->artists, 201);
    }

//    public function update(Request $request, Concert $concert,  Artist $artist){
//
//        /*
//        $request->validate([
//            'artist_id' => 'unique:artists|exists:artists,id',
//            'concert_id' => 'unique:artists|exists:concerts,id',
//        ], self::$messages);
//
//        $artist = $concert->artists()->where('id', $artist->id)->firstOrFail();
//        $artist -> update($request->all());
//        return response() -> json($artist, 200); //codigo 200 correspodnde a modificacion exitosa
//        */
//        //Tiene permiso:
//        $this->authorize('update', $artist);
//
//        $request->validate([
//            'ciOrPassport' => 'string|max:15',
//            'artisticOrGroupName' => 'string|max:255',
//            'name' => 'string|max:255',
//            'lastName' => 'string|max:255',
//            'nationality' => 'string|max:255',
//            'mail' => 'string|email|max:255',
//            'phone' => 'string|max:10',
//            'passage' => 'required',
//            'instruments' => 'string',
//            'emergencyPhone' => 'string|max:25',
//            'emergencyMail' => 'string|email|max:255',
//            'foodGroup' => 'string|max:255',
//            'observation' => 'string',
//        ], self::$messages);
//
//        $artist -> update($request->all());
//        return response() -> json($artist, 200); //
//    }

    public function delete(Request $request, Concert $concert, Artist $artist){

        $concert = Concert::findOrFail($concert->id);
        $concert->artists()->detach($artist->id);
        return response() -> json(null, 204); //codigo 204 correspodnde a not found
    }

}
