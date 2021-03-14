<?php

namespace App\Services;

use App\Interfaces\ServiceInterface;

class BaseService implements ServiceInterface
{
    public function all()
    {
        return $this->repository->all();
    }

    public function delete(string $id)
    {
        return $this->repository->delete($id);
    }

    public function find(string $id)
    {
        return $this->repository->find($id);
    }

    public function getForAutocomplete(string $query)
    {
        return $this->repository->getForAutocomplete($query);
    }

    public function count()
    {
        return $this->repository->count();
    }

    public function create(array $attributes)
    {
        return $this->repository->create($attributes);
    }
}
