<?php

namespace App\Http\Controllers\API\v1;

use App\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class UserController
 * @package App\Http\Controllers\API\v1
 */
class UserController extends Controller
{
    private $userRepository;

    const OAUTH_PROVIDER = 'google';

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginWithGoogle()
    {
        return response()->json([
            'url' => Socialite::driver(self::OAUTH_PROVIDER)->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Throwable
     */
    public function callbackFromGoogle()
    {
        try {
            $googleUser = Socialite::driver(self::OAUTH_PROVIDER)->stateless()->user();
            $this->userRepository->createUpdateViaGoogle($googleUser);

            // Response
            return view('index')->with('token', $googleUser->token);
            // TODO: implement Sanctum for tokens and fix SPA cors to stay on same page here

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function getUserByToken($token)
    {
        $user = $this->userRepository->findByToken($token);
        if(!$user) {
            return response('Unauthenticated.', 401);
        }
        $user = $this->userRepository->checkProviderAuth($user);
        // Response
        return response()->json($user);
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function deleteUser($token)
    {
        $user = $this->userRepository->findByToken($token);
        if(!$user) {
            return response('Unauthenticated.', 401);
        }
        $this->userRepository->delete($user->id);
        // Response
        return response()->json('success');
    }
}
