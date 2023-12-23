<html>

<head>
    <!-- title -->
    <title><?= htmlspecialchars($warvilConfig['name']) ?></title>

    <!-- meta tags -->
    <meta name="description" content="<?= htmlspecialchars($warvilConfig['description']) ?>">
    <meta name="author" content="<?= htmlspecialchars($warvilConfig['author']) ?>">
    <meta name="keywords" content="<?= implode(', ', $warvilConfig['keywords']) ?>">
    <meta name="version" content="<?= htmlspecialchars($warvilConfig['version']) ?>">
    <!-- styles -->
    <link rel="stylesheet" href="<?= htmlspecialchars($baseStyle) ?>">
    <?php echo $cssPath ? '<link rel="stylesheet" href="' . htmlspecialchars($cssPath) . '">' : ''; ?>
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