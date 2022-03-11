<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use App\Services\UserProjectService;
use App\Services\UserService;
use App\Services\MailService;
use App\Services\User;
use Illuminate\Http\Request;

class ProjectSettingController extends Controller
{
    public function __construct(
        ProjectService $projectService,
        UserProjectService $userProjectService,
        UserService $userService,
        MailService $mailService
    ) {
        $this->projectService = $projectService;
        $this->userProjectService = $userProjectService;
        $this->userService = $userService;
        $this->mailService = $mailService;
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

        return response()->json($settings);
    }

    public function set(Request $request)
    {
        $data = [
            'project_id' => $request->projectId,
            'user_id' => $request->userId,
            'type' => $request->type
        ];

        $stored = $this->userProjectService
                       ->create($data);

        $user = $this->userService
                     ->find($request->userId);
        $project = $this->projectService
                        ->find($request->projectId);

        $this->mailService
             ->send($user->email, 'mail.setting', ['projectName' => $project->name]);

        return response()->json(['stored' => $stored]);
    }

    public function destroy($id)
    {
        $deleted = $this->userProjectService->delete($id);

        return response()->json(['deleted' => $deleted]);
    }
}
