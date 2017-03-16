<div class="question question-<?= $type ?> question-entry"  id="question-<?= $id ?>">
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
    <div class="numeric-input-group" id="number-input-<?= $id ?>">
        <span class="fa fa-envelope"></span>
        <input type="text" name="q[<?= $id ?>][response]" class="email-input" id="email-input-<?= $id ?>" placeholder="<?= __('E-mail', 'mfpoll')?>" value="<?= $value ?>"/>
        <p class="not-email"><?= __('This is not email address!', 'mfpoll')?></p>
    </div>
    <input type="hidden" name="q[<?= $id ?>][qid]" value="<?= $id ?>"/>
    <script>
        jQuery(function () {
            jQuery('#email-input-<?= $id ?>').focusout(function(){
                var matches = this.value.match(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
                if(!matches){
                    jQuery('#question-<?= $id ?> .not-email').css('display', 'block');
                }else{
                    jQuery('#question-<?= $id ?> .not-email').css('display', 'none');
                }
            });
        });
    </script>
</div>