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
    <p class="point-to-assign"><?= __('Points', 'mfpoll')?>: <span id="points-assign-<?= $id ?>">0</span> / <span class="max-point-assign"><?php echo $options['points']; ?></span></p>
    <?php if (count($answers) != 0) { ?>
    <div class="dropdown-select">
        <ul id="assigning-points-<?= $id ?>" class="assigning-points">
            <?php foreach ($answers as $key => $answer) {
                $answer = (object) $answer;
                $value = null;
                if (isset($respond['response'][$answer->id])) {
                    $value = $respond['response'][$answer->id]['points'];
                }
                ?>
                <li>
                    <input type="text" name="q[<?= $id ?>][response][<?= $answer->id ?>][points]" class="numeric-input" id="points-<?= $answer->id ?>" value="<?= $value ?>"> 
                    <label for="points-<?= $answer->id ?>"><?= $answer->title ?></label>
                    <input type="hidden" name="q[<?= $id ?>][response][<?= $answer->id ?>][id]" value="<?= $answer->id ?>">
                </li>
            <?php } ?>
        </ul>
    </div>
    <?php } else { ?> 
        <p><?php echo __('Please add answer!', 'mfpoll') ?></p>
    <?php } ?>
    <script>
        jQuery(function () {
            var points_assign = 0;
            var max_point_assign = <?php echo $options['points']; ?>;
            
            jQuery("#assigning-points-<?= $id ?> .numeric-input").keyup(function (e) {
                this.value = this.value.replace(/[^0-9\.]/g,'');
                this.value = this.value.replace(/^0+/g,'0');
                this.value = this.value.replace(/^0+/g,'0');
                var matches = this.value.match(/0.+/g);
                if(matches != null){
                    this.value = this.value.replace(/^0/g,'');
                }
                
                points_assign = 0;
                jQuery("#assigning-points-<?= $id ?> .numeric-input").each(function(){
                    if(this.value){   
                        points_assign = points_assign + parseInt(this.value);
                    }
                });
                
                console.log(points_assign);
                var tmp = 0;
                if(max_point_assign < points_assign){
                    points_assign = points_assign - this.value;
                    tmp = max_point_assign - points_assign;
                    this.value = tmp;
                }
                
                jQuery("#points-assign-<?= $id ?>").html(points_assign + tmp);
            });
            jQuery("#assigning-points-<?= $id ?> .numeric-input").each(function(){
                if(this.value){   
                    points_assign = points_assign + parseInt(this.value);
                }
            });
            jQuery("#points-assign-<?= $id ?>").html(points_assign);
        });
    </script>
    <input type="hidden" name="q[<?= $id ?>][qid]" value="<?= $id ?>"/>
</div>