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
            <input type="radio" class="weui-check" name="radio1" id="<?php echo $question['id'];?>_1">
            <span class="weui-icon-checked"></span>
        </div>
    </label>
    <label class="weui-cell weui-check__label" for="<?php echo $question['id'];?>_0">

        <div class="weui-cell__bd">
            <p>B.否</p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" name="radio1" class="weui-check" id="<?php echo $question['id'];?>_0">
            <span class="weui-icon-checked"></span>
        </div>
    </label>
</div>