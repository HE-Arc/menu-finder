<?php

namespace App\Http\Controllers;

use Http\Client\HttpClient;
use Illuminate\Http\Request;
use App\Restaurant;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Geocoder\Query\GeocodeQuery;
use Phaza\LaravelPostgis\Geometries\Point;

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
        $restaurant = !empty(\Auth::user()->restaurant) ? \Auth::user()->restaurant : new Restaurant();

        return view('restaurant.index')
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
            'name' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|integer',
            'description' => 'required|string',
            'website' => 'sometimes|string'
        ]);

        $location = $this->getCoordinateFromAddress($request->address." ".$request->zip." ".$request->city);

        if (is_null($location)) {
            $errorMessage = 'Location not found please verify the address';
            return redirect()
                ->action('RestaurantController@index')
                ->withInput()
                ->withErrors(['errorInfo' => $errorMessage]);
        }

        $restaurant = null;
        try {
            $restaurant = Restaurant::create([
                'name' => $request->name,
                'location' => new Point($location->getLatitude(), $location->getLongitude()),
                'address' => $request->address,
                'city' => $request->city,
                'zip' => $request->zip,
                'user_id' => \Auth::user()->id,
                'description' => $request->description,
                'active' => true,
                'website' => $request->website,

            ]);

            $base64_image = $request->input('avatar');
            $img = self::uploadBase64Avatar($restaurant, $base64_image);

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
            //$errorMessage = $exception->getMessage();
            $errorMessage = 'There was an error please try again';
            return redirect()
                ->action('RestaurantController@index')
                ->withInput()
                ->withErrors(['errorInfo' => $errorMessage]);
        }
    }

    public static function uploadBase64Avatar($restaurant, $base64 = '')
    {
        if (empty($base64)) {
            return 'default.jpg';
        }

        try {
            $image = Image::make($base64)->resize(300, 300)->encode('jpg');
        } catch (\Exception $e) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'avatar' => ['Invalid image'],
            ]);
            throw $error;
        }

        if ($image->filesize() <= 2000) {
            $path = $restaurant->id . '.jpg';
            Storage::disk('public')->put('avatars/' . $path, $image->__toString());
            return $path;
        } else {
            $error = \Illuminate\Validation\ValidationExx§ception::withMessages([
                'avatar' => ['Image is too large.'],
            ]);
            throw $error;
        }
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
        $currentUser = \Auth::user();
        $userRestaurant = $currentUser->restaurant;
        $restaurant = Restaurant::find($id);
        if ($userRestaurant != $restaurant) {
            $errorMessage = 'You cannot delete a menu that don\'t belong to you';
            return redirect()
                ->action('RestaurantController@index')
                ->withErrors($errorMessage);
        }

        $this->validate($request, [
          'name' => 'required|string',
          'address' => 'required|string',
          'city' => 'required|string',
          'zip' => 'required|integer',
          'description' => 'required|string',
          'website' => 'sometimes|string'
        ]);

        $location = $this->getCoordinateFromAddress($request->address." ".$request->zip." ".$request->city);

        if (is_null($location)) {
            $errorMessage = 'Location not found please verify the address';
            return redirect()
                ->action('RestaurantController@index')
                ->withInput()
                ->withErrors(['errorInfo' => $errorMessage]);
        }

        try {
            $restaurant->update([
              'name' => $request->name,
              'location' => new Point($location->getLatitude(), $location->getLongitude()),
              'address' => $request->address,
              'city' => $request->city,
              'zip' => $request->zip,
              'description' => $request->description,
              'website' => $request->website,
              'active' => true,
            ]);

            $base64_image = $request->input('avatar');

            $img = self::uploadBase64Avatar($restaurant, $base64_image);

            $restaurant->update([
              'avatar' => $img,
            ]);
            $message = 'The Restaurant ' . $restaurant->name . ' has been updated!';
            return redirect()
              ->action('RestaurantController@index')
              ->with(['succesMessage' => $message,
              ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            //$errorMessage = $exception->getMessage();
            $errorMessage = 'There was an error please try again';
            return redirect()
              ->action('RestaurantController@index')
              ->withInput()
              ->withErrors(['errorInfo' => $errorMessage]);
        }
    }
    public function getCoordinateFromAddress($address)
    {
        $httpClient = new \Http\Adapter\Guzzle6\Client();
        $provider = new \Geocoder\Provider\AlgoliaPlaces\AlgoliaPlaces($httpClient, env("ALGOLIA_GEOCODE_API_KEY"), env("ALGOLIA_GEOCODE_APP_ID"));
        $geocoder = new \Geocoder\StatefulGeocoder($provider, 'en');
        $location = $geocoder->geocodeQuery(GeocodeQuery::create($address));

        if ($location->count() > 0) {
            return $location->get(0)->getCoordinates();
        } else {
            return null;
        }
    }
}
