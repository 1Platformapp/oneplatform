<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class InternalSubscriptionInvoice extends Authenticatable
{

        /**

         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo

         */

        public function internalSubscription()
        {

            return $this->belongsTo(InternalSubscription::class);

        }

    }
