<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $this->renderSection('title') ?: 'Training Tracker' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/trainingtracker.css') ?>">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" defer>
    </script>

    <script src="<?= base_url('assets/js/trainingtracker.js') ?>" defer>
    </script>

    <?= $this->renderSection('head') ?>
</head>

<body>

    <header class="border-bottom">
        <div class="container py-3">
            <a href="<?= base_url('/') ?>" class="text-decoration-none text-dark fw-bold">
                Training Tracker
            </a>
        </div>
    </header>

    <main class="container py-3">
        <?= $this->renderSection('content') ?>
    </main>


</body>

</html>