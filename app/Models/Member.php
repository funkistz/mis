<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'members';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'gender',
        'race_id',
        'date_of_birth',
        'place_of_birth',
        'nric',
        'nationality_id',
        'phone_1',
        'phone_2',
        'education_level_id',
        'skill',
        'illness',
        'mar_stat',
        'unif_stat',
        'member_status_id',
        'member_card_id',
    ];

    protected $dates = [
        'deleted_at',
        'date_of_birth'
    ];

    /**
     * Get all of the member's user.
     */
    public function user()
    {
        return $this->morphOne('App\Models\User', 'userable');
    }

    public function race()
    {
        return $this->belongsTo('App\Models\Race');
    }

    public function gender()
    {
        if($this->attributes['gender'] == 'm'){
          return 'male';
        }else if($this->attributes['gender'] == 'f'){
          return 'female';
        }else{
          return 'unknown';
        }
    }

    public function nationality()
    {
        return $this->belongsTo('App\Models\Nationality');
    }

    public function educationLevel()
    {
        return $this->belongsTo('App\Models\EducationLevel');
    }

    public function memberStatus()
    {
        return $this->belongsTo('App\Models\MemberStatus');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Models\Course')->withPivot('accepted');
    }

    public function coaches()
    {
        return $this->belongsToMany('App\Models\Coach');
    }

    public function memberCard()
    {
        return $this->belongsTo('App\Models\MemberCard');
    }
}
