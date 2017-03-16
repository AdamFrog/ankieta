<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of front
 *
 * @author Rafal
 */
class MFPController_Front {
    
    /**
     * Wyswietla JSON
     * @param array $array
     */
    protected function sendJson($array){
        header('Content-Type: application/json');
        echo json_encode($array);
        die();
    }
    
    public function before(){
        
        $poll_id = (int) $_GET['poll_id'];
        
        $this->__session_model = MFPModel::factory('Session')->start_session($poll_id);
        
        if(isset($_POST) && !empty($_POST)){
            
            //Zmienna dzieki której sprawdzimy czy możemy przenieść użytkownika do nastepnej strony formularza
            $status = true;
            
            if(isset($_POST['q'])){
                
                //Przejdziemy po odpowiedziach i je sprawdzimi sam js nie wystarczy
                foreach ($_POST['q'] as $question_response){
                    
                    //Odnajdziemy pytanie
                    $question = MFPModel::factory('Question');
                    $question = $question->find('id', '=', $question_response['qid']);
                    
                    //Utworzymy walidator
                    $validator = MFPValidator::factory($question->type);
                    if($response = $validator->valid((object) $question, (object) $question_response)){
                        //Jeśli tak to zapiszemy do sesji odpowiedź
                        $_SESSION['poll'][$poll_id]['q'][$question->id] = $question_response;
                        
                        if($question->type == 'add_attachment'){
                            $_SESSION['poll'][$poll_id]['q'][$question->id] = $response;
                        }
                        
                    }else{
                        //Jeżeli nie przeszło walidacji
                        $status = false;
                        
                    }
                    
                }
                
            }
            
            //Redirect jeśli pola zostały odpowiednio wypełnione.
            //Może byłoby lepsze rozwiązanie ale nie ma czasu.
            if($status){
                
                $poll = MFPModel::factory('Poll')->find('id', '=', $poll_id);
                
                switch ($poll->type) {
                    case 'poll':
                        $this->go_to_type_poll($poll);

                        break;

                    default:
                        $this->go_to_type_survey($poll);
                        
                        break;
                }

            }
            
        }
        
        
    }

    public function action_index(){
        
        $poll_id = (int) $_GET['poll_id'];
        
        $poll = MFPModel::factory('Poll')->find('id', '=', (int) $poll_id);
        
        $page = 1;
        if(isset($_GET['page'])){ $page = (int) $_GET['page']; }
        
        //Jeżeli nie wypełnił poprzedniej strony to redirect
        if($_SESSION['poll'][$poll_id]['page'] == '' && $page > 1){
            wp_redirect('/wordpress/ankieta/'.$poll_id);
        }else if($page > $_SESSION['poll'][$poll_id]['page'] && $page != 1){
            wp_redirect('/wordpress/ankieta/'.$poll_id.'/strona/' . $_SESSION['poll'][$poll_id]['page']);
        }
     
        $questions = MFPModel::factory('Question')->find_all('poll_id', '=', $poll_id, ' AND `page` = ' . $page);
        $questions_array = array();
        
        $count_page = MFPModel::factory('Question')->get_count_page($poll_id);
    
        
        foreach ($questions as $question){
            $answer_model = MFPModel::factory('Answer');
            $question->answers = $answer_model->find_all('question_id', '=', $question->id, 'ORDER BY `_order`');
            $questions_array[] = $question;
        }
        
        MFPView::get('template/index', [
            'header' => MFPView::render('template/header'),
            'footer' => MFPView::render('template/footer'),
            'poll' => $poll,
            'questions' => $questions_array,
            'pages' => $count_page,
            'page' => $page,
        ]);
        
    }
    
    public function action_save(){
        
        $poll_id = (int) $_GET['poll_id'];
        
        $response_model = MFPModel::factory('Response')->save_poll($poll_id);
        
        $this->__session_model->update_step('end');
        $this->__session_model->update_end();
        
        
        
        echo 'Podziekowanie';
        
    }
    
    protected function go_to_type_survey($poll){
        
        $count_page = MFPModel::factory('Question')->get_count_page($poll->id);
        $page = $_POST['page'];

        if($page < $count_page){
            //Jeżeli istnieje dalsza strona to przejdziemy do niej 
            $page++;
            //Ustawimy kolejna stronę
            $_SESSION['poll'][$poll->id]['page'] = $page;
            $this->__session_model->update_step('page-' . $page);
            wp_redirect('/wordpress/ankieta/'.$poll->id.'/strona/' . $page);
            exit();

        }else{
            //Przejdziemy do zapisu bo nie ma już dalszej strony
            wp_redirect('/wordpress/ankieta/'.$poll->id.'/podziekowanie');
            exit();
        }
        
    }
    
    protected function go_to_type_poll($poll){
        
        if(isset($_SESSION['redirect_to_page'])){
            $id = $_SESSION['redirect_to_page'];
            echo $id;
            //die();
            unset($_SESSION['redirect_to_page']);
            $_SESSION['poll'][$poll->id]['page'] = $id;
            wp_redirect('/wordpress/ankieta/'.$poll->id.'/strona/' . $id);
            exit();
        }
    }


}