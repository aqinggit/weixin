<style>
    .answer {
        width: 100%;
        height: 100%;
        position: absolute;
        background: url("http://cqfb.people.com.cn/h5/20190403zs/img/bg.jpg") no-repeat;
        background-size: 100% 100%;
    }

    .bottom_img {
        position: absolute;
        height: 16%;
        bottom: 0;
        left: 0;
        width: 100%;
    }

    .mui-slider {

        margin-top: 25%;
        height: 65%;
        background: rgb(255, 255, 255);
        border-radius: 10px;
        position: absolute;
        z-index: 1;
        overflow: auto;
        width: 90%;
        margin-left: 5%;

    }

    .mui-slider .mui-slider-group {
        font-size: 0;
        position: relative;
        -webkit-transition: all 0s linear;
        transition: all 0s linear;
        white-space: nowrap;

    }

    .content .header .title {
        font-size: 16px;
        float: right;
        margin-top: 2%;
        margin-right: 4%;
    }

    .content .header .tips {
        width: 30%;
        display: inline-block;
        color: #c91f19;
        font-size: 13px;
        position: absolute;
        left: 5%;
        top: 38%;
    }

    .time {
        width: 25%;
        position: absolute;
        left: 45%;
        top: 33%;
        font-size: 16px;
        font-weight: bold;

    }

    .title {
        padding: 0 15px;
    }

    .content {
        height: 80%;
        overflow: hidden;
        position: absolute;
        width: 90%;
        margin-left: 5%;
        margin-top: 5%;
    }

    .content .header {
        overflow: hidden;
        position: relative;
        margin-top: 30px;
    }

    .button01-1 {
        z-index: 10;
        width: 48%;
        color: #c91f19;
        font-size: 20px;
        text-align: center;
        border-radius: 10px;
        padding: 7px 0;
        border: 1px solid #c91f19;
        margin-right: 1%;
        background: #fff;
    }

    .button02-2 {
        z-index: 10;
        width: 48%;
        color: #c91f19;
        font-size: 20px;
        text-align: center;
        border-radius: 10px;
        padding: 7px 0;
        border: 1px solid #c91f19;
        margin-right: 1%;
        background: #fff;

    }

    .btn {
        position: absolute;
        width: 70%;
        margin-left: 15%;
        bottom: 12%;
    }

    .content .header .title em {
        color: #c91f19;
        font-size: 26px;
        padding: 0 10px;
    }

    .answer_title {
        font-size: 17px;
        font-weight: bold;
        padding: 25px 15px;
    }

    .margin0 {
        margin-top: 0;
    }

    .answer_title em {
        color: red;
    }

</style>

<div class="answer">
    <div style="margin: 0 auto;padding: 0;">
        <div class="content">
            <div class="header" style="margin-top: 8%">
                <span class="tips">-总计<?php echo count($questions) ?>-已答:<?php echo $count ?></span>
                <span id="time" class="time"></span>
                <span class="title"><em><?php echo $score; ?></em>分</span>
            </div>
        </div>
    </div>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'questions-form',
        'enableAjaxValidation' => false,
    )); ?>

    <div class="mui-slider">
        <div class="mui-slider-group">
            <?php foreach ($questions as $question) {
                switch ($question['type']) {
                    case 1:
                        $this->renderPartial('select', ['question' => $question]);
                        break;
                    case 2:
                        $this->renderPartial('Mselect', ['question' => $question]);
                        break;
                    case 3:
                        $this->renderPartial('judge', ['question' => $question]);
                        break;
                }
            } ?>
            <label>
                <input value="<?php echo $ids ?>" name="ids" hidden>
            </label>
            <label>
                <input value="<?php echo $phone ?>" name="phone" hidden>
            </label>
            <label>
                <input value="<?php echo $time ?>" name="time" hidden>
            </label>
            <label>
                <input value="<?php echo $type ?>" name="type" hidden>
            </label>
            <label>
                <input value="<?php echo $selectType ?>" name="selectType" hidden>
            </label>
        </div>
    </div>
    <div>
        <img class="bottom_img" src="http://cqfb.people.com.cn/h5/20190403zs/img/bottom.png" alt="建國">
    </div>
    <?php if (!$end) { ?>
        <div class="btn">
            <?php echo CHtml::submitButton('检查', array('class' => 'button02-2')); ?>
            <?php echo CHtml::submitButton('交卷', array('class' => 'button02-2', 'id' => 'fa')); ?>
        </div>
    <?php } ?>

    <?php $this->endWidget(); ?>
</div>
<?php if (!$end) { ?>
    <script>
        var times = <?php echo $time;?>;//剩余时间,单位秒
        var timeDiv = document.getElementById("time");
        var timeObj = null;

        function timer() {
            if (times === 0) {
                $("#fa").click();
                window.clearInterval(timeObj);
                return;
            }
            var t = Math.floor(times / 60) + "分" + times % 60 + "秒"
            timeDiv.innerHTML = t;
            times--;
        }

        timeObj = window.setInterval(timer, 1000);
    </script>
<?php } ?>