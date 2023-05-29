<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class IndustryContactCity extends Authenticatable

{

    protected $table = 'industry_contact_cities';

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

        return $this->belongsTo( IndustryContactRegion::class, 'region_id', 'group_id' );

    }

    /**

     * @return \Illuminate\Database\Eloquent\Relations\HasMany

     */

    public function industryContacts()

    {

        return $this->hasMany( IndustryContact::class, 'city_id', 'city_id' );

    }

}

