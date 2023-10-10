<?php
if ($loai == 'quy'){
    $fileName = 'Thong_Ke_So_Luong_Tien_Do_Cong_Viec_Quy_'.$selected_quy.'_Nam_'.$selected_nam.'.doc';
}else{
    $fileName = 'Thong_Ke_So_Luong_Tien_Do_Cong_Viec_Thang_'.formatMY($start_time).'.doc';
}
$stt = ($datas->currentPage() - 1) * $datas->perPage() + 1;
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fileName");
header("Pragma: no-cache");
header("Expires: 0");
?>

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">
        body{
            padding: 0px;
            margin: 0px;
            font-family: Times New Roman;
            font-size: 10pt;
        }
        h3 {
            margin: 0;
        }
        .container{
            width: 888pt;
            padding-left: 5px
        }
        table {
            background-color: transparent;
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }
        table.border th {
            border: 1pt solid windowtext;
            color: #000000;
            padding: 1px 0;
            text-align: center;
            font-size: 11pt;
            font-weight: normal;
            font-family: Times New Roman;
            font-weight: 600;
        }
        table.border tr td {
            border: 1pt solid windowtext;
            padding : 2px;
            font-size: 11pt;
            height: 20px;
            font-family: Times New Roman;
            vertical-align: middle;
            text-align: left;
        }
        table.border tr.first-hand td {
            border-bottom: 0;
        }
        table.border tr.second-hand td {
            border-top: 1pt dashed windowtext;
            border-bottom: 0;
        }
        table.border tr.third-hand td {
            border-top: 1pt dashed windowtext;
            border-bottom: 1pt solid windowtext;
        }
        table.border tr.four-hand td {
            border-top: 1pt solid windowtext;
            border-bottom: 1pt solid windowtext;
        }

        @page container {
            size: 29.7cm 21cm;
            margin: 1cm 1cm 1cm 1cm;
            mso-page-orientation: landscape;
            mso-footer: f1;
        }
        div.container { page:container;}
    </style>
</head>
<body>
<div class="container">
    <div style="margin-bottom: 30px;">
        <table class="title_top">
            <tr>
                <td style="width: 250px; text-align: center;">
                    <h4>BỘ GIÁO DỤC VÀ ĐÀO TẠO</h4>
                </td>
                <td colspan="100"></td>
                <td style="text-align: center; float: right">
                    <h4 style="color:red">QUẢN LÝ TIẾN ĐỘ</h4>
                </td>
            </tr>
            <tr>
                <td style="width: 250px; text-align: center;vertical-align: top;">
                    <h4 style="margin-top: 5px; margin-bottom: 0;">ĐẠI HỌC ĐÀ NẴNG</h4>
                </td>
                <td colspan="100"></td>
            </tr>
            <tr>
                <td colspan='2'></td>
            </tr>
        </table>
    </div>
    <div>
        <div>
            <h4 style="text-align: center; margin: 30px 0 20px 0;">
                THỐNG KÊ SỐ LƯỢNG TIẾN ĐỘ CÔNG VIỆC <br>
                {{ $loai == 'quy' ? 'Quý ' . $selected_quy . ' năm ' . $selected_nam : 'Tháng ' . formatMY($start_time)  }}<br>
            </h4>
        </div>
        <table class="border">
            <tr>
                <th rowspan="3">TT</th>
                <th rowspan="3" style="width: 400px">Đơn vị</th>
                <th rowspan="3">Tổng công việc</th>
                <th colspan="8">Tình trạng</th>
            </tr>
            <tr>
                <th colspan="2">Hoàn thành</th>
                <th colspan="2">Đang triển khai</th>
                <th colspan="2">Chưa triển khai</th>
                <th colspan="2">Tạm hoãn</th>
            </tr>
            <tr>
                <th>Số lượng</th>
                <th>Tỉ lệ</th>
                <th>Số lượng</th>
                <th>Tỉ lệ</th>
                <th>Số lượng</th>
                <th>Tỉ lệ</th>
                <th>Số lượng</th>
                <th>Tỉ lệ</th>
            </tr>
            @foreach ($datas as $key =>  $data)
                <?php
                    $tong = $data->hoanthanh + $data->danglam + $data->chualam + $data->tamhoan;
                ?>
                <tr>
                    <td>{{$stt++}}</td>
                    <td>{{$data->name}}</td>
                    <td class="text-center">{{$tong}}</td>
                    <td class="text-center">{{$data->hoanthanh}}</td>
                    <td class="text-center">{{ is_int(($data->hoanthanh) > 0 ? (( $data->hoanthanh) * 100 / ($tong)) : 0) ? (($data->hoanthanh) > 0 ? (( $data->hoanthanh) * 100 / ($tong)) : 0) : number_format((($data->hoanthanh) * 100 > 0 ? (( $data->hoanthanh) * 100 / ($tong)) : 0) ,2) }}%</td>
                    <td class="text-center">{{$data->danglam}}</td>
                    <td class="text-center">{{ is_int(($data->danglam) > 0 ? (( $data->danglam) * 100 / ($tong)) : 0) ? (($data->danglam) > 0 ? (( $data->danglam) * 100 / ($tong)) : 0) : number_format((($data->danglam) * 100 > 0 ? (( $data->danglam) * 100 / ($tong)) : 0) ,2) }}%</td>
                    <td class="text-center">{{$data->chualam}}</td>
                    <td class="text-center">{{ is_int(($data->chualam) > 0 ? (( $data->chualam) * 100 / ($tong)) : 0) ? (($data->chualam) > 0 ? (( $data->chualam) * 100 / ($tong)) : 0) : number_format((($data->chualam) * 100 > 0 ? (( $data->chualam) * 100 / ($tong)) : 0) ,2) }}%</td>
                    <td class="text-center">{{$data->tamhoan}}</td>
                    <td class="text-center">{{ is_int(($data->tamhoan) > 0 ? (( $data->tamhoan) * 100 / ($tong)) : 0) ? (($data->tamhoan) > 0 ? (( $data->tamhoan) * 100 / ($tong)) : 0) : number_format((($data->tamhoan) * 100 > 0 ? (( $data->tamhoan) * 100 / ($tong)) : 0) ,2) }}%</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
</body>
</html>