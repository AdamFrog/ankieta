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
    <input type="file" name="files<?= $id ?>[]" id="file" class="inputfile-<?= $id ?> inputfile" data-multiple-caption="<?= __('{count} files selected', 'mfpoll')?>" multiple/>
    <label for="file" class="file-upload"><i class="fa fa-upload" aria-hidden="true"></i><span><strong><?= __('Select file', 'mfpoll')?></strong></span></label>
    <input type="hidden" name="q[<?= $id ?>][qid]" value="<?= $id ?>"/>
    <script>
        var inputs = document.querySelectorAll( '.inputfile-<?= $id ?>' );
        Array.prototype.forEach.call( inputs, function( input )
        {
            var label= input.nextElementSibling,
                labelVal = label.innerHTML;
            input.addEventListener( 'change', function( e )
            {
                var fileName = '';
                if( this.files && this.files.length > 1 )
                    fileName = ( this.getAttribute( 'data-multiple-caption') || '').replace('{count}', this.files.length);
                else
                    fileName = e.target.value.split('\\').pop();

                if (fileName)
                    label.querySelector('span').innerHTML = fileName;
                else
                    label.innerHTML = labelVal;
            });
        });
    </script>
</div>