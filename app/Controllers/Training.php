<?php

namespace App\Controllers;

use App\Models\PlayerModel;
use App\Models\TrainingSessionModel;
use App\Models\AbsenceModel;

class Training extends BaseController
{
    public function session($date = null)
    {
        $playerModel = new PlayerModel();
        $trainingSessionModel = new TrainingSessionModel();
        $absenceModel = new AbsenceModel();

        $sessionDate = $date ?? date('Y-m-d');


        $players = $playerModel
            ->where('active', 1)
            ->orderBy('display_order', 'ASC')
            ->orderBy('first_name', 'ASC')
            ->orderBy('last_name', 'ASC')
            ->findAll();

        $trainingSession = $trainingSessionModel
            ->where('training_group_id', 1)
            ->where('session_date', $sessionDate)
            ->first();

        $absentPlayerIds = [];

        if ($trainingSession) {
            $absences = $absenceModel
                ->where('training_session_id', $trainingSession['id'])
                ->findAll();

            $absentPlayerIds = array_column($absences, 'player_id');
        }

        foreach ($players as &$player) {
            $player['absent'] = in_array(
                $player['id'],
                $absentPlayerIds
            );
        }

        return view('training/session', [
            'sessionDate' => $sessionDate,
            'players' => $players,
        ]);
    }

    public function setAbsence()
    {
        $playerId = $this->request->getPost('player_id');
        $sessionDate = $this->request->getPost('session_date');
        $absent = $this->request->getPost('absent') === '1';

        if (!$playerId || !$sessionDate) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' => 'Missing player or session date.',
                ]);
        }

        $trainingSessionModel = new TrainingSessionModel();
        $absenceModel = new AbsenceModel();

        $trainingSession = $trainingSessionModel
            ->where('training_group_id', 1)
            ->where('session_date', $sessionDate)
            ->first();

        if (!$trainingSession && $absent) {
            $trainingSessionId = $trainingSessionModel->insert([
                'training_group_id' => 1,
                'session_date' => $sessionDate,
            ]);
        } elseif ($trainingSession) {
            $trainingSessionId = $trainingSession['id'];
        } else {
            return $this->response->setJSON([
                'success' => true,
                'absent' => false,
            ]);
        }

        $existingAbsence = $absenceModel
            ->where('training_session_id', $trainingSessionId)
            ->where('player_id', $playerId)
            ->first();

        if ($absent && !$existingAbsence) {
            $absenceModel->insert([
                'training_session_id' => $trainingSessionId,
                'player_id' => $playerId,
            ]);
        }

        if (!$absent && $existingAbsence) {
            $absenceModel->delete($existingAbsence['id']);
        }

        return $this->response->setJSON([
            'success' => true,
            'absent' => $absent,
        ]);
    }

    public function complete()
    {
        $sessionDate = $this->request->getPost('session_date');

        if ($sessionDate > date('Y-m-d')) {
            return redirect()
                ->to(site_url('training/' . $sessionDate))
                ->with('error', 'Future training sessions cannot be completed.');
        }

        $trainingSessionModel = new TrainingSessionModel();

        $trainingSession = $trainingSessionModel
            ->where('training_group_id', 1)
            ->where('session_date', $sessionDate)
            ->first();

        if (!$trainingSession) {
            $trainingSessionId = $trainingSessionModel->insert([
                'training_group_id' => 1,
                'session_date' => $sessionDate,
            ]);
        } else {
            $trainingSessionId = $trainingSession['id'];
        }

        $trainingSessionModel->update($trainingSessionId, [
            'completed_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('/'));
    }

    public function state($sessionDate)
    {
        $trainingSessionModel = new TrainingSessionModel();
        $absenceModel = new AbsenceModel();

        $trainingSession = $trainingSessionModel
            ->where('training_group_id', 1)
            ->where('session_date', $sessionDate)
            ->first();

        $absentPlayerIds = [];

        if ($trainingSession) {
            $absences = $absenceModel
                ->where('training_session_id', $trainingSession['id'])
                ->findAll();

            $absentPlayerIds = array_map(
                'intval',
                array_column($absences, 'player_id')
            );
        }

        return $this->response->setJSON([
            'absent_player_ids' => $absentPlayerIds,
        ]);
    }
}