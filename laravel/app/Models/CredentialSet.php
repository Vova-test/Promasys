<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\UsesUuid;
use Illuminate\Support\Facades\Auth;
use App\Services\EncryptService;

class CredentialSet extends Model
{
    use SoftDeletes;
    use UsesUuid;

    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'credentials'
    ];

    protected $visible = [
        'id',
        'project_id',
        'title',
        'credentials'
    ];

    public function setCredentialsAttribute($value)
    {
        $credentialKey = Auth::user()->credential_key;
        $this->attributes['credentials'] = EncryptService::encryptValue($credentialKey, $value);
    }

    public function getCredentialsAttribute($value)
    {
        $credentialKey = $this->user->credential_key;
        return EncryptService::decryptValue($credentialKey, $value);
    }

    public function user()
    {
        return $this->belongsTo(User::class/*, 'user_id', 'id'*/);
    }
}
