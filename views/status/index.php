<?php $this->setLayoutVar('title', 'ホーム') ?>

<section>
    <h2 class="uk-heading-bullet">ホーム</h2>

    <form
        action="<?php echo asset('/status/post'); ?>"
        method="post">
        <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>">

        <?php if (isset($errors) && count($errors) > 0) {
    echo $this->render('errors', ['errors' => $errors]);
}?>

        <div class="uk-width-large">
            <textarea name="body" cols="60" rows="2"
                class="uk-textarea"><?php echo $this->escape($body); ?></textarea>
        </div>

        <p><input type="submit" value="発言" class="uk-button uk-button-primary"></p>
    </form>

    <div id="statuses">
        <?php foreach ($statuses as $status): ?>
        <?php echo $this->render('status/status', ['status' => $status]); ?>
        <?php endforeach; ?>
    </div>
</section>