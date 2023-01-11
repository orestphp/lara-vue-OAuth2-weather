<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * @param User $user
     * @return User $user
     */
    public function createUpdateViaGoogle(User $user): User
    {
        // Check if User exists
        $googleUser = User::where('email', $user->getEmail())->first();

        if(!$googleUser) {

            $saveUser = User::updateOrCreate([
                'google_id' => $user->getId(),
            ],[
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => Hash::make($user->getName().'@'.$user->getId()),
                'token' => $user->token,
                'refresh_token' => $user->refreshToken,
                'nickname' => $user->getNickname(),
                'avatar' => $user->getAvatar(),
                'expires_in' => $user->expiresIn,
            ]);
        } else {

            $saveUser = User::where('email',  $user->getEmail())->update([
                'google_id' => $user->getId(),
            ]);
            $saveUser = User::where('email', $user->getEmail())->first();
        }

        Auth::loginUsingId($saveUser->id);

        return $saveUser;
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        return $this->model->where('id', $id)
            ->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function find($id): ?Model
    {
        if (null == $user = $this->model->find($id)) {
            throw new ModelNotFoundException("User not found");
        }

        return $user;
    }
}
