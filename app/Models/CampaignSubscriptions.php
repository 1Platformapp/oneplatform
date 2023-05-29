<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CampaignSubscriptions extends Authenticatable

{

        protected $table = 'stripe_subscriptions';
        /**

         * @var array

         */



        /**

         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo

         */

        

        public function campaign()

        {

            return $this->belongsTo( userCampaign::class );

        }



        /**

         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo

         */



        /**

         * @return \Illuminate\Database\Eloquent\Relations\HasMany

         */




        /**

         * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany

         */




        /**

         * @param $query

         */




        /**

         * @return bool|null

         * @throws \Exception

         */


    }

