<?php

/**
 * This is the model class for table "{{admins}}".
 * 后台管理员
 * The followings are the available columns in table '{{admins}}':
 * @property string $id
 * @property string $uid
 * @property string $powers
 */
class Admins extends CActiveRecord {

    public function tableName() {
        return '{{admins}}';
    }

    public function rules() {
        return array(
            array('uid, powers', 'required'),
            array('uid', 'length', 'max' => 11),
            array('powers', 'length', 'max' => 25),
            array('uid, powers', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'userInfo' => array(static::BELONGS_TO, 'Users', 'uid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'uid' => '用户ID',
            'powers' => '用户权限',
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
        $criteria->compare('uid', $this->uid, true);
        $criteria->compare('powers', $this->powers, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Admins the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 权限描述
     * @param type $type 操作类型
     * @param type $name 获取某权限的描述
     * @return type]
     */
    public static function getDesc($type = 'admin', $name = '') {
        $lang['adminTemplate']['desc'] = '管理员分组';
        $lang['adminTemplate']['detail'] = array(
            'adminTemplate' => '管理员分组',
            'delAdminTemplate' => '删除管理员分组',
        );
        $lang['ads']['desc'] = '展示';
        $lang['ads']['detail'] = array(
            'ads' => '展示',
            'updateAds' => '更新展示',
            'delAds' => '删除展示',
        );
        $lang['answers']['desc'] = '问题回答相关，包括增删改等';
        $lang['answers']['detail'] = array(
            'answers' => '问题回答列表',
            'delAnswers' => '问题回答列表',
        );
        $lang['area']['desc'] = '地区';
        $lang['area']['detail'] = array(
            'area' => '地区',
            'updateArea' => '更新地区',
            'delArea' => '删除地区',
        );
        $lang['articleCaiji']['desc'] = '采集文章';
        $lang['articleCaiji']['detail'] = array(
            'articleCaiji' => '采集文章',
        );
        $lang['articles']['desc'] = '文章相关，包括增删改等';
        $lang['articles']['detail'] = array(
            'articles' => '文章列表',
            'updateArticles' => '更新文章列表',
            'delArticles' => '删除文章列表',
        );
        $lang['attachments']['desc'] = '图片相关';
        $lang['attachments']['detail'] = array(
            'attachments' => '图片列表',
        );
        $lang['column']['desc'] = '文章栏目';
        $lang['column']['detail'] = array(
            'column' => '文章栏目',
            'updateColumn' => '更新文章栏目',
            'delColumn' => '删除文章栏目',
        );
        $lang['sitepath']['desc'] = '路径';
        $lang['sitepath']['detail'] = array(
            'sitepath' => '路径',
            'addSitepath' => '新增路径',
            'updateSitepath' => '更新路径',
            'delSitepath' => '删除路径',
        );
        $lang['posts']['desc'] = '案例图库';
        $lang['posts']['detail'] = array(
            'posts' => '案例图库',
            'addPosts' => '新增案例图库',
            'updatePosts' => '更新案例图库',
            'delPosts' => '删除案例图库',
        );
        $lang['comments']['desc'] = '评论相关，包括增删改等';
        $lang['comments']['detail'] = array(
            'comments' => '评论列表',
        );


        $lang['group']['desc'] = '用户组';
        $lang['group']['detail'] = array(
            'group' => '用户组列表',
        );
        $lang['groupGifts']['desc'] = '用户组初始积分';
        $lang['groupGifts']['detail'] = array(
            'groupGifts' => '用户组初始积分列表',
        );
        $lang['groupLevels']['desc'] = '用户组称呼';
        $lang['groupLevels']['detail'] = array(
            'groupLevels' => '用户组称呼列表',
        );
        $lang['groupPowerTypes']['desc'] = '用户组权限分类';
        $lang['groupPowerTypes']['detail'] = array(
            'groupPowerTypes' => '用户组权限分类列表',
        );
        $lang['groupPowers']['desc'] = '用户组权限';
        $lang['groupPowers']['detail'] = array(
            'groupPowers' => '用户组权限列表',
        );
        $lang['groupTasks']['desc'] = '用户组任务';
        $lang['groupTasks']['detail'] = array(
            'groupTasks' => '用户组任务列表',
        );        
        $lang['keywords']['desc'] = '关键词';
        $lang['keywords']['detail'] = array(
            'keywords' => '关键词列表',
            'updateKeywords' => '更新关键词列表',
            'delKeywords' => '删除关键词列表',
        );
        $lang['links']['desc'] = '友链';
        $lang['links']['detail'] = array(
            'links' => '友链列表',
            'updateLinks' => '更新友链列表',
            'delLinks' => '删除友链列表',
        );
        $lang['msg']['desc'] = '短信';
        $lang['msg']['detail'] = array(
            'msg' => '短信列表',            
        );
        $lang['orders']['desc'] = '订单';
        $lang['orders']['detail'] = array(
            'orders' => '列表订单',            
        );
        $lang['navbar']['desc'] = '导航';
        $lang['navbar']['detail'] = array(
            'navbar' => '导航',
            'updateNavbar' => '更新导航',
            'delNavbar' => '删除导航',
        );
        $lang['notification']['desc'] = '通知';
        $lang['notification']['detail'] = array(
            'notification' => '通知',
        );
        $lang['questions']['desc'] = '问题相关，包括增删改等';
        $lang['questions']['detail'] = array(
            'questions' => '问题列表',
            'updateQuestions' => '更新问题列表',
            'delQuestions' => '删除问题列表',
        );
        $lang['reports']['desc'] = '举报';
        $lang['reports']['detail'] = array(
            'reports' => '举报列表',
        );
        $lang['searchRecords']['desc'] = '搜索记录';
        $lang['searchRecords']['detail'] = array(
            'searchRecords' => '搜索记录列表',
            'updateSearchRecords' => '更新搜索记录列表',
            'delSearchRecords' => '删除搜索记录列表',
        );
        $lang['searchWords']['desc'] = '搜索词';
        $lang['searchWords']['detail'] = array(
            'searchWords' => '搜索词',
            'updateSearchWords' => '更新搜索词',
            'delSearchWords' => '删除搜索词',
        );
        $lang['siteFiles']['desc'] = '站点文件';
        $lang['siteFiles']['detail'] = array(
            'siteFiles' => '列表站点文件',
            'updateSiteFiles' => '更新列表站点文件',
            'delSiteFiles' => '删除列表站点文件',
        );
        $lang['siteInfo']['desc'] = '站点文章';
        $lang['siteInfo']['detail'] = array(
            'siteInfo' => '站点文章列表',
            'updateSiteInfo' => '更新站点文章列表',
            'delSiteInfo' => '删除站点文章列表',
        );
        $lang['siteinfoColumns']['desc'] = '站点文章分类';
        $lang['siteinfoColumns']['detail'] = array(
            'siteinfoColumns' => '站点文章分类',
            'addSiteinfoColumns' => '新增站点文章分类',
            'updateSiteinfoColumns' => '更新站点文章分类',
            'delSiteinfoColumns' => '删除站点文章分类',
        );
        $lang['tags']['desc'] = '标签相关，包括增删改等';
        $lang['tags']['detail'] = array(
            'tags' => '标签列表',
            'updateTags' => '更新标签列表',
            'delTags' => '删除标签列表',
        );
        $lang['tdk']['desc'] = 'TDK';
        $lang['tdk']['detail'] = array(
            'tdk' => 'TDK列表',
            'updateTdk' => '更新TDK列表',
            'delTdk' => '删除TDK列表',
        );
        $lang['tools']['desc'] = '小工具';
        $lang['tools']['detail'] = array(
            'tools' => '小工具',
        );
        $lang['users']['desc'] = '用户相关，包括更新、删除等';
        $lang['users']['detail'] = array(
            'users' => '用户列表',
            'admins' => '后台管理员',
        );
        $lang['words']['desc'] = '敏感词';
        $lang['words']['detail'] = array(
            'words' => '敏感词列表',
            'updateWords' => '更新敏感词列表',
            'delWords' => '删除敏感词列表',
        );
        $lang['admins']['desc'] = '后台管理员';
        $lang['admins']['detail'] = array(
            'admins' => '后台管理员',
            'setAdmin' => '设置管理员',
            'delAdmin' => '删除管理员',
        );
        $lang['config']['desc'] = '系统设置';
        $lang['config']['detail'] = array(
            'config' => '系统设置列表',
            'setConfig' => '系统设置',
            'configBaseinfo' => '网站信息',
            'configBase' => '全局配置',
            'configEmail' => '邮件配置',
            'configUpload' => '上传配置',
        );
        $lang['adminNavbar']['desc'] = '后台管理员';
        $lang['adminNavbar']['detail'] = array(
            'navContent' => '内容',
            'navYunying' => '运营',
            'navUsers' => '用户',
            'navSystem' => '系统',
        );
        if ($type === 'admin') {
            $items = array();
            foreach ($lang as $key => $val) {
                $items = array_merge($items, $val['detail']);
            }
            unset($lang);
            $lang['admin'] = $items;
        } elseif ($type == 'super') {
            return $lang;
        }
        if (!empty($name)) {
            return $lang[$type][$name];
        } else {
            return $lang[$type];
        }
    }
    
    public static function getPowers($uid) {
        $key = 'adminPowers' . $uid;
        //$powers = zmf::getFCache($key);
        if (!$powers) {
            $items = Admins::model()->findAll('uid=:uid', array(':uid' => $uid));
            $powers = array_values(array_filter(CHtml::listData($items, 'id', 'powers')));            
            $uinfo= Users::getOne($uid);
            if($uinfo['powerGroupId']){
                $_powerInfo= AdminTemplate::getOne($uinfo['powerGroupId']);
                if($_powerInfo){
                    $_arr=array_values(array_filter(explode(',', $_powerInfo['powers'])));
                    $powers= array_merge($powers,$_arr);
                }
            }
            zmf::setFCache($key, $powers, 86400);
        }
        return $powers;
    }

}
