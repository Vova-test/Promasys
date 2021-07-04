<?php

namespace App\Services;

use App\Repositories\CredentialSetRepository;
use Auth;

class CredentialSetService extends BaseService
{
	public function __construct(
	    CredentialSetRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public function getCredentials(string $projectId)
    {
        $credentials = $this->repository
                            ->getCredentials($projectId);

        return $credentials;
    }

    public function store(array $attributes)
    {
        $attributes['user_id'] = Auth::user()->id;

        return $this->repository
                    ->create($attributes);
    }

    public function update(string $id, array $attributes)
    {
        $attributes['user_id'] = Auth::user()->id;

        return $this->repository
                    ->update($id, $attributes);
    }
}
