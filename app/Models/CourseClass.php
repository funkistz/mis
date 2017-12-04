<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseClass extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course_classes';

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
        'name',
        'description',
        'course_id',
        'date',
        'venue',
        'is_active'
    ];

    protected $dates = [
        'date',
        'deleted_at',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class)->withPivot('accepted','fixed');
    }
}
