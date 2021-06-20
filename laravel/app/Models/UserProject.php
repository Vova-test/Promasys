<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\UsesUuid;

class UserProject extends Model
{
    use SoftDeletes;
    use UsesUuid;

    const PROJECT_ACCESS_NAME = [
        '1' => 'general access',
        '2' => 'extended access',
        '3' => 'You are owner'
    ];

    protected $fillable = [
        'project_id',
        'user_id',
        'type'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getAccessArray() {
        return self::PROJECT_ACCESS_NAME;
    }
}
