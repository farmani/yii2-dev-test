<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%contract}}".
 *
 * @property int $id
 * @property string $number
 * @property string $description
 * @property int $buyer_id
 * @property int $seller_id
 * @property string $date
 * @property string $amount
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Client $buyer
 * @property Client $seller
 */
class Contract extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contract}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'buyer_id', 'seller_id', 'date', 'amount'], 'required'],
            [['description'], 'string'],
            [['buyer_id', 'seller_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['number'], 'string', 'max' => 100],
            [['amount'], 'number'],
            [['buyer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['buyer_id' => 'id']],
            [['seller_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['seller_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'description' => 'Description',
            'buyer_id' => 'Buyer ID',
            'seller_id' => 'Seller ID',
            'date' => 'Date',
            'amount' => 'Amount',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyer()
    {
        return $this->hasOne(Client::className(), ['id' => 'buyer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Client::className(), ['id' => 'seller_id']);
    }
}
