<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    private $_id;
    
    /**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$users= User::model()->findByAttributes(array('username'=>  $this->username));
		if($users===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users->password!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
                {       $this->_id = $users->id;
            
                     $shop =   Shop::model()->findByAttributes(array('user_id'=>$this->_id));
                        if($shop===null)
                        {
                            $this->setState('shop', 'You have not created your Shop yet Please Create Your shop now');
                        }
                        $this->username = $users->username;
			$this->errorCode=self::ERROR_NONE;
                }
		return !$this->errorCode;
	}
        public function getId() {
            return $this->_id;

        }
       
}