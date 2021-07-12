<?php

namespace App\Services;

use App\Repositories\UserProjectRepository;

class UserProjectService extends BaseService
{
    public function __construct(UserProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getSettings(string $projectId)
    {
        $settings = $this->repository
                         ->getSettings($projectId);

        return $settings;
    }
}
