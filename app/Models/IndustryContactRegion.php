<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class IndustryContactRegion extends Authenticatable

{

    protected $table = 'industry_contact_regions';
    
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

     * @return \Illuminate\Database\Eloquent\Relations\hasMany

     */

    public function cities()

    {

        return $this->hasMany( IndustryContactCity::class, 'group_id', 'region_id' );

    }

    /**

     * @return \Illuminate\Database\Eloquent\Relations\HasMany

     */

    public function industryContacts()

    {

        return $this->hasMany( IndustryContact::class, 'region_id', 'region_id' );

    }

    public function country()

    {

        return $this->hasOne( IndustryContactCountry::class, 'id', 'country_id');

    }
}

