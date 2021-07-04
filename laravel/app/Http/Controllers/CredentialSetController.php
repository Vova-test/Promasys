<?php

namespace App\Http\Controllers;

use App\Services\CredentialSetService;
use App\Http\Requests\CredentialSetRequest;

class CredentialSetController extends Controller
{
    public function __construct(CredentialSetService $service)
    {
        $this->service = $service;
    }

    public function getCredentials(string $project)
    {
        $credentialSets = $this->service
                            ->getCredentials($project);

        return response()->json(['credentialSets' => $credentialSets]);
    }

    public function store(CredentialSetRequest $request)
    {
        $data = [
            'title' => $request->title,
            'credentials' => $request->credentials,
            'project_id' => $request->projectId
        ];
        $stored = $this->service->store($data);

        return response()->json(['stored' => $stored]);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);

        return response()->json(['deleted' => $deleted]);
    }
}
