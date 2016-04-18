<?php

namespace app\models;

use Yii;

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
class User extends \yii\db\ActiveRecord
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
}
