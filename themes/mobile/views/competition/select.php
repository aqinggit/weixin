<style>
    .answer_title {
        font-size: 15px;
        white-space: normal;
    }
    .option{
        font-size: 14px;
        white-space: normal;
    }
</style>
<p class="answer_title"><?php echo $question['title']; ?></p>
<div class="weui-cells weui-cells_radio margin0" id="<?php echo $question['id'];?>">
    <?php foreach ($question['content'] as $k=>$answer){?>
    <label class="weui-cell weui-check__label" for="<?php echo $question['id'] .'_'. $k;?>">
        <div class="weui-cell__bd">
            <p class="option"><?php echo $answer['title'];?></p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" class="weui-check" name="<?php echo $question['id']?>" id="<?php echo $question['id'] .'_'. $k;?>" value="<?php echo $answer['item'];?>" <?php echo zmf::val($question['id']) == $answer['item']? 'checked' : ''; ?> >
            <span class="weui-icon-checked"></span>
        </div>
    </label>
    <?php } ?>
    <?php $this->renderPartial('analysis',['question'=>$question]); ?>
</div>