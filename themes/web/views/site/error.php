<style>
    body{
        background: #fff
    }
    .error-tips{
        width: 480px;
        margin: 0 auto;
        text-align: center;
    }
    .error-tips h1{
        font-size: 96px;
        text-shadow: 10px 15px 10px #ccc;
        text-align: center;
    }
    .error-tips p{
        color: #ccc
    }
    .error-tips a{
        font-size: 13px;
        color: #c00;
    }
</style>
<div class="error-tips">
    <h1><?php echo $code; ?></h1>
    <p class="error-msg"><?php echo CHtml::encode($message); ?></p>
    <p>
        <a href="javascript:;" onclick="history.back()" class="btn btn-danger btn-sm">返回上一页</a>
        <?php echo zmf::link('返回首页',  zmf::config('baseurl'),array('class'=>'btn btn-danger btn-sm'));?>
    </p>
</div>