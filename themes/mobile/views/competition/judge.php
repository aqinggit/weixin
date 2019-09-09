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
<p class="answer_title"><em>判断：</em><?php echo $question['title']; ?></p>
<div class="weui-cells weui-cells_radio margin0 option" id="<?php echo $question['id'];?>">
    <label class="weui-cell weui-check__label" for="<?php echo $question['id'];?>_1">
        <div class="weui-cell__bd">
            <p>A.是</p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" class="weui-check" name="<?php echo $question['id'];?>" id="<?php echo $question['id'];?>_1" value="A" <?php echo zmf::val($question['id']) == 'A'? 'checked' : ''; ?>>
            <span class="weui-icon-checked"></span>
        </div>
    </label>
    <label class="weui-cell weui-check__label" for="<?php echo $question['id'];?>_0">

        <div class="weui-cell__bd">
            <p>B.否</p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" name="<?php echo $question['id'];?>" class="weui-check" id="<?php echo $question['id'];?>_0" value="B" <?php echo zmf::val($question['id']) == 'B'? 'checked' : ''; ?>>
            <span class="weui-icon-checked"></span>
        </div>
    </label>
    <?php $this->renderPartial('analysis',['question'=>$question]); ?>
</div>