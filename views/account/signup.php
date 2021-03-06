<?php $this->setLayoutVar('title', 'アカウント登録') ?>

<section>
    <h2 class="uk-heading-bullet">アカウント登録</h2>

    <form
        action="<?php echo asset('/account/register'); ?>"
        method="post">
        <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>">

        <?php if (isset($errors) && count($errors) > 0): ?>
        <?php echo $this->render('errors', ['errors' => $errors]); ?>
        <?php endif; ?>

        <?php
            echo $this->render('account/inputs', [
                'user_name' => $user_name,
                'password' => $password,
            ]);
        ?>

        <p>
            <input type="submit" value="登録" class="uk-button uk-button-primary">
            <a href="<?php echo asset('/account/signin'); ?>"
                class="uk-button uk-button-success">ログイン</a>
        </p>
    </form>
</section>