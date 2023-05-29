<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CampaignPerks extends Authenticatable

{

        protected $table = 'campaign_perks';
        /**

         * @var array

         */



        /**

         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo

         */

        public function user()

        {

            return $this->belongsTo( User::class );

        }

        public function campaign()

        {

            return $this->belongsTo( UserCampaign::class );

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

        public function crowdfundBasketItems()

        {

            return $this->hasMany( CrowdfundBasket::class, 'bonus_id' );

        }

        public function crowdfundItems()

        {

            return $this->hasMany( CrowdfundBasket::class, 'source_table_id' );

        }

    }

