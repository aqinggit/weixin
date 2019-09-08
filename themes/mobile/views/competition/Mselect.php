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
<div class="weui-cells weui-cells_checkbox margin0" id="<?php echo $question['id'];?>">
    <?php foreach ($question['content'] as $k => $answer) { ?>
    <label class="weui-cell weui-check__label option" for="<?php echo $question['id'] . '_' . $k ;?>">
        <div class="weui-cell__hd">
            <input type="checkbox" class="weui-check" name="<?php echo $question['id'] . '_' . $k ;?>" id="<?php echo $question['id'] . '_' . $k ;?>">
            <i class="weui-icon-checked"></i>
        </div>
        <div class="weui-cell__bd">
            <p><?php echo $answer; ?></p>
        </div>
    </label>
    <?php } ?>
     <!--解析-->
    <p class="analysis"><?php echo $question['analysis'];?></p>
</div>