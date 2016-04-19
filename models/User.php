<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $login
 * @property string $password_hash
 * @property string $auth_key
 * @property string $phone
 * @property integer $city_id
 * @property integer $invite_id
 *
 * @property City $city
 * @property Invite $invite
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'invite_id'], 'integer'],
            [['login'], 'string', 'max' => 20],
            [['password_hash'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 15],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['invite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invite::className(), 'targetAttribute' => ['invite_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'phone' => 'Phone',
            'city_id' => 'City ID',
            'invite_id' => 'Invite ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvite()
    {
        return $this->hasOne(Invite::className(), ['id' => 'invite_id']);
    }

    public static function findFullData()
    {
        return self::find()->select('id, login, phone,');
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByLogin($login)
    {
        return self::findOne(['login' => $login]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('Method "' . __CLASS__ . '::' . __METHOD__ . '" is not implemented.');
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function validatePassword($password, $hash)
    {
        return Yii::$app->security->validatePassword($password, $hash);
    }

    public static function buildPasswordHash($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            if (!empty($this->password_hash)) {
                $this->setAttribute('password_hash', self::buildPasswordHash($this->password_hash));
            }
            return true;
        }
        return false;
    }


}
