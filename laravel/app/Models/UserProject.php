<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\UsesUuid;

class UserProject extends Model
{
    use SoftDeletes;
    use UsesUuid;

    protected $fillable = [
        'project_id', 'user_id', 'type'
    ];
}
