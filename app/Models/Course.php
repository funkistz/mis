<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';

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
        'venue',
        'date',
        'slug',
        'description',
        'is_active'
    ];

    protected $dates = [
        'date',
        'deleted_at',
    ];

    public function members()
    {
        return $this->belongsToMany('App\Models\Member');
    }
}
