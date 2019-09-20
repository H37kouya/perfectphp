<?php $this->setLayoutVar('title', 'アカウント'); ?>

<section>
    <h2>アカウント</h2>

    <p>
        ユーザーID：
        <a
            href="<?php echo $base_url; ?>/user/<?php echo $this->escape($user['user_name']); ?>">
            <strong><?php echo $this->escape($user['user_name']); ?></strong>
        </a>
    </p>

    <ul>
        <li>
            <a href="<?php echo asset('/'); ?>">ホーム</a>
        </li>
        <li>
            <a
                href="<?php echo asset('/account/signout'); ?>">ログアウト</a>
        </li>
    </ul>

    <section>
        <h3>フォロー中</h3>

        <?php if (count($followings) > 0): ?>
        <ul>
            <?php foreach ($followings as $following): ?>
            <li>
                <a
                    href="<?php echo asset('/user' . '/' . $this->escape($following['user_name'])); ?>">
                    <?php echo $this->escape($following['user_name']); ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </section>
</section>