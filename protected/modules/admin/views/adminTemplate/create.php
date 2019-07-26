<?php

/**
 * @filename AdminTemplateController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-05-25 03:09:04 
 */
$this->renderPartial('_nav');
if (Yii::app()->user->hasFlash('addAdminTemplateSuccess')) {
    echo '<div class="alert alert-danger">' . Yii::app()->user->getFlash('addAdminTemplateSuccess') . '</div>';
}
$this->renderPartial('_form', array('model' => $model, 'powers' => $powers));
