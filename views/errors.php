<ul class="uk-list uk-list-bullet uk-text-danger">
    <?php foreach($errors as $error): ?>
    <li><?php echo $this->escape($error); ?></li>
    <?php endforeach; ?>
</ul>
