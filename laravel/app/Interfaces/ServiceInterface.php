<?php

namespace App\Interfaces;

interface ServiceInterface
{
    public function all();
    
    public function delete(string $id);

    public function find(string $id);
}
