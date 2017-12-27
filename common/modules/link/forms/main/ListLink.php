<?php
namespace common\modules\link\forms\main;

use common\modules\link\daos\LinkDao;
use common\modules\link\orms\Link;
/**
 * 
 * ListLink service
 *
 */
class ListLink extends \yii\base\Model
{
    
    //attributes
    public $page;

    public $pageSize;
    
    private  $linkDao;
    
    public function init() {
        $this->linkDao = new LinkDao();
    }

    public function rules() {
        return [
            ['page', 'integer', 'min' => 1],
            ['page', 'default', 'value' => 1],
            ['pageSize', 'integer'],
            ['pageSize', 'default', 'value' => 5],
        ];
    }   
    
    public function  list() : ?array {
        if(!$this->validate()) {
            return null;
        }
        
        $links = $this->linkDao->list($this->page, $this->pageSize);
        
        $models  = [];
        if(!is_array($links)) {
            return null;
        }
        foreach($links as $link) {
            $model['link'] = $link['result'];
            $model['count'] = $link['count'];
            $models[] = $model;
        }
        
        return $models;
    }
}