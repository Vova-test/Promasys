<?php

namespace App\Http\Controllers;

use App\Services\CredentialSetService;
use App\Http\Requests\CredentialSetRequest;
use Illuminate\Http\Request;

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
            'name' => $request->name,
            'credentials' => $request->credentials,
            'project_id' => $request->projectId
        ];
        $stored = $this->service->create($data);

        return response()->json(['stored' => $stored]);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);

        return response()->json(['deleted' => $deleted]);
    }
}
