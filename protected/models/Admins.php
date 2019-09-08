<?php

/**
 * This is the model class for table "{{admins}}".
 * 后台管理员
 * The followings are the available columns in table '{{admins}}':
 * @property string $id
 * @property string $uid
 * @property string $powers
 */
class Admins extends CActiveRecord
{

    public function tableName()
    {
        return '{{admins}}';
    }

    public function rules()
    {
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
    public function relations()
    {
        return array(
            'userInfo' => array(static::BELONGS_TO, 'Users', 'uid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
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
    public function search()
    {
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
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 权限描述
     * @param type $type 操作类型
     * @param type $name 获取某权限的描述
     * @return type]
     */
    public static function getDesc($type = 'admin', $name = '')
    {
        $lang['adminTemplate']['desc'] = '管理员分组';
        $lang['adminTemplate']['detail'] = array(
            'adminTemplate' => '管理员分组',
            'delAdminTemplate' => '删除管理员分组',
        );
        $lang['Volunteer']['desc'] = '志愿者管理';
        $lang['Volunteer']['detail'] = array(
            'Volunteers' => '志愿者列表',
            'VolunteerChecks' => '审核志愿者',
            'VolunteerDelete' => '删除志愿者',
            'VolunteerAdd' => '添加志愿者',
            'VolunteerScore' => '志愿者评分',
        );

        $lang['Active']['desc'] = '活动';
        $lang['Active']['detail'] = array(
            'Actives' => '活动列表',
            'ActiveDelete' => '删除志活动',
            'ActiveAdd' => '添加活动',
            'ActiveScore' => '活动评分',
            'ActiveBindVolunteer' => '活动申请审核',
            'volunteerType1' => '平安建设志愿者',
            'volunteerType2' => '人民调解志愿者',
            'volunteerType3' => '法治宣传志愿者',
        );



        $lang['Questions']['desc'] = '知识竞赛';
        $lang['Questions']['detail'] = array(
            'QuestionsList' => '知识题库',
            'QuestionsAs' => '答题列表',
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
            'navActivity' => '活动',
            'navVolunteer' => '志愿者',
            'navQuestions' => '知识竞赛',
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

    public static function getPowers($uid)
    {
        $key = 'adminPowers' . $uid;
        //$powers = zmf::getFCache($key);
        if (!$powers) {
            $items = Admins::model()->findAll('uid=:uid', array(':uid' => $uid));
            $powers = array_values(array_filter(CHtml::listData($items, 'id', 'powers')));
            $uinfo = Users::getOne($uid);
            if ($uinfo['powerGroupId']) {
                $_powerInfo = AdminTemplate::getOne($uinfo['powerGroupId']);
                if ($_powerInfo) {
                    $_arr = array_values(array_filter(explode(',', $_powerInfo['powers'])));
                    $powers = array_merge($powers, $_arr);
                }
            }
            zmf::setFCache($key, $powers, 86400);
        }
        return $powers;
    }

}
