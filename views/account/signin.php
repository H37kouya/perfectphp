<?php $this->setLayoutVar('title', 'ログイン'); ?>

<section>
    <h2>ログイン</h2>

    <p><a href="<?php echo asset('/account/signup');?>">新規ユーザー登録</a>
    </p>

    <form action="<?php echo asset('/account/authenticate'); ?>"
        method="post">
        <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>">

        <?php if (isset($errors) && count($errors) > 0): ?>
        <?php echo $this->render('errors', ['errors' => $errors]); ?>
        <?php endif; ?>

        <?php echo $this->render('account/inputs', [
            'user_name' => $user_name,
            'password' => $password,
        ]); ?>

        <p>
            <input type="submit" value="ログイン">
        </p>
    </form>
</section>