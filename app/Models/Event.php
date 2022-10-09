<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'event_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['event_account_id', 'event_user_id', 'event_name', 'event_description', 'event_note', 'event_ticket', 'event_file', 'event_floorplan'];

    /**
     * The model's attributes.
     *
     * @var array
     */

    protected $attributes = [
        'event_note'      => '{"user_id": "", "description": "", "created_at": ""}',
        'event_ticket'    => '{"name": "", "type": "", "quantity": "", "cost": "", "row": ""}',
        'event_file'      => '{"user_id": "", "name": "", "location": "", "type": ""}',
        'event_floorplan' => '{"setting_building_id": "", "setting_room_id": ""}',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'event_note'      => 'array',
        'event_ticket'    => 'array',
        'event_file'      => 'array',
        'event_floorplan' => 'array',
    ];

    public static function ticketType()
    {
        return [
            'NULL'
        ];
    }

}
