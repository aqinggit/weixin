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
<div class="weui-cells weui-cells_radio margin0 option" id="<?php echo $question['id'];?>">
    <label class="weui-cell weui-check__label" for="<?php echo $question['id'];?>_1">
        <div class="weui-cell__bd">
            <p>A.是</p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" class="weui-check" name="<?php echo $question['id'];?>" id="<?php echo $question['id'];?>_1" value="1" <?php echo zmf::val($question['id']) == 1? 'checked' : ''; ?>>
            <span class="weui-icon-checked"></span>
        </div>
    </label>
    <label class="weui-cell weui-check__label" for="<?php echo $question['id'];?>_0">

        <div class="weui-cell__bd">
            <p>B.否</p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" name="<?php echo $question['id'];?>" class="weui-check" id="<?php echo $question['id'];?>_0" value="0" <?php echo zmf::val($question['id']) == 0? 'checked' : ''; ?>>
            <span class="weui-icon-checked"></span>
        </div>
    </label>
    <?php $this->renderPartial('analysis',['question'=>$question]); ?>
</div>