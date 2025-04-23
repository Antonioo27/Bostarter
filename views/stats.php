<?php require 'partials/head.php';
?>

<body>
    <?php require 'partials/navbar.php'; ?>

    <main style="min-height: 100vh;">
        <div class="container mt-5">
            <h1 class="title">Statistiche</h1>

            <h2 class="subTitle">Top 3 Creatori per Affidabilità</h2>
            <ul class="list">
                <?php foreach ($topCreatori as $nickname): ?>
                    <li class="listItem"><?= htmlspecialchars($nickname) ?></li>
                <?php endforeach; ?>
            </ul>

            <h2 class="subTitle">Top 3 Progetti Vicini al Completamento</h2>
            <ul class="list">
                <?php foreach ($topProgetti as $titolo): ?>
                    <li class="listItem"><?= htmlspecialchars($titolo) ?></li>
                <?php endforeach; ?>
            </ul>

            <h2 class="subTitle">Top 3 Finanziatori per Totale Erogato</h2>
            <ul class="list">
                <?php foreach ($topFinanziatori as $nickname): ?>
                    <li class="listItem"><?= htmlspecialchars($nickname) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>    
    </main>
    <?php require 'partials/footer.php'; ?>
</body>

</html>