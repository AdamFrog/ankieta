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
    <?php if (count($answers) != 0) { ?>
    <div class="dropdown-select">
        <select name="q[<?= $id ?>][response]" id="select-<?= $id ?>">
            <?php if(isset($options['text_default']) && $options['text_default'] != null){ ?>
            <option value=""><?= $options['text_default'] ?></option>
            <?php } ?>
            <?php foreach ($answers as $key => $answer) {

                $answer = (object) $answer;
                $selected = false;
                if (isset($respond['response'])) {
                    if ($respond['response'] == $answer->id) {
                        $selected = true;
                    }
                }
                ?>
                    <option value="<?= $answer->id ?>" <?php echo $selected ? 'selected' : null; ?>><?= $answer->title ?></option>
            <?php } ?>
        </select>
    </div>
    <?php } else { ?> 
        <p><?php echo __('Please add answer!', 'mfpoll') ?></p>
    <?php } ?>
    <script>
        jQuery(function () {
            jQuery("#select-<?= $id ?>").selectmenu({
                icons: { button: "fa fa-angle-down" },
            });
        });
    </script>
    <input type="hidden" name="q[<?= $id ?>][qid]" value="<?= $id ?>"/>
</div>