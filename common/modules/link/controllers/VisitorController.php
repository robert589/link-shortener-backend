<?php
namespace common\modules\link\controllers;

use Yii;
use common\modules\link\forms\visitor\IncrementVisitor;
use yii\web\Controller;
/**
 * VisitorController controller
 */
class VisitorController extends Controller
{
    public $enableCsrfValidation = false;
    
      
    public static function allowedDomains() {
        return [
             '*',                        // star allows all domains
//            'http://test1.example.com',
//            'http://test2.example.com',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return array_merge(parent::behaviors(), [

            // For cross-domain AJAX request
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
                'cors'  => [
                    // restrict access to domains:
                    'Origin'                           => static::allowedDomains(),
                    'Access-Control-Request-Method'    => ['POST'],
                    'Access-Control-Request-Headers' => ['Content-Type', 'Authorization'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                ]
            ],
            \rkit\behaviors\AuthBehavior::className()

        ]);
    }

    
}


