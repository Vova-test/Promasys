<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        return view('index');
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

        $updated = $this->service
                        ->update($id, $data);

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

        $stored = $this->service
                       ->store($data);

        return response()->json(['stored' => $stored]);
    }

    public function destroy($id)
    {
        $deleted = $this->service
                        ->destroy($id);

        return response()->json(['deleted' => $deleted]);
    }

    public function show($id)
    {
        $userProject = $this->service
                            ->getProject($id);

        $project = $userProject['project'];
        $project['type'] = $userProject['type'];

        return view('card', ['project' => $project]);
    }
}
