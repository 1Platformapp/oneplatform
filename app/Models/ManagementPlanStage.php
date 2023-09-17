<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ManagementPlanStage extends Authenticatable
{
    public function tasks()
    {
        return $this->hasMany(ManagementPlanTask::class, 'stage_id');
    }
}
