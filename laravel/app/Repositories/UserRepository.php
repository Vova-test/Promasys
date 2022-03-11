<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function update($id, array $attributes)
    {
        return $this->model
            ->find($id)
            ->update($attributes);
    }
}
