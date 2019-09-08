<?php

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
        //DX
        $questions1 = Questions::model()->findAll([
            'condition' => 'type =1',
            'limit' => 5,
            'order' => 'rand()'
        ]);
        foreach ($questions1 as $question1) {
            $content = $question1->content;
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
            $question1->content = $answers;
        }
        //DXS
        $questions2 = Questions::model()->findAll([
            'condition' => 'type =2',
            'limit' => 5,
            'order' => 'rand()'
        ]);
        foreach ($questions2 as $question2) {
            $content = $question2->content;
            $answers = explode("</p>",$content);
            foreach ($answers as $k => $answer) {
                $answer = strip_tags($answer);
                $answer = trim($answer);
                if (!$answer) {
                    unset($answers[$k]);
                } else {
                    $answers[$k] = $answer;
                }
            }
            $question2->content = $answers;
        }

        //PD
        $questions3 = Questions::model()->findAll([
            'condition' => 'type =3',
            'limit' => 5,
            'order' => 'rand()'
        ]);
        foreach ($questions3 as $question3) {
            $content = $question3->content;
            $answers = explode("</p>",$content);
            foreach ($answers as $k => $answer) {
                $answer = strip_tags($answer);
                $answer = trim($answer);
                if (!$answer) {
                    unset($answers[$k]);
                } else {
                    $answers[$k] = $answer;
                }
            }
            $question3->content = $answers;
        }

        $data = [
            'questions1' => $questions1,
            'questions2' => $questions2,
            'questions3' => $questions3
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