<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coach extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'coaches';

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
        'phone_1',
        'phone_2',
        'nric'
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * Get all of the member's user.
     */
    public function user()
    {
        return $this->morphOne('App\Models\User', 'userable');
    }
}
