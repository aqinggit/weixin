<?php
/**
 * @filename VolunteersController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-08-01 21:47:13 */
 $this->renderPartial('_nav');
  echo CHtml::link('新增',array('create'),array('class'=>'btn btn-danger addBtn')); $form=$this->beginWidget('CActiveForm', array(
	'id'=>'search-form',
        'htmlOptions' => array(
            'class'=>'search-form'
        ),
        'action'=>Yii::app()->createUrl('/zmf/volunteers/index'),
	'enableAjaxValidation'=>false,
        'method'=>'GET'
)); ?>
<div class="fixed-width-group">
     <div class="form-group">
    <?php echo CHtml::textField("username",$_GET["username"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("username")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("password",$_GET["password"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("password")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("truename",$_GET["truename"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("truename")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("score",$_GET["score"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("score")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("status",$_GET["status"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("status")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("email",$_GET["email"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("email")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("cardIdType",$_GET["cardIdType"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("cardIdType")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("cardId",$_GET["cardId"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("cardId")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("sex",$_GET["sex"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("sex")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("birthday",$_GET["birthday"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("birthday")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("phone",$_GET["phone"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("phone")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("politics",$_GET["politics"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("politics")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("nation",$_GET["nation"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("nation")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("address",$_GET["address"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("address")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("education",$_GET["education"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("education")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("work",$_GET["work"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("work")));?></div>
    <div class="form-group"><button class="btn btn-default" type="submit">搜索</button></div>
</div>
<?php $this->endWidget(); ?>

 <table class="table table-hover table-striped">
    <tr>
                <th ><?php echo $model->getAttributeLabel("username");?></th>
                <th ><?php echo $model->getAttributeLabel("password");?></th>
                <th ><?php echo $model->getAttributeLabel("truename");?></th>
                <th ><?php echo $model->getAttributeLabel("score");?></th>
                <th ><?php echo $model->getAttributeLabel("status");?></th>
                <th ><?php echo $model->getAttributeLabel("email");?></th>
                <th ><?php echo $model->getAttributeLabel("cardIdType");?></th>
                <th ><?php echo $model->getAttributeLabel("cardId");?></th>
                <th ><?php echo $model->getAttributeLabel("sex");?></th>
                <th ><?php echo $model->getAttributeLabel("birthday");?></th>
                <th ><?php echo $model->getAttributeLabel("phone");?></th>
                <th ><?php echo $model->getAttributeLabel("politics");?></th>
                <th ><?php echo $model->getAttributeLabel("nation");?></th>
                <th ><?php echo $model->getAttributeLabel("address");?></th>
                <th ><?php echo $model->getAttributeLabel("education");?></th>
                <th ><?php echo $model->getAttributeLabel("work");?></th>
                <th style="width: 160px">操作</th>
    </tr>

    <?php foreach ($posts as $data): ?>
    <tr>
                <td><?php echo $data->username;?></td>
                <td><?php echo $data->password;?></td>
                <td><?php echo $data->truename;?></td>
                <td><?php echo $data->score;?></td>
                <td><?php echo $data->status;?></td>
                <td><?php echo $data->email;?></td>
                <td><?php echo $data->cardIdType;?></td>
                <td><?php echo $data->cardId;?></td>
                <td><?php echo $data->sex;?></td>
                <td><?php echo $data->birthday;?></td>
                <td><?php echo $data->phone;?></td>
                <td><?php echo $data->politics;?></td>
                <td><?php echo $data->nation;?></td>
                <td><?php echo $data->address;?></td>
                <td><?php echo $data->education;?></td>
                <td><?php echo $data->work;?></td>
                <td>
            <?php echo CHtml::link('编辑',array('update','id'=> $data->id));?>
            <?php echo CHtml::link('删除',array('delete','id'=> $data->id));?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager',array('pages'=>$pages));?>