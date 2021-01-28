<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityFestival extends Model
{
    protected $fillable = ['name', 'date', 'description', 'observation', 'festival_id', 'user_id'];

    //Relación Festival-Actividad
    public function festival()
    {
        return $this->belongsTo('App\Festival');
    }

    //Relación Admin(Responsable)-Actividad
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
