<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'sem_when_registered',
        'member_card_id',
    ];

    protected $dates = [
        'created_at',
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

    public function courseClasses()
    {
        return $this->belongsToMany(CourseClass::class)->withPivot('accepted', 'fixed', 'attendance');
    }

    public function attendedCourseClasses()
    {
        return $this->belongsToMany(CourseClass::class)->withPivot('accepted', 'fixed')->wherePivot('accepted', '!=' , null);
    }

    public function notAttendedCourseClasses()
    {
        return $this->belongsToMany(CourseClass::class)->withPivot('accepted', 'fixed')->wherePivot('accepted', null);
    }

    public function getCurrentSemesterAttribute()
    {
        $now = Carbon::now();
        $first_sem_date = 3;
        $created_at = Carbon::createFromTimestamp(strtotime($this->attributes['created_at']));

        if($created_at->format('j') >= 9){
          $first_sem_date = 9;
        }

        $created_at->day = 1;
        $created_at->month = $first_sem_date;

        return round($created_at->diffInMonths($now)/6, 0, PHP_ROUND_HALF_DOWN) + $this->attributes['sem_when_registered'];


    }
}
