<?php

use yii\db\Migration;

/**
 * Handles the creation of table `client`.
 */
class m180522_153744_create_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'surname' => $this->string(100)->notNull(),
            'email' => $this->string(250)->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created_by' => $this->integer(11)->notNull(),
            'updated_by' => $this->integer(11)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->execute('CREATE TRIGGER client_created_at BEFORE INSERT ON {{%client}} FOR EACH ROW BEGIN SET NEW.created_at = IFNULL(NEW.created_at, NOW()); SET NEW.updated_at = IFNULL(NEW.updated_at, NOW()); END;');
        $this->execute('CREATE TRIGGER client_updated_at BEFORE UPDATE ON {{%client}} FOR EACH ROW SET NEW.updated_at = IFNULL(NEW.updated_at, NOW());');
        $this->createIndex('idx-client-status_1', '{{%client}}', 'status');
        $this->createIndex('idx-client-created_by_1', '{{%client}}', 'created_by');
        $this->createIndex('idx-client-updated_by_1', '{{%client}}', 'updated_by');
        $this->createIndex('idx-client-created_at_1', '{{%client}}', 'created_at');
        $this->createIndex('idx-client-updated_at_1', '{{%client}}', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client}}');
    }
}
