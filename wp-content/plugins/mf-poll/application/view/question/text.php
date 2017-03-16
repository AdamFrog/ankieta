<div class="question question-<?= $type ?> question-entry">
    <?php if(isset($options['show_title'])){$options['show_title'] = filter_var($options['show_title'], FILTER_VALIDATE_BOOLEAN); if($options['show_title']){?><h3><?php echo $title ?></h3><?php }} ?>
    <p class="description">
        <?php echo $description ?>
    </p>
</div>