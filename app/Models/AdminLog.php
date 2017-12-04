<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_logs';

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
        'log',
    ];

    public function user()
    {
      return $this->belongsTo(User::clas);
    }

}
