<div class="question question-<?= $type ?> question-entry">
    <?php if(isset($_SESSION['mfpmessage'][$id])){ ?>
        <span class="message-block"><?= $_SESSION['mfpmessage'][$id] ?></span>
    <?php unset($_SESSION['mfpmessage'][$id]); }?>
    <?php if((bool)$options['show_title']){?>
        <h3>
            <?php echo $title ?>
            <?php if((bool)$options['require']){?><span class="require-icon">*</span><?php } ?>
        </h3>
    <?php } ?>
    <p class="description">
        <?php echo $description ?>
    </p>
    <?php 
        $value = null;
        if(isset($respond['response'])){
            $value = $respond['response'];
        }
    ?>
    <ul class="nps-answers clearfix">
        <li>
            <span>1</span>
            <input type="radio" id="radio-<?= $answer->id ?>-1" class="regular-radio" name="q[<?= $id ?>][response]" value="1" <?php echo $value == 1 ? 'checked' : null; ?>/>
            <label for="radio-<?= $answer->id ?>-1"></label>
            <label for="radio-<?= $answer->id ?>-1"><?php echo $answer->title;?></label>
        </li>
        <li>
            <span>2</span>
            <input type="radio" id="radio-<?= $answer->id ?>-2" class="regular-radio" name="q[<?= $id ?>][response]" value="2" <?php echo $value == 2 ? 'checked' : null; ?>/>
            <label for="radio-<?= $answer->id ?>-2"></label>
            <label for="radio-<?= $answer->id ?>-2"><?php echo $answer->title;?></label>
        </li>
        <li>
            <span>3</span>
            <input type="radio" id="radio-<?= $answer->id ?>-3" class="regular-radio" name="q[<?= $id ?>][response]" value="3" <?php echo $value == 3 ? 'checked' : null; ?>/>
            <label for="radio-<?= $answer->id ?>-3"></label>
            <label for="radio-<?= $answer->id ?>-3"><?php echo $answer->title;?></label>
        </li>
        <li>
            <span>4</span>
            <input type="radio" id="radio-<?= $answer->id ?>-4" class="regular-radio" name="q[<?= $id ?>][response]" value="4" <?php echo $value == 4 ? 'checked' : null; ?>/>
            <label for="radio-<?= $answer->id ?>-4"></label>
            <label for="radio-<?= $answer->id ?>-4"><?php echo $answer->title;?></label>
        </li>
        <li>
            <span>5</span>
            <input type="radio" id="radio-<?= $answer->id ?>-5" class="regular-radio" name="q[<?= $id ?>][response]" value="5" <?php echo $value == 5 ? 'checked' : null; ?>/>
            <label for="radio-<?= $answer->id ?>-5"></label>
            <label for="radio-<?= $answer->id ?>-5"><?php echo $answer->title;?></label>
        </li>
        <li>
            <span>6</span>
            <input type="radio" id="radio-<?= $answer->id ?>-6" class="regular-radio" name="q[<?= $id ?>][response]" value="6" <?php echo $value == 6 ? 'checked' : null; ?>/>
            <label for="radio-<?= $answer->id ?>-6"></label>
            <label for="radio-<?= $answer->id ?>-6"><?php echo $answer->title;?></label>
        </li>
        <li>
            <span>7</span>
            <input type="radio" id="radio-<?= $answer->id ?>-7" class="regular-radio" name="q[<?= $id ?>][response]" value="7" <?php echo $value == 7 ? 'checked' : null; ?>/>
            <label for="radio-<?= $answer->id ?>-7"></label>
            <label for="radio-<?= $answer->id ?>-7"><?php echo $answer->title;?></label>
        </li>
        <li>
            <span>8</span>
            <input type="radio" id="radio-<?= $answer->id ?>-8" class="regular-radio" name="q[<?= $id ?>][response]" value="8" <?php echo $value == 8 ? 'checked' : null; ?>/>
            <label for="radio-<?= $answer->id ?>-8"></label>
            <label for="radio-<?= $answer->id ?>-8"><?php echo $answer->title;?></label>
        </li>
        <li>
            <span>9</span>
            <input type="radio" id="radio-<?= $answer->id ?>-9" class="regular-radio" name="q[<?= $id ?>][response]" value="9" <?php echo $value == 9 ? 'checked' : null; ?>/>
            <label for="radio-<?= $answer->id ?>-9"></label>
            <label for="radio-<?= $answer->id ?>-9"><?php echo $answer->title;?></label>
        </li>
        <li>
            <span>10</span>
            <input type="radio" id="radio-<?= $answer->id ?>-10" class="regular-radio" name="q[<?= $id ?>][response]" value="10" <?php echo $value == 10 ? 'checked' : null; ?>/>
            <label for="radio-<?= $answer->id ?>-10"></label>
            <label for="radio-<?= $answer->id ?>-10"><?php echo $answer->title;?></label>
        </li>
    </ul>
    <input type="hidden" name="q[<?= $id ?>][qid]" value="<?= $id ?>"/>
</div>