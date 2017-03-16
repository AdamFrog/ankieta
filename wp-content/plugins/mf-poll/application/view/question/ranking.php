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
    <ul id="sortable-<?= $id ?>" class="ranking">
        <?php if (count($answers) != 0) { ?>
            <?php if (!isset($respond['response']) && !is_array($respond['response'])) { ?>
                <?php foreach ($answers as $key => $answer) {
                    $answer = (object) $answer; ?>
                    <li>
                        <i class="fa fa-arrows-v" aria-hidden="true"></i>
                        <span><?= $key + 1 ?></span>. <?= $answer->title ?>
                        <input type="hidden" name="q[<?= $id ?>][response][]" value="<?= $answer->id ?>" disabled="disabled"/>
                    </li>
                <?php } ?>
            <?php } else { ?>
                <?php foreach ($respond['response'] as $key => $response) {
                    foreach ($answers as $answer) {
                        if($response == $answer->id){
                            $answer = (object) $answer; ?>
                            <li>
                                <i class="fa fa-arrows-v" aria-hidden="true"></i>
                                <span><?= $key + 1 ?>.</span> <?= $answer->title ?>
                                <input type="hidden" name="q[<?= $id ?>][response][]" value="<?= $answer->id ?>" />
                            </li>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } else { ?> 
            <li><?php echo __('Please add answer!', 'mfpoll') ?></li>
        <?php } ?>
    </ul>
    <script>
        jQuery(function () {
            jQuery("#sortable-<?= $id ?>").sortable({
                axis: "y",
                placeholder: "placeholder-sortable",
                activate: function( event, ui ) {
                    jQuery(this).find('li').each(function(index, value){
                        jQuery(this).find('input').removeAttr('disabled');
                    });
                },
                start: function(e, ui){
                    ui.placeholder.height(ui.item.height());
                },
                stop: function( event, ui ) {
                    jQuery(this).find('li').each(function(index, value){
                        jQuery(this).find('span').html(index + 1 + '.');
                    });
                },
            });
            jQuery("#sortable-<?= $id ?>").disableSelection();
        });
    </script>
    <input type="hidden" name="q[<?= $id ?>][qid]" value="<?= $id ?>"/>
</div>