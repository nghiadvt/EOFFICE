<?php
if ($loai == 'quy'){
    $fileName = 'Bao_Cao_Tien_Do_Cong_Viec_Quy_'.$selected_quy.'_Nam_'.$selected_nam.'.doc';
}else{
    $fileName = 'Bao_Cao_Tien_Do_Cong_Viec_Thang_'.formatMY($start_time).'.doc';
}
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
                BẢNG THEO DÕI TIẾN ĐỘ CÔNG VIỆC <br>
                {{ $loai == 'quy' ? 'Quý ' . $selected_quy . ' năm ' . $selected_nam : 'Tháng ' . formatMY($start_time)  }}<br>
            </h4>
        </div>
        <table class="border">
                <tr>
                    <th>Đơn vị</th>
                    <th>Nội dung</th>
                    <th style="width: 100px;">Căn cứ</th>
                    <th style="width: 100px;">Tiến độ</th>
                    <th>Minh chứng/ Nguyên nhân/ Dự kiến thời gian hoàn thành
                    </th>
                </tr>
            @foreach ($datas as $data)
                @if($data->count_all - $data->count_done != 0)
                    <tr style="display: {{$data->count_all - $data->count_done == '0' ? 'none' : ''}}">
                        <td class="col-stt" rowspan="{{$data->count_all - $data->count_done}}"><b>{{ $data->name }}</b></td>
                            @foreach($data->array as $val)
                            @if($loai == 'quy')
                                @if($val->quy < $selected_nam.$selected_quy && $val->status != 2 || $val->quy == $selected_nam.$selected_quy)
                                    <td style="border: 1px solid">{{ $val->content }}</td>
                                    <td style="border: 1px solid">{{ $val->note }}</td>
                                    <td style="border: 1px solid">
                                        @if($val->status == 0)
                                            Chưa triển khai
                                        @elseif($val->status ==  1)
                                            Đang triển khai
                                        @elseif($val->status ==  2)
                                            Hoàn thành
                                        @elseif($val->status ==  3)
                                            Đang tạm hoãn
                                        @endif
                                    </td>
                                    <td style="border: 1px solid">{{ $val->minhchung }}</td>
                                </tr>
                                @endif
                            @else
                                @if(strtotime($val->thang) < strtotime($start_time) && $val->status != 2 || strtotime($val->thang) == strtotime($start_time))
                                    <td style="border: solid 1px">{{ $val->content }}</td>
                                    <td style="border: solid 1px">{{ $val->note }}</td>
                                    <td style="border: solid 1px">
                                        @if($val->status == 0)
                                            Chưa triển khai
                                        @elseif($val->status ==  1)
                                            Đang triển khai
                                        @elseif($val->status ==  2)
                                            Hoàn thành
                                        @elseif($val->status ==  3)
                                            Đang tạm hoãn
                                        @endif
                                    </td>
                                    <td style="border: solid 1px">{{ $val->minhchung }}</td>
                                </tr>
                            @endif
                            @endif
                    @endforeach
                @endif
            @endforeach
        </table>
    </div>
</div>
</body>
</html>