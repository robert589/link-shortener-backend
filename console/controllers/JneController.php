<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use common\models\Courier;
use common\models\Regency;
use common\models\District;
use common\models\Tariff;

class JneController extends Controller {
    
        
    public function actionUpload() {
        $this->createJne();
        $objPHPExcel = \PHPExcel_IOFactory::load("frontend/web/files/jne.xls");
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        foreach($sheetData as $index => $sheet) {
            if($index >= 6) {
                $regency = $this->getRegency($sheet["A"]);
                $district = $this->getDistrict($sheet["B"], $regency->id);
                $regularTariff = str_replace(",", "", $sheet["C"]);
                $this->createTariff("JNE", $district->id, $regularTariff, $sheet["D"]);
            }
        }
    }
    
    private function createTariff($marketplaceCode, $destinationId, $regularTariff, $regularEtd) {
        $tariff = new Tariff();
        $tariff->courier_code = $marketplaceCode;
        $tariff->destination_id = $destinationId;
        $tariff->regular_tariff = $regularTariff;
        $tariff->regular_etd = $regularEtd;
        $tariff->save();
    }
    
    private function getDistrict($districtName, $regencyId) {
        $district = District::find()->where(['regency_id' => $regencyId, "name" => $districtName])->one();
        if(!$district) {
            $district = new District();
            $district->regency_id = $regencyId;
            $district->name = $districtName;
            $district->save();
        }
        
        return $district;
    }
    
    private function getRegency($regencyName) {
        $regency = Regency::find()->where(['name' => $regencyName])->one();
        
        if(!$regency) {
            $regency = new Regency();
            $regency->name = $regencyName;
            $regency->save();
        }
        
        return $regency;
    }
    
    private function createJne() {
        $courier = Courier::find()->where(['code' => "JNE"])->one();
        if(!$courier) {
            $courier = new Courier;
            $courier->code = "JNE";
            $courier->name = "Jalur Nugraha Ekakurir";
            $courier->save();
        }
    }
}