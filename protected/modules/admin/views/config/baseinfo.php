<?php echo CHtml::hiddenField('type',$type);?>
<fieldset>
    <legend>基本信息</legend>
    <p><label>网站标题：</label><input class="form-control" name="sitename" id="sitename" value="<?php echo $c['sitename'];?>"/></p>
    <p><label>简短标题：</label><input class="form-control" name="shortTitle" id="shortTitle" value="<?php echo $c['shortTitle'];?>"/></p>
    <p><label>网站SLOGAN：</label><input class="form-control" name="slogan" id="slogan" value="<?php echo $c['slogan'];?>"/></p>
    <p><label>主关键词：</label><input class="form-control" name="mainKeyword" id="mainKeyword" value="<?php echo $c['mainKeyword'];?>"/></p>
    <p><label>网站Logo：</label><input class="form-control" name="logo" id="logo" value="<?php echo $c['logo'];?>"/></p>
    <p><label>网站域名：</label><input class="form-control" name="domain" id="domain" value="<?php echo $c['domain'];?>"/></p>
    <p><label>网站域名（无http）：</label><input class="form-control" name="pushDomain" id="pushDomain" value="<?php echo $c['pushDomain'];?>"/></p>
    <p><label>网站根目录：</label><input class="form-control" name="baseurl" id="baseurl" value="<?php echo $c['baseurl'];?>"/></p>
    <p><label>手机版域名：</label><input class="form-control" name="mobileDomain" id="mobileDomain" value="<?php echo $c['mobileDomain'];?>"/></p>
    <p><label>手机版域名：</label><input class="form-control" name="mobileBaseurl" id="mobileBaseurl" value="<?php echo $c['mobileBaseurl'];?>"/></p>
    <p><label>Mip域名：</label><input class="form-control" name="mipDomain" id="mipDomain" value="<?php echo $c['mipDomain'];?>"/></p>
    <p><label>Mip根目录：</label><input class="form-control" name="mipBaseurl" id="mipBaseurl" value="<?php echo $c['mipBaseurl'];?>"/></p>
    <p><label>网站关键字：</label><textarea class="form-control" name="siteKeywords"><?php echo $c['siteKeywords'];?></textarea></p>
    <p><label>网站描述：</label><textarea class="form-control" name="siteDesc" rows="5"><?php echo $c['siteDesc'];?></textarea></p>
    <p><label>网站统计：</label><textarea class="form-control" name="tongji" rows="5"><?php echo $c['tongji'];?></textarea></p>
    <p><label>首页分栏标题：</label><textarea class="form-control" name="indexSlogan" rows="5"><?php echo $c['indexSlogan'];?></textarea></p>
    <p><label>备案号：</label><input class="form-control" name="beian" id="beian" value="<?php echo $c['beian'];?>"/></p>
    <p><label>版权：</label><input class="form-control" name="copyright" id="copyright" value="<?php echo $c['copyright'];?>"/></p>
    <p><label>Robots.txt：</label><textarea class="form-control" name="robots" rows="5"><?php echo $c['robots'];?></textarea></p>
</fieldset>
<fieldset>
    <legend>网站站长验证</legend>
    <p><label>百度：</label><input class="form-control" name="baiduSiteVer" id="baiduSiteVer" value="<?php echo $c['baiduSiteVer'];?>"/></p>
    <p><label>谷歌：</label><input class="form-control" name="googleSiteVer" id="googleSiteVer" value="<?php echo $c['googleSiteVer'];?>"/></p>
    <p><label>360：</label><input class="form-control" name="360SiteVer" id="360SiteVer" value="<?php echo $c['360SiteVer'];?>"/></p>
    <p><label>Sogou：</label><input class="form-control" name="sogouSiteVer" id="sogouSiteVer" value="<?php echo $c['sogouSiteVer'];?>"/></p>
    <p><label>神马：</label><input class="form-control" name="shenmaSiteVer" id="shenmaSiteVer" value="<?php echo $c['shenmaSiteVer'];?>"/></p>
</fieldset> 
<fieldset>
    <legend>网站数据提交</legend>
    <p><label>熊掌号 APPID：</label><input class="form-control" name="xzh_appid" id="xzh_appid" value="<?php echo $c['xzh_appid'];?>"/></p>
    <p><label>清理MIP缓存Key：</label><input class="form-control" name="mip_clear_key" id="mip_clear_key" value="<?php echo $c['mip_clear_key'];?>"/></p>
    <p><label>推送百度CODE：</label><input class="form-control" type="text" name="baiduPushCode" id="baiduPushCode" value="<?php echo $c['baiduPushCode'];?>"/></p>
    <p><label>百度普通链接提交Token：</label><input class="form-control" name="baiduPushDomain" id="baiduPushDomain" value="<?php echo $c['baiduPushDomain'];?>"/></p>
    <p><label>MIP提交域名：</label><input class="form-control" name="mip_submit_domain" id="mip_submit_domain" value="<?php echo $c['mip_submit_domain'];?>"/></p>
    <p><label>MIP提交Token：</label><input class="form-control" name="mip_token" id="mip_token" value="<?php echo $c['mip_token'];?>"/></p>
</fieldset> 
<fieldset>
    <legend>联系方式</legend>
    <p><label>QQ：</label><input class="form-control" name="siteQQ" id="siteQQ" value="<?php echo $c['siteQQ'];?>"/></p>
    <p><label>值班电话：</label><input class="form-control" name="sitePhone" id="sitePhone" value="<?php echo $c['sitePhone'];?>"/></p>
    <p><label>400电话：</label><input class="form-control" name="site400Phone" id="site400Phone" value="<?php echo $c['site400Phone'];?>"/></p>
    <p><label>微信：</label><input class="form-control" name="siteWeixin" id="siteWeixin" value="<?php echo $c['siteWeixin'];?>"/></p>
    <p><label>微信二维码地址：</label><input class="form-control" name="siteWeixinUrl" id="siteWeixinUrl" value="<?php echo $c['siteWeixinUrl'];?>"/></p>
    <p><label>微博二维码地址：</label><input class="form-control" name="siteWeiboUrl" id="siteWeiboUrl" value="<?php echo $c['siteWeiboUrl'];?>"/></p>
</fieldset>    