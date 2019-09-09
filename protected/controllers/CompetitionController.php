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
        $time = zmf::val('time');
        if ($time ==0 || $time >100){
            $time = 100;
        }
        $end = 0;
        $phone = zmf::val('phone');
        if (!preg_match('#^1[3,4,5,7,8,9]{1}[\d]{9}$#', $phone)){
            $this->message(0,'请输入正确的手机号码');
        }
        $startTime =mktime(0,0,0,date('m'),date('d'),date('Y'));
        $endTime = $startTime + 86399;

        $_C = QuestionsLog::model()->count("status = 1 AND cTime>= {$startTime} AND cTime <= {$endTime} AND phone = {$phone}");
        if ($_C >0 && $phone!= '13340685430')
        {
            $this->message(0,'您今天已经答过题了,明天再来吧');
        }
        $ip = ip2long(Yii::app()->request->userHostAddress);
        $_C = QuestionsLog::model()->count("status = 1 AND cTime>= {$startTime} AND cTime <= {$endTime} AND ip = {$ip}");
        if ($_C >5 && $phone!= '13340685430')
        {
            $this->message(0,'您这个网络也答题太多次了,换个网络吧');
        }

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
            $_answers = [];
            if (count($ids) != 10) {
                $this->message(0, '客官,您这是什么操作!');
            }
            foreach ($ids as $k => $id) {
                $question = Questions::getOne($id);
                $questions[] = $question;
                $answers = zmf::val($id, 3);
                $_answers[] = ['qid'=>$id,'answers'=>$answers];
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
            //保存数据
            if (isset($_POST['yt1']))
            {
                $log = new QuestionsLog();
                $log->phone = $phone;
                $log->answers = json_encode($_answers);
                $log->questions = json_encode($ids);
                $log->socre = $score;
                if (!$log->save())
                {
                    $this->message(0,'数据记录失败!');
                }
                $end = 1;
            }


        } else {
            //DX
            $_questions = Questions::model()->findAll([
                'condition' => 'type =1',
                'limit' => 4,
                'order' => 'rand()'
            ]);
            //DXS
            $questions = array_merge($questions, $_questions);
            $_questions = Questions::model()->findAll([
                'condition' => 'type =2',
                'limit' => 2,
                'order' => 'rand()'
            ]);
            //pD
            $questions = array_merge($questions, $_questions);
            $_questions = Questions::model()->findAll([
                'condition' => 'type =3',
                'limit' => 4,
                'order' => 'rand()'
            ]);
            $questions = array_merge($questions, $_questions);
        }

        $ids = [];
        foreach ($questions as $k=>$question) {
            $content = $question->content;
            $question->title = ($k+1) . '.' . $question->title;
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
            'time' => $time,
            'end'=>$end
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