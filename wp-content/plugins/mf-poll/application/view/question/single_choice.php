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
    <ul class="answer">
    <?php if(count($answers) != 0){ ?>
        <?php foreach ($answers as $key => $answer) { $answer = (object) $answer; ?>
            <?php 
                $checked = false;
                if(isset($respond['response'])){
                    if($respond['response'] == $answer->id){
                        $checked = true;
                    }
                }
            ?>
            <li>
                <input type="radio" id="radio-<?= $answer->id ?>-<?= $key ?>" class="regular-radio" name="q[<?= $id ?>][response]" value="<?= $answer->id ?>" <?php echo $checked ? 'checked' : null; ?>/>
                <label for="radio-<?= $answer->id ?>-<?= $key ?>"></label>
                <label for="radio-<?= $answer->id ?>-<?= $key ?>"><?php echo $answer->title;?></label>
            </li>
        <?php } ?>
    <?php }else{ ?> 
        <li><?php echo __('Please add answer!', 'mfpoll') ?></li>
    <?php } ?>
    </ul>
    <input type="hidden" name="q[<?= $id ?>][qid]" value="<?= $id ?>"/>
</div>