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
    <div class="numeric-input-group" id="number-input-<?= $id ?>">
        <span class="number-icon">123</span>
        <input type="text" name="q[<?= $id ?>][response]" class="numeric-input" placeholder="<?= __('Enter number', 'mfpoll')?>" value="<?= $value ?>"/>
    </div>
    <input type="hidden" name="q[<?= $id ?>][qid]" value="<?= $id ?>"/>
    <script>
        jQuery(function () {
            jQuery("#number-input-<?= $id ?> input").keyup(function (e) {
                this.value = this.value.replace(/[^0-9\.]/g,'');
                this.value = this.value.replace(/^0+/g,'0');
                this.value = this.value.replace(/^0+/g,'0');
                var matches = this.value.match(/0.+/g);
                if(matches != null){
                    this.value = this.value.replace(/^0/g,'');
                }
            });
        });
    </script>
</div>