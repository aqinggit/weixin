<?php

use mysql_xdevapi\Session;

class CompetitionController extends Q
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionRank()
    {
        $this->render('rank');
    }

    public function actionAnswer()
    {
        $phone = zmf::val('phone');
        $phone = '13340685430';
        if (!$phone) {
            $this->redirect('index');
        }
        $questions = [];
        if (isset($_POST['yt1'])) {
            $ids = zmf::val('ids');
            $ids = explode(',', $ids);
            if (count($ids) != 15) {
                $this->message(0, '客官,您这是什么操作!');
            }
            foreach ($ids as $k=>$id) {
                $question = Questions::getOne($id);
                $questions[]=$question;
                $answers = zmf::val($id);
                if ($answers) {
                    if ($answers != $question['answers']){
                        $questions[$id]['analysisStatus'] = 2;
                    }
                } else {
                    $questions[$k]['analysis'] = '您这还没做完唷!';
                    $questions[$k]['analysisStatus'] = 1;
                }
            }
        } else {
            //DX
            $_questions = Questions::model()->findAll([
                'condition' => 'type =1',
                'limit' => 5,
                'order' => 'rand()'
            ]);
            //DXS
            $questions = array_merge($questions, $_questions);
            $_questions = Questions::model()->findAll([
                'condition' => 'type =2',
                'limit' => 5,
                'order' => 'rand()'
            ]);
            //pD
            $questions = array_merge($questions, $_questions);
            $_questions = Questions::model()->findAll([
                'condition' => 'type =3',
                'limit' => 5,
                'order' => 'rand()'
            ]);
            $questions = array_merge($questions, $_questions);
        }

        $ids = [];
        foreach ($questions as $question) {
            $content = $question->content;
            $answers = explode("</p>", $content);
            foreach ($answers as $k => $answer) {
                $answer = strip_tags($answer);
                $answer = trim($answer);
                if (!$answer) {
                    unset($answers[$k]);
                } else {
                    $answers[$k] = $answer;
                }
            }
            $ids[] = $question['id'];
            $question->content = $answers;
            $questions[$question['id']] = $question;
        }
        $ids = join(',', $ids);
        $data = [
            'questions' => $questions,
            'ids' => $ids,
            'phone' => $phone
        ];
        $this->render('answer', $data);
    }

    // Uncomment the following methods and override them if needed
    /*
    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array(
            'inlineFilterName',
            array(
                'class'=>'path.to.FilterClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }

    public function actions()
    {
        // return external action classes, e.g.:
        return array(
            'action1'=>'path.to.ActionClass',
            'action2'=>array(
                'class'=>'path.to.AnotherActionClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }
    */
}