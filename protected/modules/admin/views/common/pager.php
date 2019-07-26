<div class="clearfix"></div>
<div style="padding-top: 15px;">
    <div style="float: left;padding-right: 15px;">
        共<?php echo $pages->itemCount.'条';?>
    </div>
    <div style="float: left">
         <?php 
            //分页widget代码: 
            $this->widget('CLinkPager',
                    array(
                       'header'=>'',
                        'firstPageLabel' => '首页',
                        'lastPageLabel' => '末页',    
                        'prevPageLabel' => '上一页',    
                        'nextPageLabel' => '下一页',    
                        'pages' => $pages,    
                        'maxButtonCount'=>10
                    )         
                    );
            ?>
    </div>
    <style>
        .pageGoto{
            width: 100px;
            margin-left: 10px;
            float: left;
            margin-top: -5px
        }
        .pageGoto .form-control{
            height: 28px
        }
        .pageGoto .btn{
            padding: 3px 12px
        }
    </style>
    <div class="input-group pageGoto">
        <input type="text" class="form-control" id="gotopage-num">
        <span class="input-group-btn">
            <button class="btn btn-default" type="button" onclick="gotoPage()">跳转</button>
        </span>
    </div><!-- /input-group -->
</div>
<script>
    function gotoPage(){
        var num=$('#gotopage-num').val();
        if(!num){
            simpleDialog({msg:'请输入页码'});
            return false;
        }
        var url=window.location.href;
        var url2=changeURLPar(url,'page',num);
        window.location.href = url2;
    }
    function changeURLPar(destiny, par, par_value) { 
        var pattern = par+'=([^&]*)'; 
        var replaceText = par+'='+par_value; 
        if (destiny.match(pattern)) { 
            var tmp = '/\\'+par+'=[^&]*/'; 
            tmp = destiny.replace(eval(tmp), replaceText); 
            return (tmp); 
        } else { 
            if (destiny.match('[\?]')) { 
                return destiny+'&'+ replaceText; 
            } else { 
                return destiny+'?'+replaceText; 
            } 
        } 
        return destiny+'\n'+par+'\n'+par_value; 
    } 
</script>