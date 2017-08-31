<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            //[['username', 'password'], 'required'],
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }
	
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */    
	protected function getUser()
    {
        if ($this->_user === null) {
            //$this->_user = User::findByUsername($this->username);
            $this->_user = User::findByEmail($this->email);
			
        }
        return $this->_user;
    }
	
	/* super admin st */
	public function loginSysAdmin()
    {
		if ($this->validate()) {
            return Yii::$app->user->login($this->sysAdmin(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }
	
	protected function sysAdmin()
    {
        if ($this->_user === null) {
            $this->_user = User::findSysAdmin($this->email);
			
        }
        return $this->_user;
    }
	
	public function beforeValidate() 
	{
		if( !User::findSysAdmin($this->email) )
		{
			$this->addError( "password", "You are not a administrator!" );
			return false;
		} else {
			return parent::beforeValidate();
		}
	}
	/* super admin en */
	
}
