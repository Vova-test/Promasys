<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\UserProject;

class ProjectRepository extends BaseRepository
{
    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    public function getProjects($userId)
    {
        $projects = UserProject::select('user_id','project_id','type')->where('user_id', $userId)
                                                                      ->with('project:id,logo,name,description')
                                                                      ->get()
                                                                      ->toArray();

        return $projects;
    }
}
