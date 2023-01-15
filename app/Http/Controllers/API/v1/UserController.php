<?php

namespace App\Http\Controllers\API\v1;


use App\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

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
            // TODO: use Sanctum for tokens and fix SPA cors to stay on same page here

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
