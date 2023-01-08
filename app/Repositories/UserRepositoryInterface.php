<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;
    public function create(array  $data);
    public function update(array $data, $id);
    public function delete($id);
    public function find($id): ?Model;
}
