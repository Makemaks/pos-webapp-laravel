<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employement extends Model
{
    use HasFactory;

    protected $table = 'employement';
    protected $primaryKey = 'employement_id';
    protected $attributes = [
        'employement_user_id' => 1,
        "employement_general" => '{
            "1": {
                "ibutton": "",
                "secret_number" => "",
                "ni_number" => "",
            }
        }',
        "employement_level_default" => '{
            "default_menu_level" => "",
            "default_price_level" => "",
            "default_floorplan_level" => "",
        }',
        "employement_commision" => '{
            "1" => "",
            "2" => "",
            "3" => "",
            "4" => "",
        }',
        "employement_allowed_function" => '{}',
        "employement_allowed_mode" => '{}',
        "employement_employee_job" => '{}',
        "employement_user_control" => '{}',
        "employement_user_pay" => '{
            "pay_rate" => "",
            "from_date" => "",
            "to_date" => "",
            "start_hour" => "",
            "end_hour" => "",
        }',
    ];
    protected $casts = [
        'employement_general' => 'array',
        'employement_level_default' => 'array',
        'employement_commision' => 'array',
        'employement_allowed_function' => 'array',
        'employement_allowed_mode' => 'array',
        'employement_employee_job' => 'array',
        'employement_user_control' => 'array',
        'employement_user_pay' => 'array',
    ];
}
