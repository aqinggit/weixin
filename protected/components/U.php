<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class U extends CUserIdentity
{

    private $_id;
    public $username;
    public $phone;

    public function __construct($phone, $password)
    {
        parent::__construct($phone, $password);
        $this->phone = $phone;
    }

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $validator = new CEmailValidator;
        if ($validator->validateValue($this->phone)) {
            $user = Users::model()->find('email=:email', array(':email' => $this->phone));
        } else {
            $user = Users::model()->find('phone=:phone', array(':phone' => $this->phone));
        }
        if ($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($user['status'] != Users::STATUS_PASSED)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if (!$this->validatePassword($user->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->_id = $user->id;
            $this->username = $user->truename;
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId()
    {
        return $this->_id;
    }

    public function validatePassword($password)
    {
        return md5($this->password) == $password ? true : false;
    }

    public function simpleAuth()
    {
        $user = Users::findByPhone($this->phone);
        if ($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($user['status'] != 1)
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->_id = $user->id;
            $this->username = $user->truename;
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

}
