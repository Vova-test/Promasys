<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function find($id);

    public function all();

    public function update($id, array $attributes);

    public function delete($id);

    public function create(array $attributes);
}
