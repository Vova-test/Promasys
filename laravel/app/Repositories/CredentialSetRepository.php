<?php

namespace App\Repositories;

use App\Models\CredentialSet;

class CredentialSetRepository extends BaseRepository
{
    public function __construct(CredentialSet $model)
    {
        $this->model = $model;
    }

    public function getCredentials(string $project)
    {
        $credentials = $this->model
                            ->where('project_id', $project)
                            ->get();

        return $credentials;
    }

    public function destroy($id)
    {
        return $this->model
                    ->where('project_id', $id)
                    ->delete();
    }

    public function update($id, array $attributes)
    {
        return $this->model
                    ->find($id)
                    ->update($attributes);
    }

    public function getUserCredentials(string $userId)
    {
        return $this->model
                    ->where('user_id', $userId)
                    ->get()
                    ->toArray();
    }

    public function updateUserCredentials($userId)
    {
        $credentials = $this->getUserCredentials($userId);

        foreach ($credentials as $credential) {
            $this->model
                 ->find($credential['id'])
                 ->update([
                     'credentials' => $credential['credentials']
                 ]);
        }

        return true;
    }
}
