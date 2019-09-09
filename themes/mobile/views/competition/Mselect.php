<style>
      .answer_title {
          font-size: 18px;
          white-space: normal;
      }
    .option{
        font-size: 14px;
        white-space: normal;
    }

</style>
<p class="answer_title"><em>多选：</em><?php echo $question['title']; ?></p>
<div class="weui-cells weui-cells_checkbox margin0" id="<?php echo $question['id'];?>[]">
    <?php foreach ($question['content'] as $k => $answer) { ?>
    <label class="weui-cell weui-check__label option" for="<?php echo $question['id'] . '_' . $k ;?>">
        <div class="weui-cell__hd">
            <input type="checkbox" class="weui-check" name="<?php echo $question['id'];?>[]" id="<?php echo $question['id'] . '_' . $k ;?>" value="<?php echo $answer['item'];?>" <?php echo in_array($answer['item'],zmf::val($question['id'],3))? 'checked' : ''; ?>>
            <i class="weui-icon-checked"></i>
        </div>
        <div class="weui-cell__bd">
            <p><?php echo $answer['title']; ?></p>
        </div>
    </label>
    <?php } ?>
     <!--解析-->
        <?php $this->renderPartial('analysis',['question'=>$question]); ?>
</div>