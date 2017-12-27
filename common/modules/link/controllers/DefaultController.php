<?php
namespace common\modules\link\controllers;

use common\modules\link\forms\main\GetRealLinkForm;
use common\modules\link\forms\main\AddLinkForm;
use Yii;
use common\modules\link\forms\main\TotalLink;
use common\modules\link\forms\main\ListLink;
use common\modules\link\forms\main\IncrementVisitor;
use yii\web\Controller;
/**
 * Default controller
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;
    
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'PUT', 'OPTIONS','GET'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Headers' => ['X-Wsse', 'application/json', 'content-type', 'Authorization'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ]

            ]
        ];
    }
    
    public function init() {
        
    }
    
    public function actionAdd() {
        $form = new AddLinkForm();
        $form->link = isset($_POST['link']) ? $_POST['link'] : null;
        $shortenedLink = $form->add();
        return $shortenedLink ? json_encode($shortenedLink) : json_encode($form->getErrors());
    }
    
    
    public function actionGet() {
        $form = new GetRealLinkForm();
        $form->shortenedKey = isset($_GET['shortenedKey']) ? $_GET['shortenedKey'] : null;
        $result = $form->get();
        return $result ? json_encode($result) : json_encode($form->getErrors());
    }
    
    public function actionIncrementVisit() {
        $form = new IncrementVisitor();
        $form->shortenedKey = isset($_GET['shortenedKey']) ? $_GET['shortenedKey'] : null;
        $result = $form->increment();
        return $result ? json_encode($result) : json_encode($form->getErrors());
    }
    
    public function actionList() {
        $form = new ListLink();
        $form->page = isset($_GET['page']) ? $_GET['page'] : null;
        $form->pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : null;
        $result = $form->list();
        return $result ? json_encode($result) : json_encode($form->getErrors());
        
    }
    
    public function actionTotal() {
        $form = new TotalLink();
        return $form->get();
    }
}

