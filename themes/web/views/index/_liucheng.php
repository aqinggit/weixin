<style>
    .met-index-body {
        padding: 70px 0;
        background: #fff;
        position: relative;
        z-index: 2
    }

    .met-index-body:nth-of-type(odd) {
        background: #f5f5f5
    }

    .met-index-body h3 {
        font-size: 24px;
        margin-top: 0;
        text-align: center;
        margin-bottom: 0;
        color: #444
    }

    .met-index-body p.desc {
        font-size: 13px;
        text-align: center;
        width: 70%;
        color: #848484;
        margin: 0 auto;
        margin-bottom: 10px;
        font-family: "Microsoft YaHei"
    }
    .met-index-body p.subdesc{
        margin-bottom: 20px;
    }

    .met-index-body .anli_p p.desc {
        width: 60%;
        padding-right: 30px;
    }

    .met-index-service #serviceSlick {
        margin-top: 30px
    }

    .met-index-service .index_service_icon {
        display: block;
        width: 100%;
        text-align: center
    }

    .met-index-service .service_item {
        box-sizing: border-box;
    }
    .met-index-service .service_item a:hover{
        text-decoration: none;
    }
    .met-index-service .service_item h4 {
        font-size: 16px;
        height: 46px;
        line-height: 46px;
        color: #595959;
        -webkit-transition: all ease-out .2s;
        transition: all ease-out .2s;
        border-bottom: 1px solid #e1e1e1;
        text-align: left;
        width: 100%;
        overflow: hidden;
    }
    .service_item h4:before {
        position: absolute;
        content: "";
        width: 10px;
        height: 1px;
        background-color: #3c3c3c;
        margin-top: 46px;
        -webkit-transition: all .6s cubic-bezier(.215, .61, .355, 1) 0s;
        transition: all .6s cubic-bezier(.215, .61, .355, 1) 0s;
    }

    .met-index-service .service_item img {
        width: 100%;
        margin: 0 auto
    }
    .service_item p{
        color: #848484;
        font-size: 13px;
        line-height: 24px;
        height: 50px;
        overflow: hidden;
        width: 100%;
        margin-top: 10px;
    }

    .met-index-service .slick-arrow {
        width: 20px
    }

    .met-index-service .slick-arrow.slick-next {
        right: -10px
    }

    .met-index-service [class*=blocks] li {
        margin: 50px 0 0;
        clear: none
    }

    .met-index-service [class*=blocks] li i {
        width: 120px;
        height: 120px;
        background: #eee;
        text-align: center;
        font-size: 50px;
        line-height: 120px;
        color: #5e7387;
        border-radius: 100%;
        transition: background .5s, color .5s;
        -moz-transition: background .5s, color .5s;
        -webkit-transition: background .5s, color .5s;
        -o-transition: background .5s, color .5s
    }

    .met-index-service [class*=blocks] li:hover i {
        background: #4e97d9;
        color: #fff
    }

    .met-index-service [class*=blocks] li h4 {
        margin-top: 20px;
        margin-bottom: 5px;
        font-weight: 300;
        font-size: 20px;
        color: #2a333c
    }

    .met-index-service [class*=blocks] li p {
        width: 90%;
        margin: 0 auto;
        font-weight: 300;
        color: #5e7387;
        text-align: left
    }

    .met-index-service [class*=blocks] li a {
        text-decoration: none
    }

    .met-index-service [class*=blocks] li a:active, .met-index-service [class*=blocks] li a:focus, .met-index-service [class*=blocks] li a:hover {
        text-decoration: none
    }

    .met-index-service [class*=blocks] li a img {
        width: 100%
    }




    .i-adv .content {
        margin-top: 0;
        background: #fff;
        height: 577px;
        border-radius: 10px;
    }

    .i-adv .content ul {
        padding-top: 46px;
    }

    .i-adv .content ul li {
        float: left;
        margin-left: 36px;
        transition: all .5s;
    }

    .i-adv .content ul li:hover {
        margin-top: -20px;
    }
    .i-adv .content ul li:hover a{
        text-decoration: none;
    }

    .i-adv .content ul li img {
        width: 350px;
        height: 198px;
        position: relative;
        z-index: 9;
    }

    .i-adv .content ul li .nei {
        position: relative;
        width: 310px;
        height: 234px;
        top: -35px;
        box-shadow: 0 0 4px #cacaca;
        margin: 0 auto;
        z-index: 999;
        background: #fff;
        border-radius: 10px;
    }

    .i-adv .content ul li .nei h3 {
        color: #333333;
        font-size: 20px;
        font-weight: 600;
        background: url(http://www.cqlaj.com/template/default/images/tt1.jpg) no-repeat bottom center;
        line-height: 71px;
        text-align: center;
    }

    .i-adv .content ul li .nei p {
        padding: 0 31px;
        color: #333333;
        font-size: 16px;
        text-align: center;
        font-size: 16px;
        line-height: 30px;
        padding-top: 6px;
    }

    .i-adv .content ul li .nei .more {
        background: url(http://www.cqlaj.com/template/default/images/more.jpg) center;
        width: 186px;
        height: 38px;
        text-align: center;
        line-height: 38px;
        font-size: 14px;
        color: #fff;
        position: absolute;
        bottom: 25px;
        left: 50%;
        margin-left: -93px;
        text-transform: uppercase;
    }

    .i-adv .dh {
        width: 320px;
        height: 40px;
        margin: 8px auto 0;
        text-align: center;
    }

    .i-adv .dh span {
        display: inline-block;
        width: 137px;
        line-height: 40px;
        text-align: center;
        font-size: 15px;
        color: #ffffff;
        background: #0baae4;
        border-bottom-left-radius: 5px;
        border-top-left-radius: 5px;
        border: 1px solid #0baae4;
        box-sizing: border-box;
        float: left;
    }

    .i-adv .dh p {
        color: #1170b8;
        font-weight: 600;
        display: inline-block;
        width: auto;
        text-align: center;
        line-height: 40px;
        font-size:13px;
        border: 1px solid #0baae4;
        border-left: 0;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        padding: 0 50px;
        box-sizing: border-box;
        float: left;
    }

</style>

<div class="met-index-service met-index-body">
    <div class="container i-adv">
        <h3>集装箱房屋服务</h3>
        <p class="desc">—— service ——</p>
        <div class="content ">
            <ul class="clearfix">
                <li>
                    <a target="_blank">
                        <img border="0" src="http://www.cqlaj.com/data/images/slide/20180518095043_286.png" title="重庆集装箱房出租" alt="重庆集装箱房出租">
                        <div class="nei">
                            <h3>重庆集装箱房出租</h3>
                            <p>乐安居集装箱始创于2007年，集装箱房出租经验丰富</p>
                            <div class="more">
                                more
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a target="_blank">
                        <img border="0" src="http://www.cqlaj.com/data/images/slide/20180518095058_308.png" title="重庆集装箱房出租" alt="重庆集装箱房出租">
                        <div class="nei">
                            <h3>重庆集装箱房出租</h3>
                            <p>围墙、移动卫生间、活动岗亭、警用岗亭、铁架床、空调等集装箱房配套设施出租服务</p>
                            <div class="more">
                                more
                            </div>
                        </div>
                    </a>
                </li>
                <li><a target="_blank">
                        <img border="0" src="http://www.cqlaj.com/data/images/slide/20180518095122_422.png" title="集装箱活动房租赁" alt="集装箱活动房租赁">
                        <div class="nei">
                            <h3>集装箱活动房租赁</h3>
                            <p>集装箱活动房安全舒适、绿色环保、经济实惠、坚固耐用、安装便捷、可多次循环使用</p>
                            <div class="more">
                                more
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="dh">
                <span>咨询热线</span>
                <p><?php echo zmf::config('sitePhone');?></p>
            </div>
        </div>
    </div>
</div>




<div class="met-index-service met-index-body">
    <div class="container">
        <h3>集装箱房屋服务流程</h3>
        <p class="desc">—— service ——</p>
        <p class="desc">众盒集装箱网提供专业的集装箱设计,集装箱生产,集装箱施工,集装箱改造等一站式服务,为客户提供专业的集装箱设计,创意集装箱改造等服务,众盒设计团队是一个具有现代超前的审美品味和设计理念的团队，拥有一套能够与客户真正实现无缝对接的设计服务体系。</p>
        <div class="row">
            <div class="service_item col-xs-3 col-sm-3"> <a href="javacript:;" title="项目现场勘察">
                    <img class="img-responsive" alt="项目现场勘察" src="http://www.zhonghebox.com/uploads/181115/1-1Q1151Z42R15.png" />
                    <h4>项目现场勘察</h4>
                    <p>经初步洽谈，若确定设计合同意向。则支付设计定金，设计师前往看场地，三至五个工作日，设计师会综合自身专业意见以及客户具体要求出具设计方案。</p>
                </a>
            </div>

            <div class="service_item col-xs-3 col-sm-3">
                <a href="javacript:;" title="集装箱房屋设计">
                    <img class="img-responsive" alt="集装箱房屋设计" src="http://www.zhonghebox.com/uploads/171228/1-1G22P9321T23.png" />
                    <h4>集装箱房屋设计</h4>
                    <p>我们的设计团队来源于国内顶尖建筑设计公司的核心成员，具有高水平审美品位和前卫设计理念。众盒将为您提供趋近完美的设计服务。</p>
                </a>
            </div>

            <div class="service_item col-xs-3 col-sm-3">
                <a href="javacript:;" title="集装箱房屋施工"> <img class="img-responsive" alt="集装箱房屋施工" src="http://www.zhonghebox.com/uploads/171228/1-1G22P93413W8.png" />
                    <h4>集装箱房屋施工</h4>
                    <p>厂房面积超11000平方米，标准化高科技产品展示。10个生产班组可以同时展开流水作业，生产车间有员工70多人，按时高效交付高品质产品。设计方案确定后，通常在45天完成验收高性比的集装箱房屋，顶尖设计方案+高效率生产施工=高品质产品。</p>
                </a>
            </div>

            <div class="service_item col-xs-3 col-sm-3">
                <a href="javacript:;" title="集装箱房屋安装"> <img class="img-responsive" alt="集装箱房屋安装" src="http://www.zhonghebox.com/uploads/181112/1-1Q1121K61a58.png" />
                    <h4>集装箱房屋安装</h4>
                    <p>设计方案确定后，通常在35天完成验收。施工团队亲自上门安装。高性比的集装箱房屋，顶尖设计方案+高效率生产施工=高品质产品。</p>
                </a>
            </div>
        </div>
    </div>
</div>