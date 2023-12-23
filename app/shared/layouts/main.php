<!-- layouts/main.php -->

<html>

<head>
    <title><?= htmlspecialchars($appName) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <meta name="author" content="<?= htmlspecialchars($warvilConfig['author']) ?>">
    <meta name="keywords" content="<?= implode(', ', $warvilConfig['keywords']) ?>">
    <meta name="version" content="<?= htmlspecialchars($warvilConfig['version']) ?>">
</head>

<body>
    <header>
    </header>
    <main>
        <?= $this->content ?>
    </main>
    <footer>
    </footer>
</body>

</html>