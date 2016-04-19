<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invite".
 *
 * @property integer $id
 * @property integer $status
 * @property string $date_activation
 *
 * @property User[] $users
 */
class Invite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'required', 'message' => 'Поле "{attribute}" не может быть пустым'],
            ['id', 'match', 'pattern' => '/^\d{6}$/', 'message' => 'Код инвайта должен состоять из 6 цифр.'],
            ['id', 'unique', 'message' => 'Инвайт с таким кодом уже существует.'],
            [['status'], 'integer'],
            [['date_activation'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код инвайта',
            'status' => 'Status',
            'date_activation' => 'Date Activation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['invite_id' => 'id']);
    }
}
