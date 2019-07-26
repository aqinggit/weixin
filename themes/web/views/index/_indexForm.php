<style>
    .index-form {
        background: #1d1e24;
    }
    .form-con {
        width: 1200px;
        min-width: 1200px;
        margin: 0 auto;
        text-align: center;
        padding-bottom: 50px;
    }
    .form-table {
        height: 50px;
        display: inline-block;
        margin-top: 21px;
        cursor: pointer;
    }
    .form-table-left {
        height: 100%;
        width: 1000px;
        box-sizing: border-box;
        border: 1px solid #e8e8e8;
        border-radius: 2px;
        background-color: #fff;
        font-size: 12px;
        color: #888;
        float: left;
        display: flex;
    }
    .table-con {
        padding: 0px 20px;
        border-right: 1px solid #e8e8e8;
        height: 49px;
        box-sizing: border-box;
        position: relative;
        width: 16.6666666%;
        overflow: hidden;
    }
    .table-con .icon{
        font-size: 20px;
        color: #888;
        line-height: 49px;
        width: 20px;
        position: absolute;
        left: 10px;
        top: 0;
    }
    .table-con .unit{
        width: 20px;
        position: absolute;
        right: 10px;
        top: 0;
        line-height: 50px;
    }
    .table-con .start {
        font-size: 14px;
        color: #888888;
        padding-top: 3px;
        position: absolute;
        top: 0px;
        left: 77px;
    }
    .table-con input,.table-con select {
        font-size: 12px;
        color: #333;
        outline: none;
        border: 0px;
        padding-left: 20px;
        height: 50px;
        line-height: 50px;
        box-sizing: border-box;
        width: 100%;
        -webkit-appearance: none;
        appearance: none;
    }
    .table-icon {
        margin-top: 12px;
        float: left;
    }
    .form-table-right {
        display: inline-block;
        width: 160px;
        height: 50px;
        border-radius: 5px;
        background-color: #d9000f;
        float: right;
        color: #fff;
        text-align: center;
        line-height: 50px;
        font-size: 20px;
        margin-left: 5px;
    }

</style>


<div class="index-form">
    <div class="form-con">
        <div style="text-align:center;padding-top:35px;font-size:18px;color:#fff">全国已有123户别墅家庭选择尚层装饰</div>
        <div class="form-table banner_table-con">
            <div class="form-table-left">
                <div class="table-con">
                    <span class="icon"><i class="fa fa-map-marker"></i></span>
                    <select id="JS_index_form_area" name="area">
                        <option city="www" value="https://www.shangceng.com.cn/" selected="selected">全国</option>
                    </select>
                </div>
                <div class="table-con">
                    <span class="icon"><i class="fa fa-user"></i></span>
                    <input placeholder="姓名" id="JS_index_form_name">
                </div>
                <div class="table-con">
                    <span class="icon"><i class="fa fa-inbox"></i></span>
                    <input placeholder="需求数量" maxlength="11" id="JS_index_form_num" name="num">
                    <span class="unit">个</span>
                </div>
                <div class="table-con">
                    <span class="icon"><i class="fa fa-home"></i></span>
                    <select id="JS_index_form_type" name="type">
                        <option city="www" value="https://www.shangceng.com.cn/" selected="selected">类型</option>
                    </select>
                </div>
                <div class="table-con">
                    <span class="icon"><i class="fa fa-phone"></i></span>
                    <input class="table-phone" name="phone" placeholder="您的联系方式" maxlength="11" id="JS_index_form_phone">
                </div>
                <div class="table-con">
                    <span class="icon"><i class="fa fa-rmb"></i></span>
                    <input class="area_num" name="budget" placeholder="大概预算" id="JS_index_form_budget">
                    <span class="unit">元</span>
                </div>
            </div>
            <div class="form-table-right">立即预约</div>
        </div>
    </div>
</div>