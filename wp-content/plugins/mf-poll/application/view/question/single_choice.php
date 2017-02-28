<div class="question question-<?= $type ?>">
    <?php if($show_title){?><h3><?php echo $title ?></h3><?php } ?>
    <p class="description">
        <?php echo $description ?>
    </p>
    <ul class="answer">
    <?php foreach ($answers as $key => $answer) { ?>
        <li>
            <input type="checkbox" id="checkbox-1-<?= $key ?>" class="regular-checkbox" name="" value="<?php echo $answer['title'];?>"/>
            <label for="checkbox-1-<?= $key ?>"></label>
            <label for="checkbox-1-<?= $key ?>"><?php echo $answer['title'];?></label>
        </li>
    <?php } ?>
    </ul>
</div>