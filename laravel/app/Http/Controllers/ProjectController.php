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

    public function test()
    {

        $id = 'f5746ec8-5b2f-4d57-817f-71361ded478f';

        dd($this->service->destroy($id ));
        //return view('projects.index');
    }

    public function index()
    {
        return view('projects.index');
    }

    public function getProjects()
    {
        $userProjects = $this->service->getProjects();

        return response()->json(['userProjects' => $userProjects]);
    }

    public function update($id, Request $request)
    {
        $data = $request->except('_token');

        $updated = $this->service->update($id, $data);

        return response()->json(['updated' => $updated]);
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        $stored = $this->service->store($data);

        return response()->json(['stored' => $stored]);
    }

    public function destroy($id)
    {
        $deleted = $this->service->destroy($id);

        return response()->json(['deleted' => $deleted]);
    }

    public function open()
    {

    }

    public function edit()
    {

    }
}
