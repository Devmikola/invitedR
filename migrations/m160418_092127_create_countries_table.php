<?php

use yii\db\Migration;

class m160418_092127_create_countries_table extends Migration
{
    public function up()
    {
        $this->createTable('country', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);
    }

    public function down()
    {
        $this->dropTable('country');
    }
}
