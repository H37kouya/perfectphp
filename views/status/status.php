<div class="status uk-card uk-card-default uk-width-1-4@m">
    <div class="status_content uk-card-header uk-padding-small">
        <a href="<?php echo asset('/user' . '/' . $this->escape($status['user_name'])); ?>" class="uk-card-title">
            <?php echo $this->escape($status['user_name']); ?>
        </a>
    </div>

    <div class="uk-card-body uk-padding-small">
        <?php echo $this->escape($status['body']); ?>
    </div>

    <div class="uk-card-footer uk-padding-small">
        <div class="uk-text-right">
            <a href="<?php echo asset($this->escape('/user' . '/' . $status['user_name'] . '/status' . '/' . $status['id'])); ?>" class="uk-button uk-button-text">
                <?php echo $this->escape($status['created_at']); ?>
            </a>
        </div>
</div>
</div>
