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
    <div class="numeric-input-group" id="date-input-<?= $id ?>">
        <span class="fa fa-calendar"></span>
        <input type="text" name="q[<?= $id ?>][response]" id="input-date-<?= $id ?>" value="<?= $value ?>"/>
    </div>
    <input type="hidden" name="q[<?= $id ?>][qid]" value="<?= $id ?>"/>
    <script>
    jQuery(function() {
        jQuery( "#input-date-<?= $id ?>" ).datepicker({dateFormat: 'yy-mm-dd'});
    });
    </script>
</div>