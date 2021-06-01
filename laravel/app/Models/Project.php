<?php

namespace App\Models;

use App\Model\CredentialSet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\UsesUuid;

class Project extends Model
{
    use SoftDeletes;
    use UsesUuid;

    protected $fillable = [
        'name',
        'logo',
        'description'
    ];

    public function userProject()
    {
        return $this->hasMany(UserProject::class);
    }

    public function credentialSet()
    {
        return $this->hasMany(CredentialSet::class);
    }
}
