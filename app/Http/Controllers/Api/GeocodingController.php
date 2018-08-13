<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Http\Request;

class GeocodingController extends Controller
{

    public function getAddressByLatLon(Request $request)
    {
        $lat = Input::get('lat');
        $lon = Input::get('lon');
        $transformedResults = [];

        $latLon = doubleval($lat) . ',' . doubleval($lon);
        $geocodeResult = json_decode(self::getGoogleGeocodingApiByLatlng($latLon), true);

        if (!empty($geocodeResult['results'])) {
            foreach ($geocodeResult['results'] as $result) {
                $transformedResult = self::transform($result);
                if (!empty($transformedResult))
                    $transformedResults[] = $transformedResult;
            }
        }
        else{
            $transformedResults = $geocodeResult;
        }

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'result' => $transformedResults
        ]);

    }

    public static function getGoogleGeocodingApiByLatlng($latlng, $curl = false)
    {
        $googlePlacesApiKey= env('APP_GOOGLE_CODE');
        $requestFields = [
            'latlng' => urlencode($latlng),
            'key' => 'AIzaSyAypx0qzFoMkg2KTmGHhJDmg-nLtGeR7ZY'
        ];
        $requestFieldsString = '';
        foreach ($requestFields as $key => $value) {
            $requestFieldsString .= $key . '=' . $value . '&';
        }
        rtrim($requestFieldsString, '&');

        return self::getGoogleGeocodingApi($requestFieldsString, $curl);
    }

    public static function getGoogleGeocodingApi($requestFieldsString, $curl = false)
    {
        $googleGeocodeApiUrl = 'https://maps.googleapis.com/maps/api/geocode/json?';
        if ($curl) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $googleGeocodeApiUrl .$requestFieldsString);
            $result = curl_exec($ch);
            curl_close($ch);
        } else
            $result = file_get_contents($googleGeocodeApiUrl . $requestFieldsString);

        return $result;
    }

    public static function getPlaceDetailFromGooglePlacesApi($placeId)
    {
        $googlePlacesApiKey= config('app.google_api_key');
        $googlePlacesApiParams = [
            'key' => 'key=' .$googlePlacesApiKey,
            'placeid' => 'placeid=' . $placeId
        ];

        $googlePlacesApiUrl = "https://maps.googleapis.com/maps/api/place/details/json?" . join('&', $googlePlacesApiParams);

        return file_get_contents($googlePlacesApiUrl);
    }

    public static function transform($geocodeResult)
    {
        $transformedResult = [];
        $transformedResult['id'] = "";
        $transformedResult['primary'] = true;
        $transformedResult['zip_code'] = "Unknown";
        $transformedResult['district'] = "Unknown";
        $transformedResult['state_province'] = "Unknown";
        $transformedResult['country'] = "Unknown";
        $transformedResult['street'] = "Unknown";
        $transformedResult['lat'] = "";
        $transformedResult['lon'] = "";
        $transformedResult['phone_number'] = "";
        $transformedResult['name'] = "Unknown";
        $transformedResult['picture'] = "";
        if (isset($geocodeResult['address_components'])) {
            $addressComponents = $geocodeResult['address_components'];
            $transformedResult['street'] = '';
            $streetSuffix = [];

            foreach ($addressComponents as $addressComponent) {
                if (in_array("postal_code", $addressComponent['types'])) {
                    $transformedResult['zip_code'] = $addressComponent['long_name'];
                } elseif (in_array("political", $addressComponent['types'])) {
                    if (in_array("country", $addressComponent['types'])) {
                        $transformedResult['country'] = $addressComponent['long_name'];
                    } elseif (in_array("administrative_area_level_1", $addressComponent['types'])) {
                        $transformedResult['state_province'] = $addressComponent['long_name'];
                    } elseif (in_array("administrative_area_level_2", $addressComponent['types'])) {
                        $transformedResult['district'] = $addressComponent['long_name'];
                    } elseif (in_array("sublocality", $addressComponent['types'])) {
                        $streetSuffix[] = $addressComponent['long_name'];
                    }
                } else {
                    $transformedResult['street'] .= $addressComponent['long_name'] . ', ';
                }
            }
            if (count($streetSuffix) > 0)
                $transformedResult['street'] .= join(', ', $streetSuffix);
            if (substr($transformedResult['street'], strlen($transformedResult['street']) - 3) == ', ') {
                $transformedResult['street'] = substr($transformedResult['street'], 0, strlen($transformedResult['street']) - 3);
            }
        }

        if (isset($geocodeResult['geometry'])) {
            if (isset($geocodeResult['geometry']['location'])) {
                $transformedResult['lat'] = $geocodeResult['geometry']['location']['lat'];
                $transformedResult['lon'] = $geocodeResult['geometry']['location']['lng'];
            }
        }

        if (isset($geocodeResult['name']) && isset($geocodeResult['vicinity'])) {
            $primary = true;
            $transformedResult['id'] = $geocodeResult['place_id'];
            $transformedResult['primary'] = $primary;
            $transformedResult['street'] = $geocodeResult['vicinity'];
        }

        if (isset($geocodeResult['international_phone_number'])) {
            $transformedResult['phone_number'] = $geocodeResult['international_phone_number'];
        }

        if (isset($geocodeResult['name'])) {
            $transformedResult['name'] = $geocodeResult['name'];
        }

        if (isset($geocodeResult['icon'])) {
            $transformedResult['picture'] = $geocodeResult['icon'];
        }
        if(isset($geocodeResult['place_id'])){
            $placeDetail = self::getPlaceDetailFromGooglePlacesApi($geocodeResult['place_id']);
            $placeDetail = json_decode($placeDetail, true);
            if(isset($placeDetail['result']['address_components'])){
                $address_components = $placeDetail['result']['address_components'];
                if(is_array($address_components)){
                    foreach ($address_components as $address_component){
                        if(isset($address_component['types']) && ($address_component['types'][0] == 'country')){
                            if(isset($address_component['long_name'])){
                                $transformedResult['country'] = $address_component['long_name'];
                            }
                        }

                        if(isset($address_component['types']) && ($address_component['types'][0] == 'locality')){
                            if(isset($address_component['long_name'])){
                                $transformedResult['state_province'] = $address_component['long_name'];
                            }
                        }

                        if(isset($address_component['types']) &&
                            ($address_component['types'][0] == 'administrative_area_level_1') &&
                            empty($transformedResult['state_province'])){
                            if(isset($address_component['long_name'])){
                                $transformedResult['state_province'] = $address_component['long_name'];
                            }
                        }

                        if(isset($address_component['types']) && ($address_component['types'][0] == 'administrative_area_level_2')){
                            if(isset($address_component['long_name'])){
                                $transformedResult['district'] = $address_component['long_name'];
                            }
                        }
                        if(isset($address_component['types']) && ($address_component['types'][0] == 'route')){
                            if(isset($address_component['long_name'])){
                                $transformedResult['street'] = $address_component['long_name'];
                            }
                        }
                    }
                }
            }

            if(isset($placeDetail['result']['formatted_address'])){
                $transformedResult['street'] = $placeDetail['result']['formatted_address'];
            }

            if(isset($placeDetail['result']['formatted_phone_number'])){
                $transformedResult['phone_number'] = $placeDetail['result']['formatted_phone_number'];
            }

            if (isset($placeDetail['result']['icon'])) {
                $transformedResult['picture'] = $placeDetail['result']['icon'];
            }

            if (isset($placeDetail['result']['name'])) {
                $transformedResult['name'] = $placeDetail['result']['name'];
            }

            if (isset($placeDetail['result']['international_phone_number']) && empty($transformedResult['phone_number'])) {
                $transformedResult['phone_number'] = $placeDetail['result']['international_phone_number'];
            }
        }

        return $transformedResult;
    }


}
