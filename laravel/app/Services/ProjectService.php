<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Repositories\UserProjectRepository;
use App\Repositories\CredentialSetRepository;
use Auth;
use Illuminate\Support\Facades\Storage;

class ProjectService extends BaseService
{
    public function __construct(
        ProjectRepository $project,
        UserProjectRepository $userProject,
        CredentialSetRepository $credentialSet
    )
    {
        $this->project = $project;
        $this->repository = $project;
        $this->userProject = $userProject;
        $this->credentialSet = $credentialSet;
    }

    public function getProjects()
    {
        $userId = Auth::id();

        return $this->project->getProjects($userId);
    }

    public function destroy(string $id)
    {
        $logoPath = $this->getLogoPath($id);

        if ($logoPath) {
            $this->deleteImage($logoPath);
        }

        $project = $this->project->delete($id);

        if ($project) {
            $this->userProject->destroy($id);
            $this->credentialSet->destroy($id);
        }

        return $project;
    }

    public function update(string $id, array $attributes)
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
            ];

            $this->userProject->create($userProjectAttributes);
        }

        return $project;
    }

    public function storeImage(object $image, string $logo = null)
    {
        $logoPath = $image->store('logo', 'public');

        if ($logo) {
            $this->deleteImage($logo);
        }

        return $logoPath;
    }

    public function deleteImage(string $logo)
    {
        Storage::disk('public')->delete($logo);
    }

    public function getLogoPath(string $id)
    {
        $project = $this->project
            ->find($id);

        if ($project) {
            return $project->logo;
        }
    }

    public function getAccessArray()
    {
        return $this->userProject
            ->getAccessArray();
    }

    public function getProject(string $projectId)
    {
        $userId = Auth::id();

        return $this->project->getProject($projectId, $userId);
    }
}
