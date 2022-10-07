<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservation';

    protected $primaryKey = 'reservation_id';

    protected $guarded = [''];

    public $timestamps = true;


    public function User()
    {
        return $this->hasOne(User::class,'user_id','reservation_user_id');
    }
    
}
