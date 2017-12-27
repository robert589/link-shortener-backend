<?php
namespace common\modules\link\forms\main;

use rkit\components\RService;
use common\modules\link\daos\LinkDao;
/**
 * TotalLink service
 *
 */
class TotalLink extends \yii\base\Model
{
    
    private $linkDao;
    
    public function init() {
        $this->linkDao = new LinkDao();
    }

    public function rules() {
        return [
            
        ];
    }            
    
    public function get() {
        return $this->linkDao->total();
    }
}