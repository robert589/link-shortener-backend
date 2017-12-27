<?php

use yii\db\Migration;

/**
 * Class m171227_093021_add_count_to_link
 */
class m171227_093021_add_count_to_link extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

        $this->execute("ALTER TABLE link add visitCount int not null default 0");
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171227_093021_add_count_to_link cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171227_093021_add_count_to_link cannot be reverted.\n";

        return false;
    }
    */
}
