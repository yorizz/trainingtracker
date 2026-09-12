<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingGroupModel extends Model
{
    protected $table = 'training_groups';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'active',
    ];

    protected $useTimestamps = true;
}