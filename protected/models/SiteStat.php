<?php

/**
 * This is the model class for table "{{site_stat}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-12-10 12:34:32
 * The followings are the available columns in table '{{site_stat}}':
 * @property integer $id
 * @property string $cTime
 * @property string $date
 * @property string $articles
 * @property string $questions
 * @property string $answers
 * @property string $attachments
 * @property string $comments
 * @property string $users
 * @property string $tags
 */
class SiteStat extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{site_stat}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('date', 'required'),
            array('cTime, date,articles, questions, answers, attachments, comments, users, tags', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cTime, date, articles, questions, answers, attachments, comments, users, tags', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cTime' => '创建时间',
            'date' => '创建时间',
            'articles' => '文章',
            'questions' => '问题',
            'answers' => '回答',
            'attachments' => '图片',
            'comments' => '评论',
            'users' => '用户',
            'tags' => '标签',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('cTime', $this->cTime, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('articles', $this->articles, true);
        $criteria->compare('questions', $this->questions, true);
        $criteria->compare('answers', $this->answers, true);
        $criteria->compare('attachments', $this->attachments, true);
        $criteria->compare('comments', $this->comments, true);
        $criteria->compare('users', $this->users, true);
        $criteria->compare('tags', $this->tags, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SiteStat the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public static function addOne($today='',$yesterday=''){
        if(!$today){
            $now = zmf::now();
            $today = strtotime(zmf::time($now, 'Y-m-d'), $now); 
        }
        if(!$yesterday){
            $yesterday = $today - 86400;
        }
        $data['date'] = $today;
        
        $data['users'] = Users::model()->count('cTime<='.$today.' AND status=1');
        $data['articles'] = Articles::model()->count('cTime<='.$today.' AND status=1');
        $data['questions'] = Questions::model()->count('cTime<='.$today.' AND status=1');
        $data['answers'] = Answers::model()->count('cTime<='.$today.' AND status=1');
        $data['attachments'] = Attachments::model()->count('cTime<='.$today.' AND status=1');
        $data['comments'] = Tips::model()->count('cTime<='.$today.' AND status=1');
        $data['tags'] = Tags::model()->count('cTime<='.$today.' AND isDisplay=1');
        
        $model=new SiteStat();
        $model->attributes=$data;
        $_info1=$model->save();      
        return $_info1;
    }

}
