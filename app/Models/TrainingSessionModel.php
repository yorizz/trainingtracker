<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingSessionModel extends Model
{
    protected $table = 'training_sessions';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'training_group_id',
        'session_date',
        'completed_at',
    ];

    protected $useTimestamps = true;
}