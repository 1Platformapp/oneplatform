<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ManagementPlanTask extends Authenticatable
{
    public function tasks()
    {
        return $this->belongsTo(ManagementPlanStage::class);
    }

    public function skillTask()
    {
        return $this->hasMany(SkillManagementPlanTask::class);
    }
}
