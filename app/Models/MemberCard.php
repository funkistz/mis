<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberCard extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'member_cards';

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
        'card_no',
        'blood_type',
        'rank_id',
        'induction',
        'due_date',
        'prefix',
        'postfix'
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function member()
    {
        return $this->hasOne('App\Models\Member');
    }
}
