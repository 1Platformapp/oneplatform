<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SkillManagementPlanTask extends Authenticatable
{

    public function managementPlanTask()
    {
        return $this->belongsTo(ManagementPlanTask::class);
    }

}
