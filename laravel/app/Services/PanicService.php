<?php

namespace App\Services;

use Auth;
use App\Repositories\UserRepository;
use App\Repositories\CredentialSetRepository;
use App\Repositories\UserProjectRepository;
use Illuminate\Support\Str;
use App\Services\EncryptService;
use Illuminate\Support\Facades\Hash;

class PanicService extends BaseService
{
	public function __construct(
	    UserRepository $user,
        CredentialSetRepository $credentialSet,
        UserProjectRepository $userProject
    ) {
        $this->user = $user;
        $this->credentialSet = $credentialSet;
        $this->userProject = $userProject;
    }

    public function panic()
    {
        $updatePassword = false;

        $userId = Auth::user()->id;
        $newUserPassword = Str::random(16);
        $encryptPassword = EncryptService::encryptPassword($newUserPassword);

        $passwordAttributes = [
            'password' => Hash::make($newUserPassword),
            'credential_key' => $encryptPassword,
        ];

        Auth::user()->credential_key = $encryptPassword;

        $updateCredentials = $this->credentialSet
                                  ->updateUserCredentials($userId);
        $deleteUserSettings = $this->userProject
                                  ->deleteUserSettings($userId);

        if ($updateCredentials) {
            $updatePassword = $this->user->update($userId, $passwordAttributes);
        }

        if ($updatePassword) {
            return  [
                'email' => Auth::user()->email,
                'password' => $newUserPassword
            ];
        }
    }
}
