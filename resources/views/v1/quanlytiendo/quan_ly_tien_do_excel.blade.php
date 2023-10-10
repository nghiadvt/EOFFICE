@php
    if ($loai == 'quy'){
        $quy = 'Quý ' . $selected_quy . ' năm ' . $selected_nam;
    }else{
         $quy = 'Tháng ' . formatMY($start_time);
    }
@endphp
<?php
$objPHPExcel = new PHPExcel();
$stylea1 = array(
    'font'  => array(
        'set-width' => 30,
        'color' => array('rgb' => '000000'),
        'size'  => 8,
        'name'  => 'Tahoma',
        'text-transform' => 'uppercase',
        'bold'  => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    )
);
$title = array(
    'font'  => array(
        'bold'  => true,
        'set-width' => 30,
        'color' => array('rgb' => '000000'),
        'size'  => 8,
        'name'  => 'Tahoma',
        'text-transform' => 'uppercase'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    )
);

$stylea3 = array(
    'font'  => array(
        'bold'  => true,
        'set-width' => 30,
        'color' => array('rgb' => '000000'),
        'size'  => 8,
        'name'  => 'Tahoma',
        'text-transform' => 'uppercase'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    )
);
$border_style= array('borders' => array(
    'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
    )
));

function setAutoSize($pValue = false) {
    $this->_autoSize = $pValue;
    return $this;
}
$objPHPExcel->getActiveSheet(1)
    ->setCellValue('B1', 'BỘ GIÁO DỤC VÀ ĐÀO TẠO')
    ->setCellValue('B2', 'ĐẠI HỌC ĐÀ NẴNG');
$objPHPExcel->getActiveSheet(0)->getStyle('C1:E2')->applyFromArray($stylea1);

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('E1', 'QUẢN LÝ TIẾN ĐỘ CÔNG VIỆC');
$objPHPExcel->getActiveSheet(0)->getStyle('A1:G2')->applyFromArray($stylea1);

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('C5', 'BẢNG THEO GIỎI TIẾN ĐỘ CÔNG VIỆC')
    ->setCellValue('C6', $quy);
$objPHPExcel->getActiveSheet(0)->getStyle('A5:E7')->applyFromArray($stylea1);
$objPHPExcel->getActiveSheet()->getStyle("C5")->getFont()->setSize(12);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A9', 'Đơn vị');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet(0)->getStyle('A9')->applyFromArray($title);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B9', 'Nội dung');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
$objPHPExcel->getActiveSheet(0)->getStyle('B9')->applyFromArray($title);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C9', 'Căn cứ');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet(0)->getStyle('C9')->applyFromArray($title);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D9', 'Tiến độ');
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet(0)->getStyle('D9')->applyFromArray($title);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.'9', 'Minh chứng/ Nguyên nhân/ Dự kiến thời gian hoàn thành ');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
$objPHPExcel->getActiveSheet(0)->getStyle('E'.'9')->applyFromArray($stylea3);
$i = 10;
foreach ($datas as $data){
    if($data->count_all - $data->count_done != 0){
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, " ".$data->name);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $j = $i + $data->count_all - 1 - $data->count_done;
        $start = 'A'.$i;
        $end = 'A'.$j;
        $objPHPExcel->getActiveSheet()->mergeCells("$start:$end");
        foreach ($data->array as $val){
            if ($loai == 'quy'){
                if ($val->quy < $selected_nam.$selected_quy && $val->status != 2 || $val->quy == $selected_nam.$selected_quy){
                    if ($val->status == 0){
                        $status = 'Chưa triển khai';
                    }elseif ($val->status == 1){
                        $status = 'Đang triển khai';
                    }elseif ($val->status == 2){
                        $status = 'Hoàn thành';
                    }else{
                        $status = 'Tạm hoãn';
                    }
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B'.$i, " ".$val->content);
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('C'.$i, " ".$val->note);
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('D'.$i, " ".$status);
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('E'.$i, " ".$val->content);
                    $i++;
                }
            }else{
                if (strtotime($val->thang) < strtotime($start_time) && $val->status != 2 || strtotime($val->thang) == strtotime($start_time)){
                    if ($val->status == 0){
                        $status = 'Chưa triển khai';
                    }elseif ($val->status == 1){
                        $status = 'Đang triển khai';
                    }elseif ($val->status == 2){
                        $status = 'Hoàn thành';
                    }else{
                        $status = 'Tạm hoãn';
                    }
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B'.$i, " ".$val->content);
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('C'.$i, " ".$val->note);
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('D'.$i, " ".$status);
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('E'.$i, " ".$val->content);
                    $i++;
                }
            }
        }
    }
}
if ($loai == 'quy'){
    $fileName = './files/Bao_Cao_Tien_Do_Cong_Viec_Quy_'.$selected_quy.'_Nam_'.$selected_nam.'.xlsx';
}else{
    $fileName = './files/Bao_Cao_Tien_Do_Cong_Viec_Thang_'.formatM_Y($start_time).'.xlsx';
}
$objPHPExcel->getActiveSheet()->getStyle('A10:E999')->getAlignment()->setWrapText(true);
$i--;
$objPHPExcel->getActiveSheet(0)->getStyle("A9:"."E".$i)->applyFromArray($border_style);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($fileName);
$file = $fileName;

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($file));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
ob_clean();
flush();
readfile($file);
exit;
?>




