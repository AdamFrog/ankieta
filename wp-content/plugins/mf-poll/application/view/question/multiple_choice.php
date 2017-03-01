<div class="question question-<?= $type ?>">
    <?php $show_title = filter_var($show_title, FILTER_VALIDATE_BOOLEAN); if($show_title){?><h3><?php echo $title ?></h3><?php } ?>
    <p class="description">
        <?php echo $description ?>
    </p>
    <ul class="answer">
    <?php if(count($answers) != 0){ ?>
        <?php foreach ($answers as $key => $answer) { ?>
            <li>
                <input type="checkbox" id="checkbox-1-<?= $key ?>" class="regular-checkbox" name="q[1][response][<?= $key ?>]" value="<?= $key ?>"/>
                <label for="checkbox-1-<?= $key ?>"></label>
                <label for="checkbox-1-<?= $key ?>"><?php echo $answer['title'];?></label>
            </li>
        <?php } ?>
    <?php }else{ ?> 
        <li><?php echo __('Please add answer!', 'mfpoll') ?></li>
    <?php } ?>
    </ul>
</div>