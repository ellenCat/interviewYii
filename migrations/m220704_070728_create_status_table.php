<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status}}`.
 */
class m220704_070728_create_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%status}}', [
            'id' => Schema::TYPE_PK,
            'message' => Schema::TYPE_TEXT.' NOT NULL DEFAULT ""',
            'permissions' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%status}}');
    }

    public function safeUp()
    {
//        $this->createTable('{{%status}}', [
//            'id' => $this->primaryKey(),
//        ]);

        //创建user表

        $this->createTable('{{%status}}', [

            'id' => $this->primaryKey()->comment('用户ID'),

            'message' => $this->string(64)->notNull()->defaultValue('')->comment('text'),

            'permissions' => $this->string(255)->notNull()->defaultValue('')->comment('状态：0 禁用 1开启'),

            'create_time' => $this->integer()->notNull()->defaultValue(0)->comment('创建时间'),

            'update_time' => $this->integer()->notNull()->defaultValue(0)->comment('更新时间'),

        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=MyISAM COMMENT=\'状态表\'');
        $this->createIndex('id', '{{%status}}', 'id');//创建索引

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%status}}');
    }
}
