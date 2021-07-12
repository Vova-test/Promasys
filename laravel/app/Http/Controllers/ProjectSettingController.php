<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use App\Services\UserProjectService;
use Illuminate\Http\Request;

class ProjectSettingController extends Controller
{
    public function __construct(ProjectService $projectService, UserProjectService $userProjectService)
    {
        $this->projectService = $projectService;
        $this->userProjectService = $userProjectService;
    }

    public function index($id)
    {
        $name = $this->projectService
                     ->getProjectName($id);

        $project = [
            'id' => $id,
            'name' => $name
        ];

        return view('settings', compact('project'));
    }

    public function getSettings($projectId)
    {
        $settings = $this->userProjectService
                         ->getSettings($projectId);

        $settings['accessArray'] = $this->projectService
                                        ->getAccessArray();

        $userSettings = 'userSettings';
        $users = 'users';

        return response()->json($settings);
    }

    public function store(Request $request)
    {
        //dd($request->except('_token'));
        $data = [
            'project_id' => $request->projectId,
            'user_id' => $request->userId,
            'type' => $request->type
        ];

        $stored = $this->userProjectService->create($data);

        return response()->json(['stored' => $stored]);
    }

    public function destroy($id)
    {
        $deleted = $this->userProjectService->delete($id);

        return response()->json(['deleted' => $deleted]);
    }
}
