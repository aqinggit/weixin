<fieldset>
    <legend>一些配置</legend>
    <?php echo CHtml::hiddenField('type',$type);?>
    <p><label>KD appid：</label><input class="form-control" name="kd_appid" id="kd_appid" value="<?php echo $c['kd_appid'];?>"/></p>
    <p><label>KD sk：</label><input class="form-control" name="kd_secret" id="kd_secret" value="<?php echo $c['kd_secret'];?>"/></p>
    <p><label>KD puin：</label><input class="form-control" name="kd_puin" id="kd_puin" value="<?php echo $c['kd_puin'];?>"/></p>
    <p><label>KD doc_pre：</label><input class="form-control" name="kd_doc_pre" id="kd_doc_pre" value="<?php echo $c['kd_doc_pre'];?>"/></p>
    <p><label>KD doc_author：</label><input class="form-control" name="kd_doc_author" id="kd_doc_author" value="<?php echo $c['kd_doc_author'];?>"/></p>
    <p><label>KD doc_class：</label><input class="form-control" name="kd_doc_class" id="kd_doc_class" value="<?php echo $c['kd_doc_class'];?>"/></p>
    <p><label>KD sync url：</label><input class="form-control" name="kd_sync_url" id="kd_sync_url" value="<?php echo $c['kd_sync_url'];?>"/></p>
    <p><label>KD token url：</label><input class="form-control" name="kd_token_url" id="kd_token_url" value="<?php echo $c['kd_token_url'];?>"/></p>
    <p><label>KD replace：</label><input class="form-control" name="kd_replace_words" id="kd_replace_words" value="<?php echo $c['kd_replace_words'];?>"/></p>
    <p><label>KD tags：</label><input class="form-control" name="kd_tags" id="kd_tags" value="<?php echo $c['kd_tags'];?>"/></p>
</fieldset>