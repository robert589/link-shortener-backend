<?php
namespace common\modules\link\orms;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * Link model
 *
 */
class Link extends ActiveRecord
{
    const STATUS_ACTIVE = 10;
    
    const STATUS_DELETED = 0;
    
    public static function tableName()
    {
        return '{{%link}}';
    }
    
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt'
            ],
        ];
    }

    public function format() : string {
        return $this->id . "-" . $this->shortenedKey;
    }

}
