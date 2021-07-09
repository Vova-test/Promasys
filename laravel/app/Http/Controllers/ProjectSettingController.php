<?php

namespace App\Http\Controllers;

use App\Services\CredentialSetService;
use Illuminate\Http\Request;

class ProjectSettingController extends Controller
{
    public function __construct()
    {
    }

    public function index($project)
    {
        return view('settings');
    }

    public function getSettings()
    {

    }

    public function store()
    {
        dd(123);
    }

    public function destroy()
    {

    }
}
