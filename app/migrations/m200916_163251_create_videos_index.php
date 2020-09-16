<?php

use yii\db\Migration;

/**
 * Class m200916_163251_create_videos_index
 */
class m200916_163251_create_videos_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createIndex('idx-videos-added-id', 'videos', 'added, id');
         $this->createIndex('idx-videos-views-id', 'videos', 'views, id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-videos-added-id', 'videos');
        $this->dropIndex('idx-videos-views-id', 'videos');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200916_163251_create_videos_index cannot be reverted.\n";

        return false;
    }
    */
}
