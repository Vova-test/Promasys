<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;

class BaseRepository implements RepositoryInterface
{
    public function find($id)
    {
        return $this->model
                    ->where('id', $id)
                    ->first();
    }

    public function all()
    {
        return $this->model
                    ->get()
                    ->all();
    }

    public function update($id, array $attributes)
    {
        return $this->model
                    ->where('id', $id)
                    ->update($attributes);
    }

    public function delete($id)
    {
        return $this->model
                    ->where('id', $id)
                    ->delete();
    }

    public function create(array $attributes)
    {
        $class = get_class($this->model); 

        $model = new $class();

        return $model->create($attributes);
    }

    public function count()
    {
        return $this->model->count();
    }
}
