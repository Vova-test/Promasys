<?php

namespace App\Http\Controllers;

use App\Services\CredentialSetService;
use Illuminate\Http\Request;

class CredentialSetController extends Controller
{
    public function __construct(CredentialSetService $service)
    {
        $this->service = $service;
    }
    public function index()
    {

    }

    public function show()
    {

    }

    public function update()
    {

    }

    public function create()
    {

    }

    public function delete()
    {

    }
}
