<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Concerns\UsesUuid;

class CredentialSet extends Model
{
    use SoftDeletes;
    use UsesUuid;

    protected $guarded = [];
}
