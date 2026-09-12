<?= $this->extend('layouts/default') ?>

<?= $this->section('title') ?>
Training — <?= esc($sessionDate) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1>Training</h1>

<p><?= esc($sessionDate) ?></p>

<!-- player grid goes here -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    // absence toggling eventually goes here
</script>

<?= $this->endSection() ?>