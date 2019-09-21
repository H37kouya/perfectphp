<?php $this->setLayoutVar('title', 'アカウント'); ?>

<section>
    <h2 class="uk-heading-bullet">アカウント</h2>

    <p>
        ユーザーID：
        <a
            href="<?php echo $base_url; ?>/user/<?php echo $this->escape($user['user_name']); ?>" class="uk-link-text">
            <strong><?php echo $this->escape($user['user_name']); ?></strong>
        </a>
    </p>

    <div class="uk-flex">
        <a href="<?php echo asset('/'); ?>" class="uk-button uk-button-secondary uk-margin-right">ホーム</a>
        <a href="<?php echo asset('/account/signout'); ?>" class="uk-button uk-button-danger">ログアウト</a>
    </div>

    <section class="uk-section-small">
        <h3 class="uk-heading-bullet">フォロー中</h3>

        <?php if (count($followings) > 0): ?>
        <ul class="uk-list">
            <?php foreach ($followings as $following): ?>
            <li>
                <a
                    href="<?php echo asset('/user' . '/' . $this->escape($following['user_name'])); ?>" class="uk-link-text">
                    <?php echo $this->escape($following['user_name']); ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </section>
</section>
