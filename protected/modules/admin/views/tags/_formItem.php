<span class="tags-item" id="select-this-tag-<?php echo $data['id'];?>" onclick="_removeThisTag(<?php echo $data['id'];?>)">
    <input value="<?php echo $data['id'];?>" type="checkbox" name="tags[]" checked="checked">
    <?php echo $data['title'];?>
</span>