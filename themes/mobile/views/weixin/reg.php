<style>
    .reg-tab {
        font-size: 14px;
        margin: 0;
    }

    .btn-color:hover {
        background-color: #007500;
    }

    .nav-menu {
        float: left;
        padding-right: 10px;
        font-size: 16px;
        color: #09bb07;
        padding-left: 5px;


    }

    .col-bac {
        background: #f7f7fa;
    }

    .col-fff {
        background-color: #fff;
    }
</style>

<div class="weui-search-bar clearfix  col-fff">
    <span class="nav-menu"><&nbsp;返回</span>
    <span class="nav-menu">登录</span>
    <span class="nav-menu">注册</span>
</div>
<div class="weui-cells weui-cells_form reg-tab">
    <div class="weui-cell col-bac">
        <div class="weui-cell__hd "><label class="weui-label">志愿者注册</label></div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">用户名</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="number" pattern="[0-9]*" placeholder="只允许数字字母下划线">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
        <div class="weui-cell__hd"></div>
        <div class="weui-cell__bd weui-cell_primary">
            <input class="weui-input" type="password" placeholder="8-20位密码">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">确认密码</label></div>
        <div class="weui-cell__hd"></div>
        <div class="weui-cell__bd weui-cell_primary">
            <input class="weui-input" type="password" placeholder="请再次输入密码">
        </div>
    </div>
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">性别</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="select1">
                <option selected="" value="1">男</option>
                <option value="2">女</option>

            </select>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">邮箱</label></div>
        <div class="weui-cell__hd"></div>
        <div class="weui-cell__bd weui-cell_primary">
            <input class="weui-input" type="text" placeholder="请输入邮箱">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
        <div class="weui-cell__hd"></div>
        <div class="weui-cell__bd weui-cell_primary">
            <input class="weui-input" type="tel" placeholder="请输入手机号">
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label for="" class="weui-label">出生日期</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="date" value="">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label for="" class="weui-label">真实姓名</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder="请输入真实姓名">
        </div>
    </div>


    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">民族</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="select1">
                <option selected="" value="1">汉族</option>
                <option value="2">蒙古族</option>
                <option value="3">回族</option>
                <option value="4">维吾尔族</option>
                <option value="5">苗族</option>
            </select>
        </div>
    </div>
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">政治面貌</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="select1">
                <option selected="" value="1">请选择</option>
                <option value="2">党员</option>
                <option value="3">预备党员</option>
                <option value="4">团员</option>

            </select>
        </div>
    </div>

    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">证件类型</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="select1">
                <option selected="" value="1">内地居民身份证</option>
                <option value="2">香港居民身份证</option>
                <option value="3">澳门居民身份证</option>
                <option value="4">台湾居民身份证</option>
                <option value="5">护照</option>
            </select>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">证件号码</label></div>
        <div class="weui-cell__hd"></div>
        <div class="weui-cell__bd weui-cell_primary">
            <input class="weui-input" type="text" placeholder="请输入证件号码">
        </div>
    </div>

    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">国家/地区</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="vol_nationality">
                <option value="1">中国</option>
                <option value="2">美国</option>
                <option value="3">英国</option>
            </select>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">详细地址</label></div>
        <div class="weui-cell__hd"></div>
        <div class="weui-cell__bd weui-cell_primary">
            <input class="weui-input" type="text" placeholder="请输入详细地址">
        </div>
    </div>
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">最高学历</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="vol_nationality">
                <option value="1">请选择</option>
                <option value="2">博士</option>
                <option value="3">硕士</option>
                <option value="4">大学本科</option>
            </select>
        </div>
    </div>
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">从业状况</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="vol_nationality">
                <option value="1">请选择</option>
                <option value="2">公务员</option>
                <option value="3">职员</option>
                <option value="4">工人</option>
            </select>
        </div>
    </div>
    <div class="weui-cell col-bac">
        <div class="weui-cell__hd "><label class="weui-label" style="width: 200px">服务类别（最多选择4个）</label></div>
    </div>
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">服务类别</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="vol_nationality">
                <option value="1">请选择服务类别</option>
                <option value="2">社区服务</option>
                <option value="3">生态环保</option>
            </select>
        </div>
    </div>
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">受邀加入项目</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="select1">
                <option selected="" value="1">是</option>
                <option value="2">否</option>

            </select>
        </div>
    </div>

    <label for="weuiAgree" class="weui-agree">
        <input id="weuiAgree" type="checkbox" class="weui-agree__checkbox">
        <span class="weui-agree__text">
        阅读并同意<a href="javascript:void(0);">《相关条款》</a>
    </span>
    </label>

</div>


<div class="weui-btn-area">
    <a class="weui-btn weui-btn_primary btn-color" href="javascript:" id="showTooltips">确定</a>
</div>



