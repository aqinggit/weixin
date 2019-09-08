<style>
    .answer_title {
        font-size: 15px;
        white-space: normal;
    }
    .option{
        font-size: 14px;
        white-space: normal;
    }
    .analysis{
        font-size: 14px;
        white-space: normal;
        padding: 0 15px 15px 15px;
        color: red;
    }
</style>
<p class="answer_title"><?php echo $question['title']; ?></p>
<div class="weui-cells weui-cells_radio margin0 option" id="<?php echo $question['id'];?>">
    <label class="weui-cell weui-check__label" for="<?php echo $question['id'];?>_1">
        <div class="weui-cell__bd">
            <p>A.是</p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" class="weui-check" name="<?php echo $question['id'];?>_1" id="<?php echo $question['id'];?>_1">
            <span class="weui-icon-checked"></span>
        </div>
    </label>
    <label class="weui-cell weui-check__label" for="<?php echo $question['id'];?>_0">

        <div class="weui-cell__bd">
            <p>B.否</p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" name="<?php echo $question['id'];?>_1" class="weui-check" id="<?php echo $question['id'];?>_0">
            <span class="weui-icon-checked"></span>
        </div>
    </label>
        <!--解析-->
    <p class="analysis"><?php echo $question['analysis'];?></p>
</div>