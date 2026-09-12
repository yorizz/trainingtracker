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


    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js" defer>
    </script>
    <script>
    window.trainingTracker = {
        setAbsenceUrl: '<?= site_url('training/set-absence') ?>',
        stateUrl: '<?= site_url('training/state') ?>'
    };
    </script>
    <script src="<?= base_url('assets/js/trainingtracker.js') ?>" defer>
    </script>

    <?= $this->renderSection('head') ?>
</head>

<body>

    <header class="border-bottom">
        <div class="container py-3">
            <div class="d-flex justify-content-between align-items-center">
                <a href="<?= site_url('/') ?>" class="text-decoration-none text-dark fw-semibold">
                    Training Tracker
                </a>

                <nav class="d-flex gap-2">
                    <a href="<?= site_url('/') ?>" class="btn btn-sm
                        <?= url_is('/') || url_is('dashboard')
                            ? 'btn-dark'
                            : 'btn-outline-secondary' ?>">
                        Dashboard
                    </a>

                    <a href="<?= site_url('training') ?>" class="btn btn-sm
                        <?= url_is('training*')
                            ? 'btn-dark'
                            : 'btn-outline-secondary' ?>">
                        Training
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <main class="container py-3">
        <?= $this->renderSection('content') ?>
    </main>


</body>

</html>