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
        width: 45%;
        display: inline-block;
        color: #c91f19;
        font-size: 12px;
        position: absolute;
        left: 5%;
        top: 38%;
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
    .margin0{
        margin-top: 0;
    }
</style>

<div class="answer">
    <div style="margin: 0 auto;padding: 0;">
        <div class="content">
            <div class="header" style="margin-top: 8%;">
                <span class="tips">-左右滑动切换题目-</span>
                <span class="title">第<em>1/10</em>题</span>
            </div>
        </div>
    </div>
    <div class="mui-slider">
        <div class="mui-slider-group">
            <?php foreach ($questions1 as $question) {
                $this->renderPartial('select',['question'=>$question]);
            }?>
            <?php foreach ($questions2 as $question) {
                $this->renderPartial('Mselect',['question'=>$question]);
            }?>
            <?php foreach ($questions3 as $question) {
                $this->renderPartial('judge',['question'=>$question]);
            }?>
        </div>
    </div>
    <div>
        <img class="bottom_img" src="http://cqfb.people.com.cn/h5/20190403zs/img/bottom.png" alt="建國">
    </div>
    <div class="btn">
        <button class="button01-1">返回</button>
        <button class="button02-2">交卷</button>
    </div>
</div>