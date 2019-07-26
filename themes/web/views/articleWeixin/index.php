<style>
    h1 {
        text-align: center;
        font-size: 32px;
    }
    div{
        width: 500px;
        margin: 0 auto;
    }
    p{
        font-size: 28px;
    }

</style>
<div>
    <h1><?php echo $data->title ?></h1>
    <p><?php echo $data->userInfo->truename ?></p>
    <p><?php echo $data->content ?></p>
    <p class="color-999"><?php echo zmf::time($data->cTime) ?></p>
    <p><?php echo $data->status ?></p>
    <p><?php echo $data->score ?></p>
</div>
