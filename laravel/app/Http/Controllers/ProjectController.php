<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    public function test()
    {
        $oldLogoPath = $this->service->getLogoPath('11');
        dd($oldLogoPath);
        return view('projects.test');
    }

    public function index()
    {
        return view('projects.index');
    }

    public function getProjects()
    {
        $userProjects = $this->service
                             ->getProjects();

        $accessArray = $this->service
                            ->getAccessArray();

        return response()->json([
            'userProjects' => $userProjects,
            'accessArray' => $accessArray
        ]);
    }

    public function update($id, ProjectRequest $request)
    {
        $data = $request->except(['_token', 'image']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $oldLogoPath = $this->service
                ->getLogoPath($id);

            $logoPath = $this->service
                ->storeImage($file, $oldLogoPath);

            $data['logo'] = $logoPath;
        }

        $updated = $this->service->update($id, $data);

        return response()->json(['updated' => $updated]);
    }

    public function store(ProjectRequest $request)
    {
        $data = $request->except('_token', 'image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $logoPath = $this->service
                ->storeImage($file);

            $data['logo'] = $logoPath;
        }

        $stored = $this->service->store($data);

        return response()->json(['stored' => $stored]);
    }

    public function destroy($id)
    {
        $deleted = $this->service->destroy($id);

        return response()->json(['deleted' => $deleted]);
    }

    public function show($id)
    {
        dd($id);
    }

    public function edit()
    {

    }
}
