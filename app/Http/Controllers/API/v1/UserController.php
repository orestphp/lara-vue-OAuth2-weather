<?php

namespace App\Http\Controllers\API\v1;


use App\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    private $userRepository;
    const OAUTH_PROVIDER = 'google';

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginWithGoogle()
    {
        return Socialite::driver(self::OAUTH_PROVIDER)->stateless()->redirect();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function callbackFromGoogle()
    {
        try {
            $googleUser = Socialite::driver(self::OAUTH_PROVIDER)->stateless()->user();
            $user = $this->userRepository->createUpdateViaGoogle($googleUser);

            // Response
            return response()->json([
                'token' => $user->token,
                'refreshToken' => $user->refreshToken,
                'expiresAt' => $user->expiresAt,
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
