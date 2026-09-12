<?php

namespace App\Models;

use CodeIgniter\Model;

class PlayerTeamModel extends Model
{
    protected $table = 'player_teams';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'player_id',
        'team_id',
        'start_date',
        'end_date',
    ];

    protected $useTimestamps = true;
}