<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php if (isset($title)) : echo $this->escape($title) . ' - ';
            endif; ?>Mini Blog</title>

    <link rel="stylesheet" href="<?php echo mix('/css/app.css'); ?>">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.2.0/css/uikit.min.css" />
</head>

<body>


    <header id="header" class="header">
        <nav id="nav" class="nav uk-navbar-container uk-padding-small" uk-navbar>
            <div class="uk-navbar-left">
                <h1><a href="<?php echo asset('/'); ?>" class="uk-logo">Mini Blog</a></h1>
            </div>
            <div class="uk-navbar-right">
                <ul class="uk-navbar-nav">

                    <?php if ($session->isAuthenticated()) : ?>
                    <li><a href="<?php echo asset('/'); ?>">ホーム</a></li>
                    <li><a href="<?php echo asset('/account'); ?>">アカウント</a></li>

                    <?php else : ?>

                    <li><a href="<?php echo asset('/account/signin'); ?>">ログイン</a></li>
                    <li><a href="<?php echo asset('/account/signup'); ?>">アカウント登録</a></li>

                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main id="main" class="main uk-section-small uk-padding">
        <?php echo $_content; ?>
    </main>

    <!-- UIkit JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.2.0/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.2.0/js/uikit-icons.min.js"></script>
</body>

</html>
