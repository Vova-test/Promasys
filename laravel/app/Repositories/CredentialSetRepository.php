<?php

namespace App\Repositories;

use App\Models\CredentialSet;

class CredentialSetRepository extends BaseRepository
{
    public function __construct(CredentialSet $model)
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
