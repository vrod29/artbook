<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



use App\Artwork;
use App\User;
use Auth;
use Log;

class ArtController extends Controller
{
    public function upload_art(Request $request)
    {
        if (!empty($request->file('newArt'))) {
            $request->file('newArt')->store('public');

            Log::debug($request->newArt->path());
            Log::debug($request->file('newArt'));

            Log::debug($request->newArt->hashName());

            $artwork = new Artwork;
            $artwork->user_id = Auth::id();
            $artwork->name= $request->artName;
            $artwork->description = $request->artDescription;
            $artwork->image_path = $request->newArt->hashName();
            $artwork->price= $request->artPrice;
            $artwork->save();

            return back();
        }
    }

    public function fillDirectory(){
        $user = User::find(Auth::id());
        $artwork = Artwork::where('user_id', '=', Auth::id())->get();
        $data = [
            'artwork' => $artwork
        ];
        return view('directory')->with($data);
    }
}
