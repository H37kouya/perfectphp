<?php $this->setLayoutVar('title', $status['user_name']); ?>

<div class="" uk-grid>
<?php echo $this->render('status/status', ['status' => $status]); ?>
</div>
