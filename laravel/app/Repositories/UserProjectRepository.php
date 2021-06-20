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

    public function getAccessArray() {
        return $this->model
                    ->getAccessArray();
    }

    public function getEncryptKey( string $projectId)
    {
        $encryptKey = $this->model
                           ->where('project_id', $projectId)
                           ->where('type', 3)
                           ->firstOrFail()
                           ->user
                           ->credential_key;

        return $encryptKey;
    }
}
