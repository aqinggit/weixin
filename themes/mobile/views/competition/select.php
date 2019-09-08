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
    <label class="weui-cell weui-check__label" for="<?php echo $question['id']?>_<?php echo $k;?>">
        <div class="weui-cell__bd">
            <p class="option"><?php echo $answer;?></p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" class="weui-check" name="radio1" id="<?php echo $question['id']?>_<?php echo $k;?>">
            <span class="weui-icon-checked"></span>
        </div>
    </label>
    <?php } ?>
</div>