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
        if ($time == 0 || $time > 100) {
            $time = 100;
        }
        $end = 0;
        $phone = zmf::val('phone');
        if (!preg_match('#^1[3,4,5,7,8,9]{1}[\d]{9}$#', $phone)) {
            $this->message(0, '请输入正确的手机号码');
        }
        $startTime = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $endTime = $startTime + 86399;

        $_C = QuestionsLog::model()->count("status = 1 AND cTime>= {$startTime} AND cTime <= {$endTime} AND phone = {$phone}");
        if ($_C > 0 && $phone != '13340685430') {
            $this->message(0, '您今天已经答过题了,明天再来吧');
        }
        $ip = ip2long(Yii::app()->request->userHostAddress);
        $_C = QuestionsLog::model()->count("status = 1 AND cTime>= {$startTime} AND cTime <= {$endTime} AND ip = {$ip}");
        if ($_C > 5 && $phone != '13340685430') {
            $this->message(0, '您这个网络也答题太多次了,换个网络吧');
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
                $_answers[] = ['qid' => $id, 'answers' => $answers];
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
            if (isset($_POST['yt1'])) {
                $log = new QuestionsLog();
                $log->phone = $phone;
                $log->answers = json_encode($_answers);
                $log->questions = json_encode($ids);
                $log->socre = $score;
                if (!$log->save()) {
                    $this->message(0, '数据记录失败!');
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
        foreach ($questions as $k => $question) {
            $content = $question->content;
            $question->title = ($k + 1) . '.' . $question->title;
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
        $this->pageTitle = '知识竞赛';
        $data = [
            'questions' => $questions,
            'ids' => $ids,
            'phone' => $phone,
            'score' => $score,
            'count' => $count,
            'time' => $time,
            'end' => $end
        ];
        $this->render('answer', $data);
    }

    static function Department($key = 0)
    {
        $item = [
            1 => "区委办公室",
            2 => "区人大常委会办公室",
            3 => "区政府办公室",
            4 => "区政协办公室",
            5 => "区纪委监委机关",
            6 => "区委组织部",
            7 => "区委宣传部",
            8 => "区委统战部",
            9 => "区委政法委",
            10 => "区委网信办",
            11 => "区委编办",
            12 => "区委直属机关工委",
            13 => "区委老干局",
            14 => "区发展改革委",
            15 => "区教委",
            16 => "区科技局",
            17 => "区经济信息委",
            18 => "区公安局",
            19 => "区民政局",
            20 => "区司法局",
            21 => "区财政局",
            22 => "区人力社保局",
            23 => "区生态环境局",
            24 => "区住房城乡建委",
            25 => "区城管局",
            26 => "区交通局",
            27 => "区水利局",
            28 => "区农业农村委",
            29 => "区商务委",
            30 => "区文化旅游委",
            31 => "区卫生健康委",
            32 => "区退役军人事务局",
            33 => "区应急局",
            34 => "区审计局",
            35 => "区统计局",
            36 => "区医保局",
            37 => "区国资委",
            38 => "区林业局",
            39 => "区信访办",
            40 => "区大数据发展局",
            41 => "区招商投资局",
            42 => "区政务服务办",
            43 => "工业园区管委会",
            44 => "东部新城管委会（食品园区管委会）",
            45 => "旅游度假区管委会",
            46 => "区供销合作社 ",
            47 => "区法院",
            48 => "区检察院",
            49 => "民革区委会",
            50 => "民盟区委会",
            51 => "民进区委会",
            52 => "九三学社区委会",
            53 => "区工商联",
            54 => "区总工会",
            55 => "团区委",
            56 => "区妇联",
            57 => "区科协",
            58 => "区文联",
            59 => "区侨联",
            60 => "区残联",
            61 => "区委党校",
            62 => "区档案馆",
            63 => "区融媒体中心",
            64 => "区委党史研究室",
            65 => "区机关事务中心",
            66 => "区公共资源交易中心",
            67 => "区规划自然资源局",
            68 => "区市场监管局",
            69 => "区税务局",
            70 => "重庆煤监局渝南分局",
            71 => "区气象局",
            72 => "区烟草局",
            73 => "区公积金中心",
        ];
        if ($item[$key]) {
            return $item[$key];
        } else {
            return $item;
        }

    }

    static function Street($key = 0)
    {
        $item = [
            1 => "古南街道",
            2 => "文龙街道",
            3 => "三江街道",
            4 => "石角镇",
            5 => "东溪镇",
            6 => "赶水镇",
            7 => "打通镇",
            8 => "石壕镇",
            9 => "永新镇",
            10 => "三角镇",
            11 => "隆盛镇",
            12 => "郭扶镇",
            13 => "篆塘镇",
            14 => "丁山镇",
            15 => "安稳镇",
            16 => "扶欢镇",
            17 => "永城镇",
            18 => "新盛镇",
            19 => "中峰镇",
            20 => "横山镇",
        ];
        if ($item[$key]) {
            return $item[$key];
        } else {
            return $item;
        }

    }
}