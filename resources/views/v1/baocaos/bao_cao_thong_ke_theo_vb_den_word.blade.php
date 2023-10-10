<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=bao_cao_thong_ke_van_ban_den.doc");
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
                    <h4 style="color:red">THỐNG KÊ VĂN BẢN ĐẾN</h4>
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
                BÁO CÁO THỐNG KÊ VĂN BẢN ĐẾN <br>
                Từ ngày {{formatDMY($start_time)}} đến {{formatDMY($end_time)}} <br>
                @if($donviName)Đơn vị:  {{$donviName}} @else Thống kê: {{$type == 1 ? 'Theo đơn vị' : 'Theo cá nhân'}} @endif
            </h4>
        </div>
        <table class="border">
            @if($type == 1)
                <thead class="head-table">
                    <tr>
                        <th class="col-stt" rowspan="2">TT</th>
                        <th rowspan="2">Đơn vị</th>
                        <th rowspan="2">Văn bản chủ trì</th>
                        <th rowspan="2">Văn bản phối hợp</th>
                        <th colspan="3">Tình trạng</th>
                    </tr>
                    <tr>
                        <th>Hoàn thành đúng hạn</th>
                        <th>Hoàn thành quá hạn</th>
                        <th>Chưa hoàn thành</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $val)
                        <tr>
                            <td class="col-stt">{{ $key+1 }}</td>
                            <td>{{ $val->tenDonViNhan }}</td>
                            <td>{{ $val->tongVBChuTri }}</td>
                            <td>{{ $val->tongVBPhoiHop }}</td>
                            <td>{{ $val->tongVBHoanThanhDungHan }}</td>
                            <td>{{ $val->tongVBHoanThanhQuaHan }}</td>
                            <td>{{ $val->tongVBChuaHoanThanh }}</td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <thead>
                <tr>
                    <th rowspan="2">TT</th>
                    <th rowspan="2">Cán bộ</th>
                    <th rowspan="2">Văn bản chủ trì</th>
                    <th rowspan="2">Văn bản phối hợp</th>
                    <th colspan="3">Tình trạng</th>
                </tr>
                <tr>
                    <th>Hoàn thành đúng hạn</th>
                    <th>Hoàn thành quá hạn</th>
                    <th>Chưa hoàn thành</th>
                </tr>
                </thead>
                <tbody style="border-bottom: 1pt solid windowtext;">
                    @foreach ($data as $key => $val)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $val->fullname }}</td>
                            <td>{{ $val->tongVBChuTri }}</td>
                            <td>{{ $val->tongVBPhoiHop }}</td>
                            <td>{{ $val->tongVBHoanThanhDungHan }}</td>
                            <td>{{ $val->tongVBHoanThanhQuaHan }}</td>
                            <td>{{ $val->tongVBChuaHoanThanh }}</td>
                        </tr>
                    @endforeach
                </tbody>
            @endif
        </table>
    </div>
</div>
</body>
</html>