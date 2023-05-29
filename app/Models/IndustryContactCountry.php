<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class IndustryContactCountry extends Authenticatable

{

    protected $table = 'industry_contact_countries';

    /**

     * The attributes that are mass assignable.

     * @var array

     */

    protected $fillable = [  ];



    /**

     * The attributes excluded from the model's JSON form.

     * @var array

     */

    protected $hidden = [ ];



    /**

     * @return \Illuminate\Database\Eloquent\Relations\belongsTo

     */

    public function region()

    {

        return $this->belongsTo( IndustryContactRegion::class, 'country_id', 'id' );

    }

}

