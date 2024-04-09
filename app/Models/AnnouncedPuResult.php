<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncedPuResult extends Model
{
    use HasFactory;
    protected $table = 'announced_pu_results';
    protected $fillable =[
        'entered_by_user',
        'polling_unit_uniqueid',
        'party_abbreviation',
        'party_score',
        'date_entered',
        'user_ip_address'
    ];
    public $timestamps= false;
}
