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
    <span class="nav-menu"><a>返回</a></span>
    <span class="nav-menu"><a>登录</a></span>
    <span class="nav-menu"><a>注册</a></span>
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
            <select class="weui_select weui-select" name="vol_ethnicity" disabled="disabled">
                <option value="">请选择</option>
                <option value="4788" selected="">汉族</option>
                <option value="4789">蒙古族</option>
                <option value="4790">回族</option>
                <option value="4791">藏族</option>
                <option value="4792">维吾尔族</option>
                <option value="4793">苗族</option>
                <option value="4794">彝族</option>
                <option value="4795">壮族</option>
                <option value="4796">布依族</option>
                <option value="4797">朝鲜族</option>
                <option value="4798">满族</option>
                <option value="4799">侗族</option>
                <option value="4800">瑶族</option>
                <option value="4801">白族</option>
                <option value="4802">土家族</option>
                <option value="4803">哈尼族</option>
                <option value="4804">哈萨克族</option>
                <option value="4805">傣族</option>
                <option value="4806">黎族</option>
                <option value="4807">傈僳族</option>
                <option value="4808">佤族</option>
                <option value="4809">畲族</option>
                <option value="4810">高山族</option>
                <option value="4811">拉祜族</option>
                <option value="4812">水族</option>
                <option value="4813">东乡族</option>
                <option value="4814">纳西族</option>
                <option value="4815">景颇族</option>
                <option value="4816">柯尔克孜族</option>
                <option value="4817">土族</option>
                <option value="4818">达斡尔族</option>
                <option value="4819">仫佬族</option>
                <option value="4820">羌族</option>
                <option value="4821">布郎族</option>
                <option value="4822">撒拉族</option>
                <option value="4823">毛南族</option>
                <option value="4824">仡佬族</option>
                <option value="4825">锡伯族</option>
                <option value="4826">阿昌族</option>
                <option value="4827">普米族</option>
                <option value="4828">塔吉克族</option>
                <option value="4829">怒族</option>
                <option value="4830">乌孜别克</option>
                <option value="4831">俄罗斯族</option>
                <option value="4832">鄂温克族</option>
                <option value="4833">德昂族</option>
                <option value="4834">保安族</option>
                <option value="4835">裕固族</option>
                <option value="4836">京族</option>
                <option value="4837">塔塔尔族</option>
                <option value="4838">独龙族</option>
                <option value="4839">鄂伦春族</option>
                <option value="4840">赫哲族</option>
                <option value="4841">门巴族</option>
                <option value="4842">珞巴族</option>
                <option value="4843">基诺族</option>
                <option value="4845">其他</option>
                <option value="4844">外国血统中国籍人士</option>
            </select>
        </div>
    </div>
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">政治面貌</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui_select weui-select" name="vol_political" disabled="disabled">
                <option value="">请选择</option>
                <option value="4846">中国共产党党员</option>
                <option value="4847">中国共产党预备党员</option>
                <option value="23635">中国共产党党员（保留团籍）</option>
                <option value="4848">中国共产主义青年团团员</option>
                <option value="4849">中国国民党革命委员会会员</option>
                <option value="4850">中国民主同盟盟员</option>
                <option value="4851">中国民主建国会会员</option>
                <option value="4852">中国民主促进会会员</option>
                <option value="4853">中国农工民主党党员</option>
                <option value="4854">中国致公党党员</option>
                <option value="4855">九三学社社员</option>
                <option value="4856">台湾民主自治同盟盟员</option>
                <option value="4857">无党派民主人士</option>
                <option value="4858">中国少年先锋队队员</option>
                <option value="4859">群众</option>
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
            <select class="weui_select weui-select" name="vol_nationality">
                <option value="">请选择</option>
                <option value="4544" selected="">中国</option>
                <option value="4545">中国香港</option>
                <option value="4546">中国澳门</option>
                <option value="4547">中国台湾</option>
                <option value="4774">美国</option>
                <option value="4772">英国</option>
                <option value="4726">俄罗斯</option>
                <option value="4662">韩国</option>
                <option value="4657">日本</option>
                <option value="4621">法国</option>
                <option value="4584">加拿大</option>
                <option value="4558">澳大利亚</option>
                <option value="4548">阿富汗</option>
                <option value="4549">阿尔巴尼亚</option>
                <option value="4550">南极洲</option>
                <option value="4551">阿尔及利亚</option>
                <option value="4552">美属萨摩亚</option>
                <option value="4553">安道尔</option>
                <option value="4554">安哥拉</option>
                <option value="4555">安提瓜和巴布达</option>
                <option value="4556">阿塞拜疆</option>
                <option value="4557">阿根廷</option>
                <option value="4559">奥地利</option>
                <option value="4560">巴哈马</option>
                <option value="4561">巴林</option>
                <option value="4562">孟加拉</option>
                <option value="4563">亚美尼亚</option>
                <option value="4564">巴巴多斯</option>
                <option value="4565">比利时</option>
                <option value="4566">百慕大</option>
                <option value="4567">不丹</option>
                <option value="4568">玻利维亚</option>
                <option value="4569">波黑</option>
                <option value="4570">博茨瓦纳</option>
                <option value="4571">布维岛</option>
                <option value="4572">巴西</option>
                <option value="4573">伯利兹</option>
                <option value="4574">英属印度洋领地</option>
                <option value="4575">所罗门群岛</option>
                <option value="4576">英属维尔京群岛</option>
                <option value="4577">文莱</option>
                <option value="4578">保加利亚</option>
                <option value="4579">缅甸</option>
                <option value="4580">布隆迪</option>
                <option value="4581">白俄罗斯</option>
                <option value="4582">柬埔寨</option>
                <option value="4583">喀麦隆</option>
                <option value="4585">佛得角</option>
                <option value="4586">开曼群岛</option>
                <option value="4587">中非</option>
                <option value="4588">斯里兰卡</option>
                <option value="4589">乍得</option>
                <option value="4590">智利</option>
                <option value="4591">圣诞岛</option>
                <option value="4592">科科斯（基林）群岛</option>
                <option value="4593">哥伦比亚</option>
                <option value="4594">科摩罗</option>
                <option value="4595">马约特</option>
                <option value="4596">刚果（布）</option>
                <option value="4597">刚果（金）</option>
                <option value="4598">扎伊尔</option>
                <option value="4599">库克群岛</option>
                <option value="4600">冈比亚</option>
                <option value="4601">哥斯达黎加</option>
                <option value="4602">克罗地亚</option>
                <option value="4603">古巴</option>
                <option value="4604">塞浦路斯</option>
                <option value="4605">捷克</option>
                <option value="4606">贝宁</option>
                <option value="4607">丹麦</option>
                <option value="4608">多米尼克</option>
                <option value="4609">多米尼加</option>
                <option value="4610">厄瓜多尔</option>
                <option value="4611">萨尔瓦多</option>
                <option value="4612">赤道几内亚</option>
                <option value="4613">埃塞俄比亚</option>
                <option value="4614">厄立特里亚</option>
                <option value="4615">爱沙尼亚</option>
                <option value="4616">法罗群岛</option>
                <option value="4617">福克兰群岛</option>
                <option value="4618">乔治亚和桑德韦奇</option>
                <option value="4619">斐济</option>
                <option value="4620">芬兰</option>
                <option value="4622">法属圭亚那</option>
                <option value="4623">法属波利尼西亚</option>
                <option value="4624">法属南部领土</option>
                <option value="4625">吉布提</option>
                <option value="4626">加蓬</option>
                <option value="4627">格鲁吉亚</option>
                <option value="4628">佛得角</option>
                <option value="4629">德国</option>
                <option value="4630">加纳</option>
                <option value="4631">直布罗陀</option>
                <option value="4632">基里巴斯</option>
                <option value="4633">希腊</option>
                <option value="4634">格陵兰</option>
                <option value="4635">格林纳达</option>
                <option value="4636">瓜德罗普</option>
                <option value="4637">关岛</option>
                <option value="4638">危地马拉</option>
                <option value="4639">几内亚</option>
                <option value="4640">圭亚那</option>
                <option value="4641">海地</option>
                <option value="4642">赫德岛和麦克唐纳岛</option>
                <option value="4643">梵蒂冈</option>
                <option value="4644">洪都拉斯</option>
                <option value="4645">匈牙利</option>
                <option value="4646">冰岛</option>
                <option value="4647">印度</option>
                <option value="4648">印度尼西亚</option>
                <option value="4649">伊朗</option>
                <option value="4650">伊拉克</option>
                <option value="4651">爱尔兰</option>
                <option value="4652">巴勒斯坦</option>
                <option value="4653">以色列</option>
                <option value="4654">意大利</option>
                <option value="4655">科特迪瓦</option>
                <option value="4656">牙买加</option>
                <option value="4658">哈萨克斯坦</option>
                <option value="4659">约旦</option>
                <option value="4660">肯尼亚</option>
                <option value="4661">朝鲜</option>
                <option value="4663">科威特</option>
                <option value="4664">吉尔吉斯斯坦</option>
                <option value="4665">老挝</option>
                <option value="4666">黎巴嫩</option>
                <option value="4667">莱索托</option>
                <option value="4668">拉脱维亚</option>
                <option value="4669">利比里亚</option>
                <option value="4670">利比亚</option>
                <option value="4671">列支敦士登</option>
                <option value="4672">立陶宛</option>
                <option value="4673">卢森堡</option>
                <option value="4674">马达加斯加</option>
                <option value="4675">马拉维</option>
                <option value="4676">马来西亚</option>
                <option value="4677">马尔代夫</option>
                <option value="4678">马里</option>
                <option value="4679">马耳他</option>
                <option value="4680">马提尼克</option>
                <option value="4681">毛里塔尼亚</option>
                <option value="4682">毛里求斯</option>
                <option value="4683">墨西哥</option>
                <option value="4684">摩纳哥</option>
                <option value="4685">蒙古</option>
                <option value="4686">摩尔多瓦</option>
                <option value="4687">蒙特塞拉特</option>
                <option value="4688">摩洛哥</option>
                <option value="4689">莫桑比克</option>
                <option value="4690">阿曼</option>
                <option value="4691">纳米比亚</option>
                <option value="4692">瑙鲁</option>
                <option value="4693">尼泊尔</option>
                <option value="4694">荷兰</option>
                <option value="4695">荷属安的列斯</option>
                <option value="4696">阿鲁巴</option>
                <option value="4697">新喀里多尼亚</option>
                <option value="4698">瓦努阿图</option>
                <option value="4699">新西兰</option>
                <option value="4700">尼加拉瓜</option>
                <option value="4701">尼日尔</option>
                <option value="4702">尼日利亚</option>
                <option value="4703">纽埃</option>
                <option value="4704">诺福克岛</option>
                <option value="4705">挪威</option>
                <option value="4706">北马里亚纳</option>
                <option value="4707">美国本土外小岛屿</option>
                <option value="4708">密克罗尼西亚</option>
                <option value="4709">马绍尔群岛</option>
                <option value="4710">贝劳</option>
                <option value="4711">巴基斯坦</option>
                <option value="4712">巴拿马</option>
                <option value="4713">巴布亚新几内亚</option>
                <option value="4714">巴拉圭</option>
                <option value="4715">秘鲁</option>
                <option value="4716">菲律宾</option>
                <option value="4717">皮特凯恩</option>
                <option value="4718">波兰</option>
                <option value="4719">葡萄牙</option>
                <option value="4720">几内亚比绍</option>
                <option value="4721">东帝汶</option>
                <option value="4722">波多黎各</option>
                <option value="4723">卡塔尔</option>
                <option value="4724">留尼汪</option>
                <option value="4725">罗马尼亚</option>
                <option value="4727">卢旺达</option>
                <option value="4728">圣赫勒拿</option>
                <option value="4729">圣基茨和尼维斯</option>
                <option value="4730">安圭拉</option>
                <option value="4731">圣卢西亚</option>
                <option value="4732">圣皮埃尔和密克隆</option>
                <option value="4733">圣文森特和格林纳丁斯</option>
                <option value="4734">圣马力诺</option>
                <option value="4735">圣多美和普林西比</option>
                <option value="4736">沙特</option>
                <option value="4737">塞内加尔</option>
                <option value="4738">塞舌尔</option>
                <option value="4739">塞拉利昂</option>
                <option value="4740">新加坡</option>
                <option value="4741">斯洛伐克</option>
                <option value="4742">越南</option>
                <option value="4743">斯洛文尼亚</option>
                <option value="4744">索马里</option>
                <option value="4745">南非</option>
                <option value="4746">津巴布韦</option>
                <option value="4747">西班牙</option>
                <option value="4748">西撒哈拉</option>
                <option value="4749">苏丹</option>
                <option value="4750">苏里南</option>
                <option value="4751">斯瓦尔和扬马延</option>
                <option value="4752">斯威士兰</option>
                <option value="4753">瑞典</option>
                <option value="4754">瑞士</option>
                <option value="4755">叙利亚</option>
                <option value="4756">塔吉克斯坦</option>
                <option value="4757">泰国</option>
                <option value="4758">多哥</option>
                <option value="4759">托克劳</option>
                <option value="4760">汤加</option>
                <option value="4761">特立尼达和多巴哥</option>
                <option value="4762">阿联酋</option>
                <option value="4763">突尼斯</option>
                <option value="4764">土耳其</option>
                <option value="4765">土库曼斯坦</option>
                <option value="4766">特克斯和凯科斯群岛</option>
                <option value="4767">图瓦卢</option>
                <option value="4768">乌干达</option>
                <option value="4769">乌克兰</option>
                <option value="4770">马斯顿</option>
                <option value="4771">埃及</option>
                <option value="4773">坦桑尼亚</option>
                <option value="4775">美属维尔京群岛</option>
                <option value="4776">布基纳法索</option>
                <option value="4777">乌拉圭</option>
                <option value="4778">乌兹别克斯坦</option>
                <option value="4779">委内瑞拉</option>
                <option value="4780">瓦利斯和富图纳</option>
                <option value="4781">萨摩亚</option>
                <option value="4782">也门</option>
                <option value="4783">前南马其顿</option>
                <option value="4784">赞比亚</option>
                <option value="4785">黑山</option>
                <option value="4786">帕劳</option>
                <option value="4787">塞尔维亚</option>
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
            <select class="weui_select weui-select" name="vol_edu_degree">
                <option value="">请选择</option>
                <option value="4535">博士研究生</option>
                <option value="4536">硕士研究生</option>
                <option value="4537">大学本科</option>
                <option value="4538">大学专科</option>
                <option value="4539">中等专科</option>
                <option value="23277">职业高中</option>
                <option value="4540">技工学校</option>
                <option value="4541">高中</option>
                <option value="4542">初中</option>
                <option value="23278">小学</option>
                <option value="4543">其他</option>
            </select>
        </div>
    </div>
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">从业状况</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui_select weui-select" name="vol_job_title" >
                <option value="">请选择</option>
                <option value="23264">国家公务员（含参照、依照公务员管理）</option>
                <option value="23265">专业技术人员</option>
                <option value="23266">职员</option>
                <option value="23267">企业管理人员</option>
                <option value="23268">工人</option>
                <option value="23269">农民</option>
                <option value="23270">学生</option>
                <option value="23428">教师</option>
                <option value="23271">现役军人</option>
                <option value="23272">自由职业者</option>
                <option value="23273">个体经营者</option>
                <option value="23274">无业人员</option>
                <option value="23275">退（离）休人员</option>
                <option value="23276">其他</option>
            </select>
        </div>
    </div>
    <div class="weui-cell col-bac">
        <div class="weui-cell__hd "><label class="weui-label" style="width: 200px">服务类别（最多选择4个）</label></div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">服务类别</label></div>
        <div class="weui-cell__bd weui-cell_primary">
            <input class="weui-input" type="text" id="stag_vol" value="" placeholder="请选择服务类别">
        </div>
    </div>
    <script>
        $("#stag_vol").select({
            title: "服务类别",multi: true,min: 1,max: 4,
            items: [{"title":"社区服务","value":"社区服务"},{"title":"生态环保","value":"生态环保"},{"title":"医疗卫生","value":"医疗卫生"},{"title":"应急平安","value":"应急平安"},{"title":"助老助残","value":"助老助残"},{"title":"关爱儿童","value":"关爱儿童"},{"title":"赛会服务","value":"赛会服务"},{"title":"法律咨询","value":"法律咨询"},{"title":"教育培训","value":"教育培训"},{"title":"文化艺术","value":"文化艺术"},{"title":"心理咨询","value":"心理咨询"},{"title":"信息宣传","value":"信息宣传"},{"title":"网络维护","value":"网络维护"},{"title":"行政支持","value":"行政支持"},{"title":"活动策划","value":"活动策划"},{"title":"礼仪接待","value":"礼仪接待"},{"title":"外语翻译","value":"外语翻译"},{"title":"摄影摄像","value":"摄影摄像"}]            });

    </script>

    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd"><label class="weui-label">受邀加入项目</label></div>
        <div class="weui-cell__bd">
            <select class="weui_select weui-select" name="vol_public_flag" id="vol_public_flag"><option value="1" selected>是</option><option value="0">否</option></select>            </div>
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



