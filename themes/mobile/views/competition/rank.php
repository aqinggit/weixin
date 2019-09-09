<style>
    .rank {
        width: 100%;
        height: 100%;
        position: absolute;
        background: url("http://cqfb.people.com.cn/h5/20190403zs/img/bg.jpg") no-repeat;
        background-size: 100% 100%;
    }

    .box {
        height: 48%;
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
    .bottom_img{
        position: absolute;
        height: 16%;
        bottom: 0;
        left: 0;
        width: 100%;
    }
</style>
<div class="rank">
    <p>个人名次排名</p>
    <div class="mui-scroll box">
        <div class="title">
            <span style="width: 20%;">名次</span>
            <span style="width: 50%;">其他名称</span>
            <span style="width: 30%;">参与人次</span>
        </div>
        <ul class="mui-table-view" style="margin-top: 50px;">
            <li class="mui-table-view-cell">
                <span class="tab01">1</span>
                <span class="tab02">張三</span>
                <span class="tab03">868</span>
            </li>
            <li class="mui-table-view-cell">
                <span class="tab01">2</span>
                <span class="tab02">李四</span>
                <span class="tab03">365</span>
            </li>
            <li class="mui-table-view-cell">
                <span class="tab01">3</span>
                <span class="tab02">王五</span>
                <span class="tab03">365</span>
            </li>
            <li class="mui-table-view-cell">
                <span class="tab01">4</span>
                <span class="tab02">李明</span>
                <span class="tab03">365</span>
            </li>
            <li class="mui-table-view-cell">
                <span class="tab01">6</span>
                <span class="tab02">張三</span>
                <span class="tab03">868</span>
            </li>
            <li class="mui-table-view-cell">
                <span class="tab01">7</span>
                <span class="tab02">李四</span>
                <span class="tab03">365</span>
            </li>
            <li class="mui-table-view-cell">
                <span class="tab01">8</span>
                <span class="tab02">王五</span>
                <span class="tab03">365</span>
            </li>
            <li class="mui-table-view-cell">
                <span class="tab01">9</span>
                <span class="tab02">李明</span>
                <span class="tab03">365</span>
            </li>
            <li class="mui-table-view-cell">
                <span class="tab01">10</span>
                <span class="tab02">王五</span>
                <span class="tab03">365</span>
            </li>
            <li class="mui-table-view-cell">
                <span class="tab01">11</span>
                <span class="tab02">李明</span>
                <span class="tab03">365</span>
            </li>
        </ul>
    </div>
    <button class="homebtn">开始答题</button>
    <div>
        <img class="bottom_img" src="http://cqfb.people.com.cn/h5/20190403zs/img/bottom.png" alt="建國">
    </div>
</div>
