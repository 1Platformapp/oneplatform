<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserCampaign extends Authenticatable

{

        protected $table = 'user_campaign';
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



        /**

         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo

         */



        /**

         * @return \Illuminate\Database\Eloquent\Relations\HasMany

         */


        public function perks()
        {

            return $this->hasMany(CampaignPerks::class, 'campaign_id')->orderBy('id', 'asc');
        }



        public function checkouts()
        {

            return $this->hasMany(StripeCheckout::class, 'campaign_id');
        }

        public function amountRaised()
        {

            $amountRaised = 0;
            $commonMethods = new \App\Http\Controllers\CommonMethods();

            $crowdfundCheckouts = \App\Models\StripeCheckout::where('campaign_id', $this->id)->where('type', 'crowdfund')->get();

            foreach($crowdfundCheckouts as $checkout){

                $deliveryCost = 0;
                foreach ($checkout->crowdfundCheckoutItems as $checkoutItem) {
                    if($checkoutItem->type == 'bonus'){
                        $deliveryCost += $checkoutItem->delivery_cost;
                    }
                }
                $checkoutAmountDeliveryLess = $checkout->amount - $deliveryCost;
                if($checkout->currency == $this->currency){
                    $amountRaised += $checkoutAmountDeliveryLess;
                }else{
                    $amountRaised += $commonMethods->convert($checkout->currency, $this->currency, $checkoutAmountDeliveryLess);
                }
            }

            return $amountRaised;
        }

        public function daysLeft()
        {

            $daysLeft = ($this->duration + $this->extend_duration) - ($this->created_at->diffInDays());
            return $daysLeft < 0 ? 0 : $daysLeft;
        }


        public function willExpireOn()
        {

            $duration = (int) $this->duration + (int) $this->extend_duration;
            $expire = date('Y-m-d', strtotime($this->created_at . ' +'.$duration.' days'));
            return $expire;
        }

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

