<style>
    .hot-city{
        height: 50px;
        line-height: 50px;
    }
    .hot-city-item{
        color: #ec1c24;
        padding: 0 12px;
    }
    .content-title{
        font-size: 18px;
        margin-bottom: 10px;
    }
    #content-box{
        border: 1px solid #eee;
    }
    .content-letter{
        display: flex;
        border-bottom: 1px solid #eee;
        overflow: hidden;
    }
    .content-letter:last-child{
        border: none;
    }    
    .content-letter-panel{
        width: 50px;
        color: #999;
        font-size: 18px;
        font-weight: 700;
        background-color: #f5f5f5;
        text-align: center;
        border-right: 1px solid #eee;
        position: relative;
    }
    .content-letter-panel span{
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        display: block;
        width: 100%;
        text-align: center;
        left: 0;
        color: #333;
        font-weight: lighter;
    }    
    .content-province {
        display: inline-grid;
        width: 1148px;
        position: relative
    }
    .content-province .tri-angle{
        width: 0; 
        height: 0; 
        border-top: 5px solid transparent; 
        border-left: 8px solid #ec1c24; 
        border-bottom: 5px solid transparent; 
        position: absolute;
        left: -2px;
        top: 50%;
        margin-top: -5px;
        display: none
    }
    .content-letter:hover .content-letter-panel{
        background: #ec1c24;       
    }
    .content-letter:hover .content-letter-panel span{
        color: #FFF
    }
    .content-letter:hover .content-province .tri-angle{
        display: block
    }
    .content-cities{
        overflow: hidden;
        float: left;
        padding:10px 0 10px 20px;
    }

    .content-cities .content-city{
        display: inline-block;
        line-height: 30px;
        color: #666;
        font-size: 12px;
        margin: 0 12px;
    }
</style>
<?php $keyword=zmf::config('mainKeyword');?>
<div class="area-container">
    <div class="container">
        <?php if(!empty($topAreas)){?>
        <div class="hot-city">
            <span>热门城市：</span>
            <?php foreach($topAreas as $area){echo zmf::link($area['title'],array('index/index','colName'=>$area['name']),array('class'=>'hot-city-item','title'=>$area['title'].$keyword));}?>
        </div>
        <?php }?>
        <div id="content">
            <div id="content-title" class="content-title">
                按省份首字母选择
            </div>
            <div id="content-box">
                <?php foreach($areas as $char=>$items){?>
                <div class="content-letter">
                    <div class="content-letter-panel"><span><?php echo $char;?></span></div>
                    <div class="content-province">
                        <span class="tri-angle"></span>
                        <div class="content-cities">
                            <?php foreach($items as $area){?>
                                <?php echo zmf::link($area['title'],array('index/index','colName'=>$area['name']),array('class'=>'content-city','title'=>$area['title'].$keyword));?>
                            <?php }?>
                        </div>
                    </div>
                </div>   
                <?php }?>
            </div>
            <div class="clb"></div>
        </div>
    </div>
</div>