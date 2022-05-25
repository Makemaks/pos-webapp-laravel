<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    use HasFactory;

    protected $table = 'employment';
    protected $primaryKey = 'employment_id';
    protected $guarded = [];
    protected $attributes = [
        'employment_user_id' => 1,
        "employment_general" => '{
                "ibutton": "",
                "secret_number" => "",
                "ni_number" => "",
        }',
        "employment_level_default" => '{
            "default_menu_level" => "",
            "default_price_level" => "",
            "default_floorplan_level" => "",
        }',
        "employment_commision" => '{
            "1" => "",
            "2" => "",
            "3" => "",
            "4" => "",
        }',
        "employment_setup" => '{
            "Allowed Function" => "{}",
            "Allowed Modes" => "{}",
            "Employee Job" => "{}",
            "User Control" => "{}",
        }',
        "employment_user_pay" => '{
            "pay_rate" => "",
            "from_date" => "",
            "to_date" => "",
            "start_hour" => "",
            "end_hour" => "",
        }',
    ];
    protected $casts = [
        'employment_general' => 'array',
        'employment_level_default' => 'array',
        'employment_commision' => 'array',
        'employment_setup' => 'array',
        'employment_user_pay' => 'array',
    ];
}
