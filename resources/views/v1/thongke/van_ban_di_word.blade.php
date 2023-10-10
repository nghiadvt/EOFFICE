<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=bao_cao_thong_ke_van_ban_di.doc");
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
                <td style="text-align: center;">
                    <h4 style="color:red">THỐNG KÊ VĂN BẢN ĐI</h4>
                </td>
            </tr>
            <tr>
                <td style="width: 250px; text-align: center;vertical-align: top;">
                    <h4 style="margin-top: 5px; margin-bottom: 0;">ĐẠI HỌC ĐÀ NẴNG</h4>
                </td>
            </tr>
            <tr>
                <td colspan='2'></td>
            </tr>
        </table>
    </div>
    <div>
        <div>
            <h4 style="text-align: center; margin: 30px 0 20px 0;">
                @if($donviName) DANH SÁCH NHÂN VIÊN TRỰC THUỘC @else BÁO CÁO THỐNG KÊ VĂN BẢN ĐI @endif <br>
                @if($start_time)
                    Từ ngày {{formatDMY($start_time)}} đến {{formatDMY($end_time)}} <br>
                @endif
                @if($donviName)Đơn vị:  {{$donviName}} @else Thống kê: {{$type == 1 ? 'Theo đơn vị' : 'Theo cá nhân'}} @endif
            </h4>
        </div>
        <table class="border">
            @if($type == 1)
                <thead class="head-table">
                <tr>
                    <th class="col-stt" >TT</th>
                    <th>Đơn vị soạn thảo</th>
                    <th>Số văn bản ban hành</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $val)
                    <tr data-donvi-id="{{ $val->donvi_id }}">
                        <td class="col-stt">{{ $key + 1 }}</td>
                        <td>{{ $val->tenDonviBH }}</a></td>
                        <td>{{ $val->tongVBBanHanh }}</td>
                    </tr>
                @endforeach
                </tbody>
            @else
                <thead class="head-table">
                <tr>
                    <th class="col-stt" >TT</th>
                    <th>Tên cán bộ</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $val)
                    <tr>
                        <td class="col-stt">{{ $key + 1 }}</td>
                        <td class="cursor-pointer detail-donvi">{{ $val->fullname }}</td>
                    </tr>
                @endforeach
                </tbody>
            @endif
        </table>
    </div>
</div>
</body>
</html>