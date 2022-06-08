<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';
    protected $primaryKey = 'attendance_id';
    protected $fillable = [
        'attendance_user_id',
        'attendance_status',
    ];

    public static function User($column, $filter)
    {
        return Attendance::leftjoin('user', 'attendance_user_id', 'user.user_id')
            ->leftjoin('person', 'person_id', 'user_person_id')
            ->leftJoin('store', 'store.store_id', 'person.persontable_id')
            ->leftJoin('employment', 'employment.employment_user_id', 'user.user_id')
            ->select('attendance.*', 'employment.*', 'user.*', 'person.*', 'store.*', 'attendance.created_at as attendance_created_at')
            ->orderBy('attendance_created_at', 'asc')
            ->where($column, $filter);
    }
}
