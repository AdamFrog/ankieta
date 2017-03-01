<div class="question question-<?= $type ?>">
    <?php $show_title = filter_var($show_title, FILTER_VALIDATE_BOOLEAN); if($show_title){?><h3><?php echo $title ?></h3><?php } ?>
    <p class="description">
        <?php echo $description ?>
    </p>
    <textarea rows="4" style="width:100%">   
    </textarea>
</div>