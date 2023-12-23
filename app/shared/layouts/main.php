<html>

<head>
    <title><?= htmlspecialchars($warvilConfig['name']) ?></title>
    <meta name="description" content="<?= htmlspecialchars($warvilConfig['description']) ?>">
    <meta name="author" content="<?= htmlspecialchars($warvilConfig['author']) ?>">
    <meta name="keywords" content="<?= implode(', ', $warvilConfig['keywords']) ?>">
    <meta name="version" content="<?= htmlspecialchars($warvilConfig['version']) ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars($baseStyle) ?>">
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