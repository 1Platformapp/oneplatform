<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class IndustryContact extends Authenticatable

{

    protected $table = 'industry_contacts';

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

        return $this->belongsTo( IndustryContactRegion::class, 'region_id', 'region_id' );

    }

    public function city()

    {
        $city = \App\Models\IndustryContactCity::where('city_id', $this->city_id)->first();
        if($city){
            return $city;
        }

        return null;
    }

    /**

     * @return \Illuminate\Database\Eloquent\Relations\belongsTo

     */

    public function category()

    {

        $category = \App\Models\IndustryContactCategory::where('lookup_id', $this->category_id)->first();
        if($category){
            return $category;
        }else{
            $category = \App\Models\IndustryContactCategory::where('category_id', $this->category_id)->first();
            if($category){
                return $category;
            }
        }

        return null;
    }

}

