<?php
/**
 * @filename SiteinfoColumnsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2018 阿年飞少 
 * @datetime 2018-03-02 01:58:28 */
$this->renderPartial('_nav'); 
if(Yii::app()->user->hasFlash('addSiteinfoColumnsSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addSiteinfoColumnsSuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model));