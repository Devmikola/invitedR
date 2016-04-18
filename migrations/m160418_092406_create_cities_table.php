<?php

use yii\db\Migration;

class m160418_092406_create_cities_table extends Migration
{
    public function up()
    {
        $this->createTable('city', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer(),
            'name' => $this->string()
        ]);

        $this->addForeignKey('fk-city-country_id', 'city', 'country_id', 'country', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('city');
    }
}
