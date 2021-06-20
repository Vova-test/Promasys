<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use App\Services\EncryptService; //**
use App\Services\CredentialSetService; //**
use App\Http\Requests\ProjectRequest;
use Auth;

class ProjectController extends Controller
{
    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

   /* public function test(CredentialSetService $credentialSetService)
    {
        $projectId = '479d241a-4db5-49be-b338-e4f56f16eadc';
        $credentialSetService->getPassword($projectId);
        $userPass = Auth::user()->credential_key;
        $encryptValue = EncryptService::encryptValue($userPass, 'AW4-4-AS');
        $decryptValue = EncryptService::decryptValue($userPass, $encryptValue);
        dd("encryptValue: $encryptValue --- decryptValue: $decryptValue ; ");

    }*/

    public function index()
    {
        return view('index');
    }

    public function getProjects()
    {
        $userProjects = $this->service
                             ->getProjects();

        $accessArray = $this->service
                            ->getAccessArray();

        return response()->json([
            'userProjects' => $userProjects,
            'accessArray' => $accessArray
        ]);
    }

    public function update($id, ProjectRequest $request)
    {
        $data = $request->except(['_token', 'image']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $oldLogoPath = $this->service
                ->getLogoPath($id);

            $logoPath = $this->service
                ->storeImage($file, $oldLogoPath);

            $data['logo'] = $logoPath;
        }

        $updated = $this->service->update($id, $data);

        return response()->json(['updated' => $updated]);
    }

    public function store(ProjectRequest $request)
    {
        $data = $request->except('_token', 'image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $logoPath = $this->service
                ->storeImage($file);

            $data['logo'] = $logoPath;
        }

        $stored = $this->service->store($data);

        return response()->json(['stored' => $stored]);
    }

    public function destroy($id)
    {
        $deleted = $this->service->destroy($id);

        return response()->json(['deleted' => $deleted]);
    }

    public function show($id)
    {
        $userProject = $this->service->getProject($id);

        $project = $userProject['project'];
        $project['type'] = $userProject['type'];

        return view('card', ['project' => $project]);
    }
}
