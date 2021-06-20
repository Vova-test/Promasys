<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\UsesUuid;
use Illuminate\Support\Facades\Crypt;

class CredentialSet extends Model
{
    use SoftDeletes;
    use UsesUuid;

    protected $fillable = [
        'project_id',
        'name',
        'credentials'
    ];

    protected $visible = [
        'id',
        'project_id',
        'name',
        'credentials'
    ];

    public function setCredentialsAttribute($value)
    {
        $this->attributes['credentials'] = Crypt::encryptString($value);
    }

    public function getCredentialsAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}
