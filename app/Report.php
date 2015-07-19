<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['user_id', 'issues'];

    protected $casts = ['issues' => 'array'];

    public function user()
    {
        return $this->belongsTo(App\User::class);
    }

    public static function findByUser(User $user)
    {
        return self::where('user_id', $user->id)->first();
    }
}
