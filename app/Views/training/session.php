<?= $this->extend('layouts/default') ?>

<?= $this->section('title') ?>
Training — <?= esc(date('j M Y', strtotime($sessionDate))) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$absentCount = count(array_filter(
    $players,
    fn($player) => $player['absent']
));
?>

<div class="d-flex justify-content-between align-items-end mb-4">

    <div>
        <h1 class="h3 mb-1">Training</h1>

        <div class="mt-2">
            <input type="date" id="training-date" class="form-control" value="<?= esc($sessionDate) ?>"
                data-training-url="<?= site_url('training') ?>">
        </div>
    </div>

    <div class="text-end">
        <span id="absent-count" class="badge text-bg-danger fs-6 <?= $absentCount === 0 ? 'd-none' : '' ?>">
            <?= $absentCount ?> absent
        </span>
    </div>

</div>

<div class="row g-2">
    <?php foreach ($players as $player): ?>

    <div class="col-6 col-md-4 col-lg-3">
        <button type="button" class="btn w-100 py-3 player-toggle
                    <?= $player['absent']
                        ? 'btn-danger'
                        : 'btn-outline-secondary' ?>" data-player-id="<?= $player['id'] ?>"
            data-session-date="<?= esc($sessionDate) ?>">
            <?= esc($player['first_name']) ?>
            <?= esc($player['last_name'] ?? '') ?>
        </button>
    </div>

    <?php endforeach ?>
</div>

<form action="<?= site_url('training/complete') ?>" method="post" class="mt-4">
    <input type="hidden" name="session_date" value="<?= esc($sessionDate) ?>">
    <?php $isFutureSession = $sessionDate > date('Y-m-d'); ?>

    <?php $isFutureSession = $sessionDate > date('Y-m-d'); ?>

    <button type="submit" class="btn btn-dark w-100 py-3 fw-semibold" <?= $isFutureSession ? 'disabled' : '' ?>>
        Done
    </button>
</form>

<?php if (empty($players)): ?>

<div class="alert alert-light border">
    No players found.
</div>

<?php endif ?>

<?= $this->endSection() ?>