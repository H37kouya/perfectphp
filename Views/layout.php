<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php if (isset($title)): echo $this->escape($title) . ' - ';endif; ?>Mini Blog</title>
</head>
<body>

    <header id="header" class="header">
        <h1><a href="<?php echo $base_url; ?>">Mini Blog</a></h1>
    </header>

    <nav id="nav" class="nav">
        <p>
            <?php if ($session->isAuthenticated()): ?>
            <a href="<?php echo $base_url; ?>/">ホーム</a>
            <a href="<?php echo $base_url; ?>/account">アカウント</a>
            <?php else: ?>
            <a href="<?php echo $base_url; ?>/account/signin">ログイン</a>
            <a href="<?php echo $base_url; ?>/account/signup">アカウント登録</a>
            <?php endif; ?>
        </p>
    </nav>

    <main id="main" class="main">
        <?php echo $_content; ?>
    </main>

</body>
</html>
