<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['address', 'phone', 'social_networks' , 'user_id' ];
    protected $guarded = ['user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
