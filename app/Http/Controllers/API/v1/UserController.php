<?php

namespace App\Http\Controllers\API\v1;


use App\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();
    }
}
