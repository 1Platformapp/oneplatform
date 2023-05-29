<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class IndustryContactCategory extends Authenticatable

{

    protected $table = 'industry_contact_categories';
    
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

     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo

     */

    public function region()

    {

        return $this->belongsTo( IndustryContactCategoryGroup::class, 'group_id', 'group_id' );

    }

    /**

     * @return \Illuminate\Database\Eloquent\Relations\HasMany

     */

    public function industryContacts()

    {

        return $this->hasMany( IndustryContact::class, 'category_id', 'lookup_id' );

    }

}

