<h1 class="poll-title"><?= $poll->title ?></h1>
<form method="POST" action="" enctype="multipart/form-data">
    <div id="poll-content">
        <?php foreach ($questions as $key => $question) { $question->options = json_decode($question->options, true); ?>
            <div class="question">
                <?php 
                    $question->respond = false;
                    if($arr = MFPArr::get($_POST['q'], $question->id, false)){
                        $question->respond = $arr;
                    }else if($arr = MFPArr::get($_SESSION['poll'][$poll->id]['q'], $question->id, false)){
                        $question->respond = $arr;
                    }
                    
                    echo MFPView::render('question/'. $question->type, (array)$question); 
                ?>
            </div>
        <?php } ?>
    </div>
    <div id="button-bar">
        <?php if($pages == 1){ ?>
            <button type="submit" class="btn btn-next"><?= __('Send', 'mfpoll'); ?></button>
        <?php }else if($page == 1 && $page < $pages){ ?>
            <button type="submit" class="btn btn-next"><?= __('Next', 'mfpoll'); ?></button>
        <?php }else if($page > 1 && $page < $pages){ ?>
            <a class="btn btn-prev" href="/wordpress/ankieta/<?= $poll->id ?>/strona/<?= $page - 1 ?>"><?= __('Prev', 'mfpoll'); ?></a>
            <button type="submit" class="btn btn-next"><?= __('Next', 'mfpoll'); ?></button>
        <?php }else if($page > 1 && $page == $pages){ ?>
            <a class="btn btn-prev" href="/wordpress/ankieta/<?= $poll->id ?>/strona/<?= $page - 1 ?>"><?= __('Prev', 'mfpoll'); ?></a>
            <button type="submit" class="btn btn-next"><?= __('Send', 'mfpoll'); ?></button>
        <?php } ?>
    </div>
    <input type="hidden" name="page" value="<?= $page ?>"/>
</form>