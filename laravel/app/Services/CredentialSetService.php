<?php

namespace App\Services;

use App\Repositories\CredentialSetRepository;
use App\Repositories\UserProjectRepository;
use App\Services\EncryptService;
use Auth;

class CredentialSetService extends BaseService
{
	public function __construct(
	    CredentialSetRepository $repository,
        UserProjectRepository $userProjectRepository
    )
    {
        $this->repository = $repository;
        $this->userProjectRepository = $userProjectRepository;
    }

    public function getCredentials(string $projectId)
    {
        $credentials = $this->repository->getCredentials($projectId);

        return $credentials;

        /*$encryptKey = $this->getPassword($projectId);

        foreach ($credentials as $value) {
            $value['credential'] = EncryptService::decryptValue($encryptKey, $value['credential']);
        }
        dd($credentials);*/
        //EncryptService::decryptValue($password, $value);
    }

    public function getPassword($projectId)
    {
        $encryptKey = $this->userProjectRepository
                           ->getEncryptKey($projectId);

        return $encryptKey;
    }
}
