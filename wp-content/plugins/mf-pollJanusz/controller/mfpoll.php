<?php

class MFPController_mfpoll {

    public function action_getpolls() {

        $model = MFPModel::factory('polls');
        $polls = $model->find_all('poll_id','!=','0');

        return json_encode($polls, JSON_NUMERIC_CHECK);
    }

    public function action_getquestions() {

        $model = MFPModel::factory('questions');
        $questions = $model->find_all('poll_id','=',$_GET['pollid']);

        return json_encode($questions, JSON_NUMERIC_CHECK);
    }


}

 ?>
