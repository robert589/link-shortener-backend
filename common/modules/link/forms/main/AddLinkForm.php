<?php
namespace common\modules\link\forms\main;

use common\modules\link\orms\Link;
/**
 * AddLinkForm service
 *
 */
class AddLinkForm extends \yii\base\Model
{
    
    //attributes
    public $link;

    public function rules() {
        return [
            ['link', 'string'],
            ['link', 'required']
        ];
    }            
    
    public function add() : ?string {
        if(!$this->validate()) {
            return null;
        }
        $randomString = $this->getRandomString(5);
        $link = new Link();
        $link->shortenedKey = $randomString;
        $link->result = $this->link;
        $link->status = Link::STATUS_ACTIVE;
        if(!$link->save()) {
            return null;
        }
        
        return $link->format();
    }
    
    private function getRandomString(int $length) {
        return substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
    }
}