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
        //得分
        $score = 0;
        //答题数量
        $count = 0;
        if (isset($_POST['yt1']) OR isset($_POST['yt0'])) {
            $ids = zmf::val('ids');
            $ids = explode(',', $ids);
            if (count($ids) != 15) {
                $this->message(0, '客官,您这是什么操作!');
            }
            foreach ($ids as $k => $id) {
                $question = Questions::getOne($id);
                $questions[] = $question;
                $answers = zmf::val($id, 3);
                if ($answers) {
                    $count = $count + 1;
                    $answer = $question['answers'];
                    if ($question['type'] == 3) {
                        $answer = ($answer == '对' && $question['type'] == 3) ? "A" : "B";
                    }
                    if ($question['type'] == 2) {
                        $answers = join('', $answers);
                    }
                    if ($answers != $answer) {
                        if (isset($_POST['yt1'])) {
                            $questions[$k]['analysisStatus'] = 2;
                        }
                    } else {
                        if (isset($_POST['yt1'])) {
                            $score = $score + $question['score'] + 1;
                        }
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
                    switch ($k) {
                        case 0:
                            $item = 'A';
                            break;
                        case 1:
                            $item = 'B';
                            break;
                        case 2:
                            $item = 'C';
                            break;
                        case 3:
                            $item = 'D';
                            break;
                        case 4:
                            $item = 'E';
                            break;
                        case 5:
                            $item = 'F';
                            break;
                        case 6:
                            $item = 'G';
                            break;
                        case 7:
                            $item = 'H';
                            break;
                        case 8:
                            $item = 'K';
                            break;
                    }
                    $answers[$k] = ['title' => $answer, 'item' => $item];
                }
            }
            $ids[] = $question['id'];
            $question->content = $answers;
        }
        $ids = join(',', $ids);
        $data = [
            'questions' => $questions,
            'ids' => $ids,
            'phone' => $phone,
            'score' => $score,
            'count' => $count,
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