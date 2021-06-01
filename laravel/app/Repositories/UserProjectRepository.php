<?php

namespace App\Repositories;

use App\Models\UserProject;

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
}
