<?php

namespace App\Services;

use App\Repositories\CredentialSetRepository;

class CredentialSetService extends BaseService
{
	public function __construct(CredentialSetRepository $repository)
    {
        $this->repository = $repository;
    }
}
