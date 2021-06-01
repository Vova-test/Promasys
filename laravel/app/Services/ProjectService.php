<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Repositories\UserProjectRepository;
use App\Repositories\CredentialSetRepository;
use Auth;

class ProjectService extends BaseService
{
	public function __construct(
	    ProjectRepository $project,
        UserProjectRepository $userProject,
        CredentialSetRepository $credentialSet
    ) {
        $this->project = $project;
        $this->userProject = $userProject;
        $this->credentialSet = $credentialSet;
    }

    public function getProjects()
    {
        $userId = Auth::id();
        return $this->project->getProjects($userId);
    }

    public function destroy($projectId)
    {
        $project = $this->project->delete($projectId);

        if ($project) {
            $this->userProject->destroy($projectId);
            $this->credentialSet->destroy($projectId);
        }

        return $project ;
    }

    public function update($id, array $attributes)
    {
        return $this->project->update($id, $attributes);
    }

    public function store(array $attributes)
    {
        $project = $this->project->create($attributes);

        if (isset($project->id)) {
            $userId = Auth::id();

            $userProjectAttributes = [
                'user_id' => $userId,
                'project_id' => $project->id,
                'type' => 1
            ];

            $this->userProject->create($userProjectAttributes);
        }

        return $project;
    }
}
