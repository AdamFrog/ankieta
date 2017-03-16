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
    <textarea rows="4" name="q[<?= $id ?>][response]"><?= $value ?></textarea>
    <input type="hidden" name="q[<?= $id ?>][qid]" value="<?= $id ?>"/>
</div>