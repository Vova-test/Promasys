<?php

namespace App\Repositories;

use App\Models\UserProject;
use App\Models\User;

class UserProjectRepository extends BaseRepository
{
    public function __construct(UserProject $model)
    {
        $this->model = $model;
    }

    public function destroy($id)
    {
        return $this->model
                    ->where('project_id', $id)
                    ->delete();
    }

    public function getAccessArray() {
        return $this->model
                    ->getAccessArray();
    }

    public function getSettings(string $projectId) {

        $users = $this->model
                      ->rightJoin('users', function($join) use ($projectId)
                      {
                          $join->on('users.id', '=', 'user_projects.user_id')
                               ->where('user_projects.project_id', '=', $projectId)
                               ->whereNull('user_projects.deleted_at');;
                      })
                      ->select('users.id', 'users.name', 'user_projects.type')
                      ->whereNull('type')
                      ->whereNull('users.deleted_at')
                      ->get();

        $userSettings = $this->model
                             ->rightJoin('users', function($join) use ($projectId)
                             {
                                 $join->on('users.id', '=', 'user_projects.user_id')
                                      ->where('user_projects.project_id', '=', $projectId)
                                      ->whereNull('user_projects.deleted_at');;
                             })
                             ->select(
                                 'users.id',
                                 'users.name',
                                 'user_projects.type',
                                 'user_projects.id as userProjectId'
                             )
                             ->where('type', '<', 3)
                             ->whereNull('users.deleted_at')
                             ->get();

        return compact('users', 'userSettings');
    }
}
