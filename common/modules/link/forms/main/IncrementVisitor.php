<?php
namespace common\modules\link\forms\main;

use common\modules\link\orms\Link;
/**
 * IncrementVisitor service
 *
 */
class IncrementVisitor extends \yii\base\Model
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
    
    public function increment() : bool {
        if(!$this->validate()) {
            return false;
        }
        
        $this->link->visitCount = intval($this->link->visitCount) + 1;
        $this->link->update();
        return true;
    }
}