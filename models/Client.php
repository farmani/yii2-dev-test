<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%client}}".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Contract[] $contracts
 * @property Contract[] $contracts0
 */
class Client extends \app\models\base\Client
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                [
                    'class' => BlameableBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                    ],
                ],
                [
                    'class'      => TimestampBehavior::class,
                    'value'      => new Expression('NOW()'),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                ],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['email'], 'unique'],
                ['email', 'email', 'allowName' => true, 'checkDNS' => true, 'enableIDN' => true],
            ]
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyingContracts()
    {
        return $this->hasMany(Contract::class, ['buyer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSellingContracts()
    {
        return $this->hasMany(Contract::class, ['buyer_id' => 'id']);
    }
}
