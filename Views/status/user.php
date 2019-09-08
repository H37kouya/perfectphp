<?php $this->setLayoutVar('title', $user['user_name']); ?>

<section>
    <h2><?php echo $this->escape($user['user_name']); ?></h2>

    <div id="statuses">
        <?php foreach($statuses as $status) {
            echo $this->render('status/status', ['status' => $status]);
        }?>
    </div>
</section>
