<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

/**
 * Class WeatherController
 * @package App\Http\API\v1\Controllers
 */
class WeatherController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed|\Symfony\Component\HttpFoundation\ParameterBag|null
     */
    public function getWeather(Request $request)
    {
        // Get user
        $token = $request->input('token');
        $user = $this->userRepository->findByToken($token);
        if(!$user) {
            return response()->json('Unauthorised.', 401);
        }

        // Init params
        $lat = $request->input('lat');
        $lon = $request->input('lon');
        $url = env('WEATHER_URL').'?lat='.$lat.'&lon='.$lon.'&appid='.env('WEATHER_KEY');

        // Request
        $jsonCacheResponse = Redis::get('weather:' . $user['email']);
        if(!$jsonCacheResponse) {
            $response = Http::get($url);
            $weatherArray = $response->collect()->toArray();
            $weatherArray = ['user' => $user, 'main' => $weatherArray['main']];
            // Redis cache
            Redis::set('weather:' . $user['email'], json_encode($weatherArray), 'EX', 60 * 60 * 12);// 12 hours
        } else {
            // Redis response
            return ($jsonCacheResponse) ? $jsonCacheResponse : response()->json([]);
        }

        // Response
        // TODO: $request->json() gives error
        return json_decode(json_encode($weatherArray));
    }

}
