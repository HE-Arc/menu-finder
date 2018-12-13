<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $restaurant = !\Auth::user()->restaurants->isEmpty() ? \Auth::user()->restaurants[0] : new Restaurant();
      #var_dump($restaurant->name);
      return view('restaurant.index')
          ->with(['restaurant' => $restaurant]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $restaurant = !\Auth::user()->restaurants->isEmpty() ? \Auth::user()->restaurants[0] : new Restaurant();
      #var_dump($restaurant->name);
      return view('restaurant.create')
          ->with(['restaurant' => $restaurant]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required|integer',
            'description' => 'required',

        ]);

        $restaurant = null;
        try {
            $restaurant = Restaurant::create([
                'name' => $request->name,
                #'location' => $request->price,
                'address' => $request->address,
                'city' => $request->city,
                'zip' => $request->zip,
                'user_id' => \Auth::user()->id,
                'description' => $request->description,
                'active' => true,
                'website' => $request->website,

            ]);

            $base64_image = $request->input('avatar');
            $img =  self::uploadBase64Avatar($base64_image, $restaurant);

            $restaurant->update([
              'avatar' => $img,
            ]);

            $message = 'The Restaurant ' . $restaurant->name . ' has been created!';
            return redirect()
                ->action('RestaurantController@index')
                ->with(['succesMessage' => $message,
                ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($restaurant != null) {
                Restaurant::find($restaurant->id)->delete();
            }
            $errorMessage = $exception->getMessage();
            //$errorMessage = 'There was an error please try again';
            return redirect()
                ->action('RestaurantController@create')
                ->withInput()
                ->withErrors(['errorInfo' => $errorMessage]);
        }


    }

    public static function uploadBase64Avatar($base64 = '', $restaurant)
    {
//        var_dump('In here');
        if (empty($base64)) {
          return 'default.jpg';
        }

        try {
            $image = Image::make($base64)->resize(300, 300)->encode('jpg');
        }  catch(\Exception $e) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'avatar' => ['Image invalide'],
            ]);
            throw $error;
        }

        if($image->filesize() <= 2000) {
            // $mimes = new \Mimey\MimeTypes;
            //
            // if(!empty($user)) {
            //     $basename = str_slug($user->name) . '-' . $user->id;
            // } else {
            //     $tempname = tempnam(public_path('img/avatar/'), 'avatar_');
            //     $basename = basename($tempname);
            //     @unlink($tempname);
            // }
            //
            // $name = $basename . '.' . $mimes->getExtension($image->mime());
            // $path = public_path('img/avatar/' . $name);
            // $image->save($path);

            // return $name;
            $path = $restaurant->id . '.jpg';
            Storage::put('avatars/' . $path, $image->__toString());
            return $path;
        } else {
            $error = \Illuminate\Validation\ValidationExx§ception::withMessages([
                'avatar' => ['Image trop lourde.'],
            ]);
            throw $error;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {



      $this->validate($request, [
          'name' => 'required',
          'address' => 'required',
          'city' => 'required',
          'zip' => 'required|integer',
          'description' => 'required',

      ]);

      $restaurant = null;
      try {


          $restaurant = Restaurant::find($id);
          $restaurant->update([
              'name' => $request->name,
              #'location' => $request->price,
              'address' => $request->address,
              'city' => $request->city,
              'zip' => $request->zip,
              #'avatar' => $request->avatar,
              'description' => $request->description,
              'website' => $request->website,
              'active' => true,
          ]);

          $base64_image = $request->input('avatar');

          $img =  self::uploadBase64Avatar($base64_image, $restaurant);

          $restaurant->update([
            'avatar' => $img,
          ]);
          $message = 'The Restaurant ' . $restaurant->name . ' has been updated!';
          return redirect()
              ->action('RestaurantController@create')
              ->with(['succesMessage' => $message,
              ]);
      } catch (\Illuminate\Database\QueryException $exception) {

          $errorMessage = $exception->getMessage();
          //$errorMessage = 'There was an error please try again';
          return redirect()
              ->action('RestaurantController@create')
              ->withInput()
              ->withErrors(['errorInfo' => $errorMessage]);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
