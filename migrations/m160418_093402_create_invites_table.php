<?php

use yii\db\Migration;

class m160418_093402_create_invites_table extends Migration
{
    public function up()
    {
        $this->createTable('invite', [
            'id' => $this->primaryKey(),
            'status' => $this->boolean(),
            'date_activation' => $this->dateTime()
        ]);
    }

    public function down()
    {
        $this->dropTable('invite');
    }
}
