<?php

/**
 * This is the model class for table "{{area}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-11-16 13:49:05
 * The followings are the available columns in table '{{area}}':
 * @property string $id
 * @property string $title
 * @property string $belongId
 * @property integer $opened
 * @property string $name
 * @property string $sitepath
 */
class Area extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{area}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name', 'unique'),
            array('opened', 'numerical', 'integerOnly' => true),
            array('title, name', 'length', 'max' => 32),
            array('belongId', 'length', 'max' => 10),
            array('firstChar,recommend', 'length', 'max' => 1),
            array('sitepath', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, belongId, opened, name, sitepath', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'belongInfo' => array(self::BELONGS_TO, 'Area', 'belongId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => '标题',
            'belongId' => '所属',
            'opened' => '开通',
            'name' => '路径',
            'sitepath' => '层级路径',
            'firstChar' => '首字母',
            'recommend' => '推荐',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('belongId', $this->belongId, true);
        $criteria->compare('opened', $this->opened);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('sitepath', $this->sitepath, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Area the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public static function getOne($id){
        return static::model()->findByPk($id);
    }

    /**
     * 根据拼音来查询
     * @param string $name
     * @return Area
     */
    public static function findByName($name) {
        $info = static::model()->find(array(
            'condition' => 'name=:name',
            'select' => 'id,title,name,sitepath,belongId',
            'params' => array(
                ':name' => $name
            )
        ));
        return $info;
    }

    /**
     * 根据地区返回所属层级已开通的路径
     * @param array $areaInfo
     * @return string
     */
    public static function getAreaDomain($areaInfo) {
        $ids = join(',', array_filter(explode('-', $areaInfo['sitepath'])));
        if (!$ids) {
            return 'poi';
        }
        $area = Area::model()->find(array(
            'condition' => 'id IN(' . $ids . ') AND opened=1',
            'order' => 'id DESC'
        ));
        return $area ? $area['name'] : 'poi';
    }
    
    /**
     * 根据地区返回所属层级已开通的路径
     * @param array $areaInfo
     * @return string
     */
    public static function getFatherPath($areaInfo) {
        $ids = join(',', array_filter(explode('-', $areaInfo['sitepath'])));
        if (!$ids) {
            return 'poi';
        }
        $areas = Area::model()->findAll(array(
            'condition' => 'id IN(' . $ids . ') AND opened=1',
            'order' => 'id DESC'
        ));
        return $areas;
    }
    
    /**
     * 导航条上地区筛选
     */
    public static function navbarAreas($foreach = true) {
        $items = static::getHasPoiAreas();
        if ($foreach) {
            $charterArr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            $arr = [];
            foreach ($charterArr as $char) {
                foreach ($items as $k => $item) {
                    if ($item['firstChar'] == strtolower($char)) {
                        $arr[$char][] = $item;
                        unset($items[$k]);
                        continue;
                    }
                }
            }
        }
        return $foreach ? $arr : $items;
    }
    
    public static function getTops($limit = 10) {
        $items = static::model()->findAll(array(
            'condition' => 'recommend>0',
            'order' => 'id ASC',
            'limit' => $limit,
            'select' => 'id,title,name'
        ));
        return $items;
    }
    
    public static function getSameLevelAreas($areaInfo,$limit=10){
        $belongPath= str_replace($areaInfo['id'].'-', '', $areaInfo['sitepath']);
        $sql="SELECT id,title,name FROM {{area}} WHERE sitepath LIKE '%{$belongPath}%' AND id!={$areaInfo['id']} AND opened=1 LIMIT {$limit}";
        $items=Yii::app()->db->createCommand($sql)->queryAll();
        return $items;
    }
    
    /**
     * 获取有地点的地区
     * @return array
     */
    public static function getHasPoiAreas(){
        $items = Area::model()->findAll(array(
            'condition' => 'opened=1 AND `name`!="" AND firstChar!=""',
            'order' => 'id ASC',
            'select' => 'id,title,name,firstChar'
        ));
        return $items;
    }
    
    /**
     * 从已开通城市中随机取几条地区ID
     * @param int $limit
     * @param string $idsStr
     * @return array
     */
    public static function getOpenedRandIds($limit = 10, $idsStr = null) {
        $sql = "SELECT a.id FROM {{area}} a WHERE a.opened=1" . ($idsStr ? " AND a.id NOT IN({$idsStr})" : '');
        $posts = Yii::app()->db->createCommand($sql)->queryAll();
        $idsArr = array_keys(CHtml::listData($posts, 'id', ''));
        shuffle($idsArr);
        if (count($idsArr) > $limit) {
            return array_slice($idsArr, 0, $limit);
        }
        return $idsArr;
    }
    
    /**
     * 根据当前地区取随机热门
     * 如果没有选地区，则热门选15，其他随机15
     * 已选地区，则ID前15和后15
     * @param type $areaInfo
     * @return type
     */
    public static function footerAreas($areaInfo) {
        if ($areaInfo['id']>0) {
            $sql1 = 'SELECT id,title,name FROM {{area}} WHERE id>' . $areaInfo['id'] . ' AND opened=1 ORDER BY id ASC LIMIT 5';
            $nexts = Yii::app()->db->createCommand($sql1)->queryAll();
            $sql2 = 'SELECT id,title,name FROM {{area}} WHERE id<' . $areaInfo['id'] . ' AND opened=1 ORDER BY id DESC LIMIT 5';
            $prevs = Yii::app()->db->createCommand($sql2)->queryAll();
            $areas = array_merge($prevs, $nexts);
            if (count($areas) < 30) {
                $randIds = static::getOpenedRandIds(30 - count($areas), join(',', array_keys(CHtml::listData($areas, 'id', ''))));
                $rand = [];
                if (!empty($randIds)) {
                    $rand = static::model()->findAll(array(
                        'condition' => 'id IN(' . join(',', $randIds) . ')',
                        'select' => 'id,title,name'
                    ));
                }
                $areas = array_merge($areas, $rand);
            }
        } else {
            $tops = static::getTops(15);
            $randIds = static::getOpenedRandIds(15, join(',', array_keys(CHtml::listData($tops, 'id', ''))));
            $rand = [];
            if (!empty($randIds)) {
                $rand = static::model()->findAll(array(
                    'condition' => 'id IN(' . join(',', $randIds) . ')',
                    'select' => 'id,title,name'
                ));
            }
            $areas = array_merge($tops, $rand);
        }
        return $areas;
    }

    public static function getFullAreas(){
        $first=static::model()->findAll(array(
            'condition'=>'belongId=0',
            'select'=>'id,title',
            'order'=>'id ASC'
        ));
        $areas=[];
        foreach($first as $k=>$f){
            $_seconds=static::model()->findAll(array(
                'condition'=>'belongId=:bid',
                'select'=>'id,title',
                'order'=>'id ASC',
                'params'=>array(
                    ':bid'=>$f['id']
                )
            ));
            $_secondsTemp=[];
            foreach($_seconds as $k2=>$s2){
                $_thirds=static::model()->findAll(array(
                    'condition'=>'belongId=:bid',
                    'select'=>'id,title',
                    'order'=>'id ASC',
                    'params'=>array(
                        ':bid'=>$s2['id']
                    )
                ));
                $_thirdsTemp=[];
                foreach ($_thirds as $t3){
                    $_thirdsTemp[]=array(
                        'id'=>$t3['id'],
                        'title'=>$t3['title'],
                        'items'=>array(),
                    );
                }
                $_secondsTemp[]=array(
                    'id'=>$s2['id'],
                    'title'=>$s2['title'],
                    'items'=>$_thirdsTemp,
                );
            }
            $areas[]=array(
                'id'=>$f['id'],
                'title'=>$f['title'],
                'items'=>$_secondsTemp,
            );
        }
        return $areas;
    }

    public static function fullPathText($path){
        $idsArr=array_unique(array_filter(explode('-', $path)));
        unset($idsArr[0]);
        unset($idsArr[1]);
        $ids= join(',',$idsArr);
        if(!$ids){
            return '';
        }
        $arr= self::getByIds($ids);
        return join(' / ',CHtml::listData($arr, 'id', 'title'));
    }

    public static function getByIds($ids) {
        if (!$ids) {
            return array();
        }
        $str = join(',', array_filter(array_unique(explode(',', $ids))));
        if (!$str) {
            return array();
        }
        $sql = "SELECT id,title,sitepath FROM {{area}} WHERE id IN($str) ORDER BY FIELD(id,$str)";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        return $items;
    }

}
