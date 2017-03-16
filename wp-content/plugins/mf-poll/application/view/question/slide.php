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
  
    <div class="slide">
        <span class="text-right"><?= $options['text_right'] ?></span>
        <span class="text-left"><?= $options['text_left'] ?></span>
        <div id="slider-<?= $id ?>" class="slide-container">
            <div class="ui-slider-handle custom-handle"><span></span></div>
        </div>
    </div>
    <?php 
        $value = null;
        if(isset($respond['response'])){
            $value = $respond['response'];
        }
    ?>
    <script>
        jQuery(function () {
            var handle = jQuery("#slider-<?= $id ?> .custom-handle span");
            var input = jQuery("#slider-<?= $id ?>-input");
            jQuery("#slider-<?= $id ?>").slider({
                min: 1,
                max: <?= $options['range'] ?>,
                value: <?= $value != null ? $value : $options['range'] / 2 ?>,
                create: function () {
                    handle.text(jQuery(this).slider("value"));
                },
                slide: function (event, ui) {
                    input.val(ui.value);
                    handle.text(ui.value);
                }
            });
        });
    </script>
    <input type="hidden" name="q[<?= $id ?>][response]" id="slider-<?= $id ?>-input" value="<?= $value ?>"/>
    <input type="hidden" name="q[<?= $id ?>][qid]" value="<?= $id ?>"/>
</div>