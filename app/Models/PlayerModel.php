<?php

namespace App\Models;

use CodeIgniter\Model;

class PlayerModel extends Model
{
    protected $table = 'players';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'training_group_id',
        'first_name',
        'last_name',
        'display_order',
        'active',
    ];

    protected $useTimestamps = true;
}