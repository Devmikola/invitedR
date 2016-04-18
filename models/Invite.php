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
            'id' => 'ID',
            'status' => 'Status',
            'date_activation' => 'Date Activation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['invite_id' => 'id']);
    }
}
