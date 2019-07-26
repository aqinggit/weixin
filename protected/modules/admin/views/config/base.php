<?php echo CHtml::hiddenField('type',$type);?>
<fieldset>
    <legend>功能性设置</legend>
    <p><label>应用环境：</label>
        <select name="appStatus" id="appStatus">
            <option value="1" <?php if($c['appStatus']=='1'){?>selected="selected"<?php }?>>本地开发</option>
            <option value="2" <?php if($c['appStatus']=='2'){?>selected="selected"<?php }?>>线上测试</option>
            <option value="3" <?php if($c['appStatus']=='3'){?>selected="selected"<?php }?>>线上正式</option>
        </select>
    </p>
    <p><label>APP访问记录：</label>
        <select name="appRuntimeLog" id="appRuntimeLog">
            <option value="0" <?php if($c['appRuntimeLog']=='0'){?>selected="selected"<?php }?>>不记录</option>
            <option value="1" <?php if($c['appRuntimeLog']=='1'){?>selected="selected"<?php }?>>仅链接</option>
            <option value="2" <?php if($c['appRuntimeLog']=='2'){?>selected="selected"<?php }?>>详情</option>
        </select>
    </p>
    <p><label>开启手机网页版：</label>
        <select name="mobile" id="mobile">
            <option value="0" <?php if($c['mobile']=='0'){?>selected="selected"<?php }?>>关闭</option>
            <option value="1" <?php if($c['mobile']=='1'){?>selected="selected"<?php }?>>开启</option>
        </select>
    </p>
    <p><label>关闭蜘蛛爬取：</label>
        <select name="closeAllSpider" id="closeAllSpider">
            <option value="0" <?php if($c['closeAllSpider']=='0'){?>selected="selected"<?php }?>>关闭</option>
            <option value="1" <?php if($c['closeAllSpider']=='1'){?>selected="selected"<?php }?>>开启</option>
        </select>
    </p>
    <p><label>登录注册：</label>
        <select name="regAndLogin" id="regAndLogin">
            <option value="1" <?php if($c['regAndLogin']=='1'){?>selected="selected"<?php }?>>开启</option>
            <option value="0" <?php if($c['regAndLogin']=='0'){?>selected="selected"<?php }?>>关闭</option>            
        </select>
    </p>
    <p>
        <label>默认用户组：</label>
        <?php echo CHtml::dropDownList('defaultUserGroup', $c['defaultUserGroup'], Group::listAll(), array('class'=>'form-control','empty'=>'--请选择--'));?>
    </p>
    <p><label>静态文件加速地址：</label><input class="form-control" type="text" name="cssJsStaticUrl" id="cssJsStaticUrl" value="<?php echo $c['cssJsStaticUrl'];?>"/></p>
    <p><label>图片默认占位图：</label><input class="form-control" type="text" name="lazyImgUrl" id="lazyImgUrl" value="<?php echo $c['lazyImgUrl'];?>"/></p>    
    <p><label>随机最小用户：</label><input class="form-control" type="text" name="randMinUser" id="randMinUser" value="<?php echo $c['randMinUser'];?>"/></p>
    <p><label>随机最大用户：</label><input class="form-control" type="text" name="randMaxUser" id="randMaxUser" value="<?php echo $c['randMaxUser'];?>"/></p>
    <p><label>采集评论长度必须大于：</label><input class="form-control" type="text" name="tipCaijiLength" id="tipCaijiLength" value="<?php echo $c['tipCaijiLength'];?>"/></p>
    <p><label>导入地区关键词：</label><input class="form-control" type="text" name="areaKeywords" id="areaKeywords" value="<?php echo $c['areaKeywords'];?>"/></p>

    <p><label>后台管理名称：</label><input class="form-control" type="text" name="houtaiTitle" id="houtaiTitle" value="<?php echo $c['houtaiTitle'];?>"/></p>
    <p><label>后台背景色：</label><input class="form-control" type="text" name="houtaiColor" id="houtaiColor" value="<?php echo $c['houtaiColor'];?>"/></p>
    <p><label>后台背景色2：</label><input class="form-control" type="text" name="houtaiColor2" id="houtaiColor2" value="<?php echo $c['houtaiColor2'];?>"/></p>
    <p><label>后台验证码：</label><input class="form-control" type="text" name="houtaiCode" id="houtaiCode" value="<?php echo $c['houtaiCode'];?>"/></p>
</fieldset>
<fieldset>
    <legend>缓存设置</legend>
    <p><label>全站缓存：</label>
        <select name="siteHtmlCache" id="siteHtmlCache">
            <option value="0" <?php if($c['siteHtmlCache']=='0'){?>selected="selected"<?php }?>>关闭</option>
            <option value="1" <?php if($c['siteHtmlCache']=='1'){?>selected="selected"<?php }?>>开启</option>
        </select>
    </p>
    <p>
        <label>全站不缓存页面：</label>
        <textarea class="form-control" name="notCacheUrls" rows="8"><?php echo $c['notCacheUrls'];?></textarea>
        <span class="help-block">一行一个</span>
    </p>
    <p>
        <label>全站缓存时间：</label>
        <input class="form-control" type="text" name="siteHtmlCacheTime" id="siteHtmlCacheTime" value="<?php echo $c['siteHtmlCacheTime'];?>"/>
        <span class="help-block">单位秒</span>
    </p>
</fieldset>