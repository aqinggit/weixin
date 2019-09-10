<style>
    .homepage {
        width: 100%;
        height: 100%;
        position: absolute;
        background: url("<?php echo zmf::config('baseurl') . 'jsCssSrc/images/competition-bg.jpg' ?>") no-repeat;
        background-size: 100% 100%;


    }

    .img1 {
        width: 270px;
        display: block;
        margin: 20px auto 6px auto;
    }

    .organizer {
        height: auto;
        /*text-align: center;*/
        font-weight: bold;
        line-height: 1.5em;
        font-family: 'Microsoft Yahei', 'Helvetica Neue', Helvetica, STHeiTi, Arial, sans-serif;
        margin-top: 10px;
        padding: 0 20px;
    }

    .box {
        width: 255px;
        height: 162px;
        margin: 40px auto;
        text-align: center;


    }

    .box p {
        margin: 3px auto;
    }

    .icon_box {
        width: 255px;
        height: 88px;
        display: flex;

    }

    .icon_box img {
        width: 60px;
        margin-right: 5px;
    }

    .phone {
        padding: 10px 15px;
        border: 1px solid rgba(0, 0, 0, .2);
        border-radius: 3px;
        outline: 0;
        background-color: #fff;
        -webkit-appearance: none;
        font-size: 16px;
        width: 150px;
        text-align: center;
        letter-spacing: 0.8px;


    }

    .color-9b {
        color: #9b9b9b;


    }

    .button01 {
        position: absolute;
        left: 0;
        top: 0;
        z-index: 10;
        width: 134px;
        background: #c81f18;
        color: #fff;
        font-size: 20px;
        text-align: center;
        border-radius: 10px;
        padding: 7px 0;
        border: 1px solid #c81f18;
        margin-right: 1%;
    }

    /*.button02 {*/
    /*    z-index: 10;*/
    /*    width: 134px;*/
    /*    background: #fdeee7;*/
    /*    border: 1px solid #c81f18;*/
    /*    color: #110f0f;*/
    /*    font-size: 20px;*/
    /*    text-align: center;*/
    /*    margin-left: 1%;*/
    /*    border-radius: 10px;*/
    /*    padding: 7px 0;*/
    /*}*/


    .bottom_img img {
        width: 100%;
    }

    .bottom-btn {
        margin: 0 auto;
        width: 140px;
        position: relative;
    }


</style>

<div class="homepage">
    <div style="padding: 20px 40px;text-align: center;font-weight:bold;margin-top:0 ;font-size: 16px">
        <p>弘扬社会主义法治精神<br>献礼新中国成立70周年</p>
    </div>

    <img src='<?php echo zmf::config('baseurl') . 'jsCssSrc/images/title.png' ?>' class="img1" alt="法治知识竞赛">
    <div class="organizer fs14" style="font-size: 10px">
        <span>主办单位:中共重庆市綦江区委政法委员会</span><br>
        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;中共重庆市綦江区委全面依法治区委员会办公室</span><br>
        <span>承办单位:重庆市綦江区法学会</span><br>

    </div>
    <div class="box">
        <div class="icon_box" style="margin-bottom: 10px">
            <img src="<?php echo zmf::config('baseurl') . 'jsCssSrc/images/competition1.png' ?>" alt="所在单位">
            <img src="<?php echo zmf::config('baseurl') . 'jsCssSrc/images/competition2.png' ?>" alt="竞赛答题">
            <img src="<?php echo zmf::config('baseurl') . 'jsCssSrc/images/competition3.png' ?>" alt="结果分享">
            <img src="<?php echo zmf::config('baseurl') . 'jsCssSrc/images/competition4.png' ?>" alt="综合排名">
        </div>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'questions-form',
        'enableAjaxValidation' => false,
        'action'=>'rank.html'
    )); ?>
        <p class="color-9b" style="margin-bottom: 10px;font-size: 16px">请输入您的手机号码</p>
        <input type="number" name="phone" maxlength="11" class="phone color-9b"><br>
    </div>

    <div class="bottom-btn">
        <button class="button01 ">我要参与</button>
    </div>
    <?php $this->endWidget(); ?>
</div>