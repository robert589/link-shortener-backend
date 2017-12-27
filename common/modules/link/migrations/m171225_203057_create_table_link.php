<?php

use yii\db\Migration;

/**
 * Class m171225_203057_create_table_link
 */
class m171225_203057_create_table_link extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

        $this->execute("CREATE TABLE link(
            id int not null primary key auto_increment,
            shortenedKey varchar(200) not null UNIQUE,
            result text not null,
            status smallint(6) not null,
            createdAt int not null,
            updatedAt int not null)");
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171225_203057_create_table_link cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171225_203057_create_table_link cannot be reverted.\n";

        return false;
    }
    */
}
