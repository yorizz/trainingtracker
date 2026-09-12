<?= $this->extend('layouts/default') ?>

<?= $this->section('title') ?>
Training Tracker
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h1 class="h3 mb-1">Recent training</h1>
    <div class="text-muted">
        Last <?= count($sessions) ?> training sessions
    </div>
</div>

<?php if (empty($sessions)): ?>

<div class="alert alert-light border">
    No training sessions recorded yet.
</div>

<?php else: ?>

<div class="table-responsive">

    <table id="recent-training-table" class="table align-middle">

        <thead>
            <tr>
                <th>Player</th>

                <?php foreach ($sessions as $session): ?>
                <th class="text-center" data-sorter="false">
                    <?= esc(date('D', strtotime($session['session_date']))) ?><br>
                    <small class="text-muted">
                        <?= esc(date('j M', strtotime($session['session_date']))) ?>
                    </small>
                </th>
                <?php endforeach ?>

                <th class="text-center">
                    Missed
                </th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($players as $player): ?>

            <tr>
                <td>
                    <?= esc($player['first_name']) ?>
                    <?= esc($player['last_name'] ?? '') ?>
                </td>

                <?php foreach ($sessions as $session): ?>

                <?php
                            $absent = !empty(
                                $absences[$player['id']][$session['id']]
                            );
                            ?>

                <td class="text-center">
                    <?php if ($absent): ?>
                    <span class="text-danger fw-bold">
                        ✕
                    </span>
                    <?php else: ?>
                    <span class="text-success">
                        ✓
                    </span>
                    <?php endif ?>
                </td>

                <?php endforeach ?>

                <td class="text-center fw-bold">
                    <?= $player['recent_absences'] ?>
                </td>
            </tr>

            <?php endforeach ?>

        </tbody>

    </table>

</div>

<?php endif ?>

<?= $this->endSection() ?>