<?php $this->setLayoutVar('title', 'ログイン'); ?>

<section>
    <h2 class="uk-heading-bullet">ログイン</h2>



    <form action="<?php echo asset('/account/authenticate'); ?>" method="post">
        <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>">

        <?php if (isset($errors) && count($errors) > 0) : ?>
            <?php echo $this->render('errors', ['errors' => $errors]); ?>
        <?php endif; ?>

        <?php echo $this->render('account/inputs', [
            'user_name' => $user_name,
            'password' => $password,
        ]); ?>

        <p>
            <input type="submit" value="ログイン" class="uk-button uk-button-primary">
            <a href="<?php echo asset('/account/signup'); ?>" class="uk-button uk-button-success">新規ユーザー登録</a>
        </p>
    </form>
</section>
