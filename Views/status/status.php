<div class="status">
    <div class="status_content">
        <a href="<?php echo asset('/user' . '/' . $this->escape($status['user_name'])); ?>">
            <?php echo $this->escape($status['user_name']); ?>
        </a>
        <?php echo $this->escape($status['body']); ?>
    </div>
    <div>
        <a href="<?php echo asset($this->escape('/user' . '/' . $status['user_name'] . '/status' . '/' . $status['id'])); ?>">
            <?php echo $this->escape($status['created_at']); ?>
        </a>
    </div>
</div>
