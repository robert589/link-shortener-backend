<?php
namespace common\modules\link\forms\main;

use common\modules\link\orms\Link;
/**
 * GetRealLinkForm service
 *
 */
class GetRealLinkForm extends \yii\base\Model
{
    
    //attributes
    public $shortenedKey;

    private  $link;
    
    public function rules() {
        return [
            ['shortenedKey', 'string'],
            ['shortenedKey', 'required'],
            ['shortenedKey', 'findUrl']
        ];
    }            
    
    public function findUrl() {
        $keys = explode("-", $this->shortenedKey);
        if(count($keys) != 2) {
            $this->addError("shortenedKey", "Not found ..");
            return;
        }
        
        $this->link = Link::find()->where(['id' => $keys[0], 'shortenedKey' => $keys[1] ])->one();
        if(!$this->link) {
            $this->addError("shortenedKey", "Not found");
            return;
        }
    }
    
    public function get() : ?string {
        if(!$this->validate()) {
            return null;
        }
        
        return $this->link->result;
    }
}