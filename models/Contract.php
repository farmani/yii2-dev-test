<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

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
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Client $buyer
 * @property Client $buyer0
 */
class Contract extends \app\models\base\Contract
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
                [['date'], 'date', 'format' => 'yyyy-MM-dd'],
            ]
        );
    }
}
