<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    public function __construct(ProjectService $service)
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
