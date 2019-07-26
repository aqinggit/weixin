<?php

class Attachments extends CActiveRecord {

    public function tableName() {
        return '{{attachments}}';
    }

    public function rules() {
        return array(
            array('uid', 'default', 'setOnEmpty' => true, 'value' => zmf::uid()),
            array('cTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('status', 'default', 'setOnEmpty' => true, 'value' => Posts::STATUS_PASSED),
            array('status,isDisplay', 'numerical', 'integerOnly' => true),
            array('uid, logid, hits, cTime,comments,typeId', 'length', 'max' => 10),
            array('urlPrefix', 'length', 'max' => 32),
            array('filePath, fileDesc, classify, width, height, size,remote', 'length', 'max' => 255),
            array('id, uid, logid, filePath, fileDesc, classify, width, height, size, hits, cTime, status,remote', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'uid' => '作者',
            'logid' => '所属',
            'filePath' => '文件名',
            'fileDesc' => '描述',
            'classify' => '分类',
            'width' => '宽',
            'height' => '高',
            'size' => '大小',
            'hits' => '点击',
            'cTime' => '创建时间',
            'status' => '状态',
            'favor' => '赞',
            'remote' => '远程路径',
            'comments' => '评论数',
            'typeId' => '分类',
            'urlPrefix' => '路径',
            'isDisplay' => '显示',
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userInfo' => array(static::BELONGS_TO, 'Users', 'uid'),
        );
    }

    /**
     * 根据单条图片信息返回存放地址
     * @param type $data
     * @return string
     */
    public static function getUrl($data, $size = '170') {
        if ($data['remote'] != '') {
            $_imgurl = $data['remote'];
        } else {
            $_imgurl = zmf::uploadDirs($data['cTime'], 'site', $data['classify']) . $data['filePath'];
        }
        $reurl = zmf::getThumbnailUrl($_imgurl, $size, $data['classify']);
        return $reurl;
    }

    /**
     * 返回封面图
     * @param int $id
     * @param string $size
     * @return string
     */
    public static function faceImg($id, $size = '170') {
        if (!$id || !is_numeric($id)) {
            return '';
        }
        $url = '';
        $info = static::getOne($id);
        if (!$info) {
            return '';
        }
        if ($info['remote'] != '') {
            $url = $info['remote'];
        } else {
            $url = zmf::uploadDirs($info['cTime'], 'site', $info['classify']) . $info['filePath'];
        }
        if (!$url) {
            return '';
        }
        return zmf::getThumbnailUrl($url, $size);
    }

    /**
     * 根据图片ID返回图片信息
     * @param type $id
     * @return boolean
     */
    public static function getOne($id) {
        if (!$id || !is_numeric($id)) {
            return false;
        }
        //todo，图片分表，将图片表分为attachments0~9
        return Attachments::model()->findByPk($id);
    }

    /**
     * 判断图片是否是站内图片
     * @param type $url
     * @return boolean
     */
    public static function checkUrlDomain($url) {
        if (!$url) {
            return true;
        }
        $arr[] = zmf::config('domain');
        $arr[] = zmf::config('imgVisitUrl');
        $arr = array_filter($arr);
        $find = false;
        foreach ($arr as $_url) {
            if (strpos($url, $_url) !== false) {
                $find = true;
                break;
            }
        }
        return $find;
    }

    /**
     * 更新文章链接前缀
     * @param int $id
     * @param object $info
     * @return bool
     */
    public static function updateUrlPrefix($id, $info = null) {
        if (!$info) {
            $info = static::model()->findByPk($id);
        }
        if (!$info || (!$info['typeId']) || $info['status']!=Posts::STATUS_PASSED) {
            return;
        } elseif ($info['urlPrefix'] != '') {
            return;
        }
        $path = '';
        if ($info->typeId > 0) {
            $path = $info->typeInfo->sitepath;
        } else {
            $path = 'photo';
        }
        return $info->updateByPk($info['id'], array(
                    'urlPrefix' => $path
        ));
    }

    public static function getByIds($ids) {
        $ids = join(',', array_unique(array_filter(explode(',', $ids))));
        if (!$ids) {
            return;
        }
        return static::model()->findAll(array(
                    'condition' => 'id IN(' . $ids . ')',
                    'select' => 'id,remote,fileDesc'
        ));
    }

    public static function getAndSave($url, $type, $logid = 0) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');
        // 在HTTP请求头中"Referer: "的内容。
        curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, sdch");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //302redirect
        //如果不是微博的图片，暂且认为是微信图片
        if (strpos($url, 'sinaimg') === false) {
            //针对微信
            curl_setopt($ch, CURLOPT_REFERER, "https://mp.weixin.qq.com/");
            // 针对https的设置
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }
        $imgData = curl_exec($ch);
        curl_close($ch);
        if (!$imgData) {
            return;
        }
        $ctime = zmf::now();
        $dir = zmf::uploadDirs($ctime, 'app', $type);
        zmf::createUploadDir($dir);
        $fileName = zmf::uuid() . '.jpg';
        file_put_contents($dir . $fileName, $imgData);
        $imgInfo = getimagesize($dir . $fileName);
        $size = filesize($dir . $fileName);
        $returnimg = zmf::uploadDirs($ctime, 'site', $type) . $fileName;
        $data = array();
        $data['uid'] = zmf::uid();
        $data['logid'] = $logid;
        $data['filePath'] = $fileName;
        $data['fileDesc'] = '';
        $data['classify'] = $type;        
        $data['cTime'] = $ctime;
        $data['status'] = Posts::STATUS_PASSED;
        $data['width'] = $imgInfo[0];
        $data['height'] = $imgInfo[1];
        $data['size'] = $size;
        $data['remote'] = $returnimg;
        $model = new Attachments();
        $model->attributes = $data;
        if ($model->save()) {
            $attachid = $model->id;
            $outPutData = array(
                'attachid' => $attachid,
                'imgsrc' => $returnimg,
            );
            return $outPutData;
        }
        return;
    }

    public static function updateOne($id, $field, $value = '') {
        if (!in_array($field, array('fileDesc'))) {
            return false;
        }
        return self::model()->updateByPk($id, array($field => $value));
    }

    public static function updatePostImgs($logid, $classify, $attachids, $uid = 0) {
        if (!$logid || !$classify) {
            return false;
        }
        if (!$uid) {
            $uid = zmf::uid();
        }
        Attachments::model()->updateAll(array('status' => Posts::STATUS_DELED), 'logid=:logid AND classify=:classify', array(':logid' => $logid, ':classify' => $classify));
        if ($attachids != '') {
            Attachments::model()->updateAll(array('status' => Posts::STATUS_PASSED, 'logid' => $logid), "id IN({$attachids}) AND classify='{$classify}'");
        }
        return true;
    }

}
