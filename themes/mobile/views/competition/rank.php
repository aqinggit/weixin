<style>
    .rank {
        width: 100%;
        height: 100%;
        position: absolute;
        background: url("http://cqfb.people.com.cn/h5/20190403zs/img/bg.jpg") no-repeat;
        background-size: 100% 100%;
    }

    .box {
        height: 300px;
        width: 90%;
        overflow: auto;
        background: #fff;
        border-radius: 10px;
        border: 2px solid #c91f19;
        margin: 0 auto;

    }

    .title span {
        float: left;
        display: inline-block;
        text-align: center;
        line-height: 50px;
        color: #c91f19;
    }

    .title {
        padding: 0 15px;
    }

    .mui-table-view {
        position: relative;
        margin-bottom: 0;
        padding-left: 0;
        list-style: none;
        background-color: #fff;
    }

    .mui-scroll {
        position: relative;
        z-index: 1;

    }

    .mui-table-view-cell {
        position: relative;
        overflow: hidden;
        padding: 8px 15px;

    }

    .mui-table-view span {
        float: left;
        display: inline-block;
        text-align: center;
    }

    li {
        list-style-type: none;
        list-style-position: outside;
        border: 0;
    }

    .mui-table-view:before {
        position: absolute;
        right: 0;
        left: 0;
        height: 1px;
        content: '';
        -webkit-transform: scaleY(.5);
        transform: scaleY(.5);
        background-color: #c8c7cc;
        top: -1px;
    }

    .mui-table-view-cell:after {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 15px;
        height: 1px;
        content: '';
        -webkit-transform: scaleY(.5);
        transform: scaleY(.5);
        background-color: #c8c7cc;
    }

    .tab01 {
        width: 20%;
    }

    .tab02 {
        width: 50%;
    }

    .tab03 {
        width: 30%;
    }

    .rank p {
        font-size: 17px;
        color: #999999;
        margin: 15px 0px 15px 18px;
    }

    .homebtn {
        position: absolute;
        z-index: 98;
        bottom: 15%;
        border-radius: 10px;
        padding: 10px 50px;
        left: 50%;
        font-size: 16px;
        margin-left: -83px;
        color: #c91f19;
        border: 1px solid #c91f19;
        background: #fff;
    }

    .bottom_img {
        position: absolute;
        height: 16%;
        bottom: 0;
        left: 0;
        width: 100%;
    }

    .navbar {
        width: 33.33%;
        float: left;
        padding: 10px 0;
        position: relative;
    }

    .navbar .radio-wrap {
        width: 26px;
        height: 21px;
        position: relative;
        display: inline-block;
    }

    .navbar input[type='radio'] {
        opacity: 0;
    }

    .nav a {
        width: 50%;
    }

    .select {
        font-size: 16px;
        border-radius: 10px;
        border: 2px solid rgb(201, 31, 25) !important;
    }

    .nav-box {
        font-size: 16px;
        border-radius: 10px;
        border: 2px solid rgb(201, 31, 25) !important;
        margin-top: 10px;
        width: 90%;
        margin-left: 5%;
        margin-right: 5%;
    }

    .select-box {
        margin-top: 80px;
        width: 90%;
        margin-left: 5%;
        margin-right: 5%;
    }
</style>
<div class="rank">
    <div class="weui-navbar nav nav-box">
        <a href="<?php echo Yii::app()->createUrl('Competition/rank', ['type' => 'Department', 'phone' => zmf::val('phone')]); ?>">
            <div class="weui-navbar__item <?php echo $type == 'Department' ? ' weui-bar__item_on' : ''; ?>">
                部门
            </div>
        </a>
        <a href="<?php echo Yii::app()->createUrl('Competition/rank', ['type' => 'Street', 'phone' => zmf::val('phone')]); ?>">
            <div class="weui-navbar__item <?php echo $type == 'Street' ? ' weui-bar__item_on' : ''; ?>">
                街道
            </div>
        </a>
    </div>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'questions-form',
        'enableAjaxValidation' => false,
        'action' => 'answer.html'
    )); ?>

    <label>
        <input value="<?php echo zmf::val('phone') ?>" name="phone" hidden>
    </label>

    <label>
        <input value="<?php echo $type ?>" name="type" hidden>
    </label>

    <div class="weui-cells select-box">
        <div class="weui-cell weui-cell_select">
            <div class="weui-cell__bd">
                <select class="weui-select select" name="selectType">
                    <option value="0">请选择</option>
                    <?php foreach ($items as $k => $item) { ?>
                        <option value="<?php echo $k; ?>"><?php echo $item; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <p><?php echo $type == 'Department' ? '部门' : '街道'; ?>排名</p>
    <div class="mui-scroll box">
        <div class="title">
            <span style="width: 20%;">名次</span>
            <span style="width: 50%;">部门</span>
            <span style="width: 30%;">得分</span>
        </div>
        <ul class="mui-table-view" style="margin-top: 50px;">
            <?php $x = 1;
            foreach ($score as $k => $_score) { ?>
                <li class="mui-table-view-cell">
                    <span class="tab01"><?php echo $x; ?></span>
                    <span class="tab02"><?php echo $k; ?></span>
                    <span class="tab03"><?php echo $_score; ?></span>
                </li>
                <?php $x = $x + 1;
            } ?>
        </ul>
    </div>
    <button class="homebtn">开始答题</button>
    <div>
        <img class="bottom_img" src="http://cqfb.people.com.cn/h5/20190403zs/img/bottom.png" alt="建國">
    </div>
    <?php $this->endWidget(); ?>
</div>
