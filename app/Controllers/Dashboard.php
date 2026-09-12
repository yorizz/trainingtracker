<?php

namespace App\Controllers;

use App\Models\PlayerModel;
use App\Models\TrainingSessionModel;
use App\Models\AbsenceModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $playerModel = new PlayerModel();
        $trainingSessionModel = new TrainingSessionModel();
        $absenceModel = new AbsenceModel();

        $players = $playerModel
            ->where('active', 1)
            ->orderBy('display_order', 'ASC')
            ->orderBy('first_name', 'ASC')
            ->orderBy('last_name', 'ASC')
            ->findAll();

        $sessions = $trainingSessionModel
            ->where('training_group_id', 1)
            ->where('completed_at !=', null)
            ->where('session_date <=', date('Y-m-d'))
            ->orderBy('session_date', 'DESC')
            ->findAll(4);

        $sessionIds = array_column($sessions, 'id');

        $absences = [];

        if (!empty($sessionIds)) {
            $absenceRows = $absenceModel
                ->whereIn('training_session_id', $sessionIds)
                ->findAll();

            foreach ($absenceRows as $absence) {
                $absences[$absence['player_id']][$absence['training_session_id']] = true;
            }
        }

        foreach ($players as &$player) {
            $player['recent_absences'] = 0;

            foreach ($sessions as $session) {
                if (!empty($absences[$player['id']][$session['id']])) {
                    $player['recent_absences']++;
                }
            }
        }

        return view('dashboard/index', [
            'players' => $players,
            'sessions' => $sessions,
            'absences' => $absences,
        ]);
    }
}