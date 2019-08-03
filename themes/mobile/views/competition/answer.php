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
        overflow: hidden;
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
            <p style="font-size: 17px;font-weight: bold;padding: 25px 15px">1.志愿者活动有什么意义？</p>
            <div class="weui-cells weui-cells_radio" style="margin-top: 0">
                <label class="weui-cell weui-check__label" for="x11">
                    <div class="weui-cell__bd">
                        <p>A.cell standard</p>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="radio" class="weui-check" name="radio1" id="x11">
                        <span class="weui-icon-checked"></span>
                    </div>
                </label>
                <label class="weui-cell weui-check__label" for="x12">

                    <div class="weui-cell__bd">
                        <p>B.cell standard</p>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="radio" name="radio1" class="weui-check" id="x12" checked="checked">
                        <span class="weui-icon-checked"></span>
                    </div>
                </label>
                <label class="weui-cell weui-check__label" for="x13">

                    <div class="weui-cell__bd">
                        <p>C.cell standard</p>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="radio" name="radio1" class="weui-check" id="x13" checked="checked">
                        <span class="weui-icon-checked"></span>
                    </div>
                </label>
                <label class="weui-cell weui-check__label" for="x14">

                    <div class="weui-cell__bd">
                        <p>D.cell standard</p>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="radio" name="radio1" class="weui-check" id="x14" checked="checked">
                        <span class="weui-icon-checked"></span>
                    </div>
                </label>
            </div>
        </div>
    </div>
    <div>
        <img class="bottom_img" src="http://cqfb.people.com.cn/h5/20190403zs/img/bottom.png" alt="建國">
    </div>
    <div class="btn">
        <button class="button01-1">上一題</button>
        <button class="button02-2">下一題</button>
    </div>
</div>