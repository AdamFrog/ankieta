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
    <?php if(count($answers) != 0){ ?>
    <table class="table-answer" cellpadding="0">
        <thead>
            <tr>
                <th></th>
                <?php foreach ($answers as $key => $answer) { 
                    $answer = (object) $answer;
                    if($answer->type == 'answer'){continue;}
                ?>
                <th>
                    <?= $answer->title ?>
                </th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($answers as $key => $answer) { 
                $answer = (object) $answer;
                if($answer->type == 'scale'){continue;}
            ?>
            <tr>
                <td class="answer-td">
                    <?= $answer->title ?>
                </td>
                <?php foreach ($answers as $key_scale => $scale) { 
                    $scale = (object) $scale;
                    if($scale->type == 'answer'){continue;}
                    
                    $checked = false;
                    if(isset($respond['response']) && !isset($_POST['q'])){
                        if(isset($respond['response'][$answer->id])){
                            if($respond['response'][$answer->id] == $scale->id){
                                $checked = true;
                            }
                        }
                    }
                ?>
                <td class="scale-td">
                    <input type="radio" id="radio-<?= $scale->id ?>-<?= $key_scale ?>-<?= $key ?>" class="regular-radio" name="q[<?= $id ?>][response][<?= $answer->id ?>]" value="<?= $scale->id ?>" <?php echo $checked ? 'checked' : null; ?>/>
                    <label for="radio-<?= $scale->id ?>-<?= $key_scale ?>-<?= $key ?>"></label>
                </td>
                <?php } ?>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php }else{ ?> 
        <p><?php echo __('Please add answer!', 'mfpoll') ?></p>
    <?php } ?>
    <input type="hidden" name="q[<?= $id ?>][qid]" value="<?= $id ?>"/>
</div>