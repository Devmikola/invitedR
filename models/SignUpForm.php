<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Invite;
use app\models\User;

class SignUpForm extends  \yii\base\Model
{
    public $login;
    public $password;
    public $password_confirmation;
    public $phone;
    public $country;
    public $city;
    public $invite_id;

    public function scenarios()
    {
        $scenarios = [
            'user_create' => ['phone', 'login', 'password', 'city', 'country', 'password_confirmation', 'invite_id'],
        ];

        return array_merge(parent::scenarios(), $scenarios);
    }

    public function rules()
    {
        return [

            [['login', 'password', 'password_confirmation', 'phone', 'invite_id'], 'required', 'message' => 'Поле "{attribute}" не должно быть пустым.',  'skipOnEmpty' => false, 'skipOnError' => false],
            ['login', 'string', 'min' => 5, 'max' => 20, 'tooShort' => 'Логин должен быть не менее 5 символов.','tooLong' => 'Логин должен быть не более 20 символов.'],
            ['login', 'match', 'pattern' => '/^[a-z0-9]+$/i', 'message' => 'Логин должен содержать только буквы латинского алфавита и цифры от 0 до 9.'],
            ['password', 'string', 'min' => 5, 'max' => 20, 'tooShort' => 'Пароль должен быть не менее 5 символов.','tooLong' => 'Пароль должен быть не более 20 символов.'],
            ['password', 'match', 'pattern' => '/^[a-z0-9]+$/i', 'message' => 'Пароль должен содержать только буквы латинского алфавита и цифры от 0 до 9.'],
            ['password_confirmation', 'compare', 'compareAttribute' => 'password', 'message' => "Пароли не совпадают." ],
            ['invite_id', 'match', 'pattern' => '/^\d{6}$/', 'message' => 'Инвайт должен состоять из 6 цифр.'],

            ['login', function ($attribute){
                if(User::findOne(['login' => $this->$attribute])) {
                    $this->addError($attribute, 'Этот логин уже занят.');
                }
            }],
            ['invite_id', function ($attribute){
                $invite = Invite::findOne($this->$attribute);
                if(!$invite) {
                    $this->addError($attribute, 'Такого инвайта не обнаружено.');
                } elseif($invite->status) {
                    $this->addError($attribute, 'Данный инвайт уже не активен.');
                }
            }],
            ['phone', function ($attribute) {
                $phone_length = strlen(preg_replace('/\D/', '', $this->$attribute));
                if ($phone_length > 15) {
                    $this->addError($attribute, 'Телефон должен содержать не более 15 цифр');
                }
                elseif ($phone_length < 10)
                {
                    $this->addError($attribute, 'Телефон должен содержать не менее 10 цифр.');
                }
            }],
            ['phone', function($attribute){
                if(preg_match('/[^()+\d\s]/', $this->$attribute))
                {
                    $this->addError($attribute, 'Телефон должен содержать только цифры и быть в таком формате +01 (234) 567-89-01 или таком 012 345 67 89 или таком (012) 345 67 89.');
                }
                if(!(preg_match('/^\+[\d]+\s*\([\d]+\)\s*[\d\-]+$/', $this->$attribute)
                    || preg_match('/^[\d\s]+$/', $this->$attribute)
                    || preg_match('/^\(\d+\)\s*[\d\s]+$/', $this->$attribute)))
                {
                    $this->addError($attribute, 'Телефон должен быть в таком формате +01 (234) 567-89-01 или таком 012 345 67 89 или таком (012) 345 67 89.');
                }
                }],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
            'password_confirmation' => 'Подтверждение пароля',
            'phone' => 'Телефон',
            'country' => 'Страна',
            'city' => 'Город',
            'invite_id' => 'Инвайт',
        ];
    }

    public function save()
    {

    }
}