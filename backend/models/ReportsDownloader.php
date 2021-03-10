<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "prayer_timings".
 *
 * @property int $autoid
 * @property string $prayerType
 * @property string $eventName
 * @property string $slotNo
 * @property string $startTime
 * @property string $endTime
 * @property string $createdAt
 * @property string $updatedAt
 * @property string $ipAddress
 */
class ReportsDownloader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prayer_timings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['startTime', 'endTime', 'createdAt', 'updatedAt'], 'safe'],
            [['eventName', 'ipAddress'], 'safe'],
            [['slotNo'],'safe'],
            [['prayerType'],'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'autoid' => 'Autoid',
            'prayerType' => 'Prayer Type',
            'eventName' => 'Event Name',
            'slotNo' => 'Slot No',
            'startTime' => 'Start Time',
            'endTime' => 'End Time',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'ipAddress' => 'Ip Address',
        ];
    }

    # Author : jana 
    # To Download Excel Dynamically Sample
    public function excelDownloadSample(){
        $session = Yii::$app->session;
        $objPHPExcel = new \PHPExcel();
        $sheet = 0;
        $alpha = 65;
        $alpha2 = 64; 
        $row = $alphaCount = 1;
        $objPHPExcel -> setActiveSheetIndex($sheet);
        $bodyAr = $headerAr = array();
        $max = 100; # From his you can Create 702 Colomn Cell Values
        for ($i=1; $i <= $max; $i++) { 
            $headerAr[] = 'Head '.$i;
        }
        $max2 = 20;
        for ($i=1; $i <= $max2; $i++) {
            $ar = array();
            for ($j=0; $j < $max; $j++) { 
                $ar['bodyAr'.$j] = 'bodyAr'.$j;
            }
            $bodyAr[] = $ar;
        }
        if(true){
            $objPHPExcel -> getActiveSheet() -> setTitle("Report");
            foreach ($headerAr as $key => $oneHead) {
                if($alpha == 91){
                    $alpha2++;
                    $alphaCount++;
                    $alpha = 65;
                }
                if($alphaCount>1){
                    $charVal = chr($alpha2).chr($alpha++);
                }else{
                    $charVal = chr($alpha++);
                }

                $objPHPExcel -> getActiveSheet() -> setCellValue($charVal.$row,$oneHead);
            }
            $row++; 

            foreach ($bodyAr as $keyq => $oneBodyAll) {
                $alphaCount=1;
                $alpha = 65;
                $alpha2 = 64; 
                foreach ($oneBodyAll as $key => $oneBody) {
                    if($alpha == 91){
                        $alpha2++;
                        $alphaCount++;
                        $alpha = 65;
                    }
                    if($alphaCount>1){
                        $charVal = chr($alpha2).chr($alpha++);
                    }else{
                        $charVal = chr($alpha++);
                    }
                    $objPHPExcel -> getActiveSheet() -> setCellValue($charVal.$row,$oneBody);                    
                }
                $row++;
            }
            $objPHPExcel -> getActiveSheet();            
        }
      
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        header('Content-Type: text/csv');
        $filename = "Report_".date("d-m-Y-His").".csv";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');     
         $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        $objWriter->save('php://output');die;
    
    }

    # Author : jana 
    # To Download Excel Dynamically
    public function excelDownload($input = array()){
        $bodyAr = $headerAr = array();
        $reportName = "";
        if(!empty($input)){              
            if(array_key_exists('header', $input)){
                $headerAr = $input['header'];
            }if(array_key_exists('body', $input)){
                $bodyAr = $input['body'];
            } if(array_key_exists('reportName', $input)){
                $reportName = $input['reportName'];
            }  
            if(!empty($bodyAr)){
                $session = Yii::$app->session;
                $objPHPExcel = new \PHPExcel();
                $sheet = 0;
                $alpha = 65;
                $alpha2 = 64; 
                $row = $alphaCount = 1;
                $objPHPExcel -> setActiveSheetIndex($sheet);


                
                $max = 100; # From his you can Create 702 Colomn Cell Values
                
                if(true){
                    $objPHPExcel -> getActiveSheet() -> setTitle("Report");
                    foreach ($headerAr as $key => $oneHead) {
                        if($alpha == 91){
                            $alpha2++;
                            $alphaCount++;
                            $alpha = 65;
                        }
                        if($alphaCount>1){
                            $charVal = chr($alpha2).chr($alpha++);
                        }else{
                            $charVal = chr($alpha++);
                        }

                        $objPHPExcel -> getActiveSheet() -> setCellValue($charVal.$row,$oneHead);
                    }
                    $row++; 

                    foreach ($bodyAr as $keyq => $oneBodyAll) {
                        $alphaCount=1;
                        $alpha = 65;
                        $alpha2 = 64; 
                        foreach ($oneBodyAll as $key => $oneBody) {
                            if($alpha == 91){
                                $alpha2++;
                                $alphaCount++;
                                $alpha = 65;
                            }
                            if($alphaCount>1){
                                $charVal = chr($alpha2).chr($alpha++);
                            }else{
                                $charVal = chr($alpha++);
                            }
                            $objPHPExcel -> getActiveSheet() -> setCellValue($charVal.$row,$oneBody);                    
                        }
                        $row++;
                    }
                    $objPHPExcel -> getActiveSheet();            
                }
              
                $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
                header('Content-Type: text/csv');
                $filename = $reportName.'('.date("d-m-Y-His").").csv";
                header('Content-Disposition: attachment;filename='.$filename .' ');
                header('Cache-Control: max-age=0');     
                 $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
                $objWriter->save('php://output');die;

            } else{
                return 'error';
            }       
        }else{
            return 'error';
        }

    
    }
}
