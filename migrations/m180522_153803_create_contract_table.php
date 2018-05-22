<?php

use yii\db\Migration;

/**
 * Handles the creation of table `contract`.
 */
class m180522_153803_create_contract_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contract}}', [
            'id' => $this->primaryKey(),
            'number' => $this->string(100)->notNull(),
            'description' => $this->text()->null(),
            'buyer_id' => $this->integer(11)->notNull(),
            'seller_id' => $this->integer(11)->notNull(),
            'date' => $this->date()->notNull(),
            'amount' => $this->money(10,2)->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created_by' => $this->integer(11)->notNull(),
            'updated_by' => $this->integer(11)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->execute('CREATE TRIGGER contract_created_at BEFORE INSERT ON {{%contract}} FOR EACH ROW BEGIN SET NEW.created_at = IFNULL(NEW.created_at, NOW()); SET NEW.updated_at = IFNULL(NEW.updated_at, NOW()); END;');
        $this->execute('CREATE TRIGGER contract_updated_at BEFORE UPDATE ON {{%contract}} FOR EACH ROW SET NEW.updated_at = IFNULL(NEW.updated_at, NOW());');
        $this->createIndex('idx-contract-status_1', '{{%contract}}', 'status');
        $this->createIndex('idx-contract-created_by_1', '{{%contract}}', 'created_by');
        $this->createIndex('idx-contract-updated_by_1', '{{%contract}}', 'updated_by');
        $this->createIndex('idx-contract-created_at_1', '{{%contract}}', 'created_at');
        $this->createIndex('idx-contract-updated_at_1', '{{%contract}}', 'updated_at');
        $this->createIndex('idx-contract_client-buyer_id_1', '{{%contract}}', 'buyer_id');
        $this->createIndex('idx-contract_client-seller_id_1', '{{%contract}}', 'seller_id');
        $this->addForeignKey(
            'fk-contract_client-buyer_id_1',
            '{{%contract}}',
            'buyer_id',
            '{{%client}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-contract_client-seller_id_1',
            '{{%contract}}',
            'seller_id',
            '{{%client}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contract}}');
    }
}
