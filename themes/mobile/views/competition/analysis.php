<!--解析-->
<style>
    .analysis {
        font-size: 14px;
        white-space: normal;
        padding: 15px;
        color: red;
    }

</style>
<?php if ($question['analysisStatus'] >= 1) { ?>
    <p class="analysis">
        <?php if ($question['analysisStatus'] >= 2) { ?>
            答案:<?php echo $question['answers']; ?>
        <?php } ?>
        <?php echo $question['analysis']; ?>
    </p>
<?php } ?>