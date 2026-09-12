<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenceModel extends Model
{
    protected $table = 'absences';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'training_session_id',
        'player_id',
    ];

    protected $useTimestamps = true;
}