<?php $this->setLayoutVar('title', $user['user_name']); ?>

<section>
    <h2><?php echo $this->escape($user['user_name']); ?></h2>

    <?php if (!is_null($following)) :?>
        <?php if ($following): ?>
            <p>フォローしています</p>
        <?php else: ?>
        <form action="<?php echo asset('/follow'); ?>" method="post">
            <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>">
            <input type="hidden" name="following_name" value="<?php echo $this->escape($user['user_name']); ?>">

            <input type="submit" value="フォローする" class="uk-button uk-button-primary">
        </form>
        <?php endif; ?>
    <?php endif; ?>

    <div id="statuses" uk-grid>
        <?php foreach($statuses as $status) {
            echo $this->render('status/status', ['status' => $status]);
        }?>
    </div>
</section>
