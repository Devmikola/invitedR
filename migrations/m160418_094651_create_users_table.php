<?php

use yii\db\Migration;

class m160418_094651_create_users_table extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'login' => $this->string(20),
            'password_hash' => $this->string(60),
            'auth_key' => $this->string(32),
            'phone' => $this->string(15),
            'city_id' => $this->integer(),
            'invite_id' => $this->integer()
        ]);

        $this->addForeignKey('fk-user-city_id', 'user', 'city_id', 'city', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-user-invite_id', 'user', 'invite_id', 'invite', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
