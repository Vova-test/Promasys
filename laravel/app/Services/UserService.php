<?php

namespace App\Services;

use Auth;
use App\Repositories\UserRepository;

class UserService extends BaseService
{
	public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getId()
    {
    	if (Auth::check()) {
            return Auth::user()->id; 
        }
        return false;
    }
}
