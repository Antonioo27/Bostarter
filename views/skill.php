<?php require 'partials/head.php'; ?>

<body>
    <form action="submit_skill.php" method="POST">
        <label for="competence">Competenza:</label>
        <input type="text" id="competence" name="competence" required>

        <label for="level">Livello:</label>
        <input type="number" id="level" name="level" min="1" max="10" required>

        <button type="submit">Invia</button>
    </form>
</body>