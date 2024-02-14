<?php
$dbname = "phpadvance";
$servername = "localhost";
$username = "root";
$password = "zaq12wsx";
$dsn = "mysql:dbname=".$dbname.";host=".$servername;
$dbh = new PDO($dsn, $username, $password);

$event = htmlspecialchars($_POST["event"]);

$Checkbox = $_POST["Checkbox"];
$PinName = $_POST["PinNameVal"];
$OdrQty = $_POST["OdrQty"];
$StdQty = $_POST["StdQty"];

if ($event == "update") {
    if (count($Checkbox) > 0) {
        foreach ($Checkbox as $key => $val) {
            $sql = "UPDATE m_pin SET ";
            $sql.= "ODR_QTY = ".$OdrQty[$key]." ";
            if ($StdQty[$key]) $sql.= ",STD_QTY = ".$StdQty[$key]." ";
            $sql.= ",UPDATE_DATETIME = now() ";
            $sql.= "WHERE PIN_NAME = '".$PinName[$key]."'";
            $dbh->exec($sql);
        }
        echo "<script>alert('変更しました。');</script>";
    }
}

if ($event == "delete") {

}

$event = "";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>ピン</title>
</head>
<body style="background-color:aliceblue;">
    <form method="post" name="frm1">
        <!-- 検索・処理 -->
        <div class="container-fluid mt-3 mb-3">
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            検索条件
                        </div>
                        <div class="card-body pb-2">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td>
                                        <label class="col-form-label" for="PinName">ピン名(%)</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-center filter-input" style="width:150px;" id="PinName" name="PinName">
                                    </td>
                                    <td>
                                        <label class="col-form-label" for="ItemCd">品番(%)</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-center filter-input" style="width:150px;" id="ItemCd" name="ItemCd">
                                    </td>
                                    <td>
                                        <label  class="col-form-label"for="MoldItemCd">型番(%)</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-center filter-input" style="width:100px;" id="MoldItemCd" name="MoldItemCd">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="align-middle">
                                        <input type="checkbox" class="form-check-input filter-input" name="chkStockOut" id="chkStockOut">
                                        <label for="chkStockOut" class="form-check-label">在庫数が発注以下を表示</label>
                                        <input type="checkbox" class="form-check-input ms-4 filter-input" name="chkShotOut" id="chkShotOut">
                                        <label for="chkShotOut" class="form-check-label">基準ショット数超えを表示</label>
                                        <input type="checkbox" class="form-check-input ms-4 filter-input" name="chkDelFlg" id="chkDelFlg">
                                        <label for="chkDelFlg" class="form-check-label">削除済みも表示</label>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" style="width:100px;" id="btnSearch">検索</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            処理
                        </div>
                        <div class="card-body pb-2">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-success" style="width:100px;" id="btnNew" title="ピンを新規登録する画面を表示">新規登録</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning" style="width:100px;" id="btnUpdate" title="一覧の中でチェックが入っているピンの発注点、基準ショット数を変更">変更</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" id="btnDelete" style="width:100px;">削除</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-info" style="width:100px;" id="btnLink" title="品番＋型番へピンを紐付ける画面を表示">型紐付け</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-secondary" style="width:100px;" id="btnCsv">CSV出力</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-dark" style="width:100px;" id="btnClose">閉じる</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 一覧 -->
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-dark sticky-top">
                            <tr class="text-center align-middle">
                                <th>
                                    <input type="checkbox" class="form-check-input" name="" id="">
                                </th>
                                <th>ピン名</th>
                                <th>傾斜<br>ピン</th>
                                <th>発注点</th>
                                <th>在庫数</th>
                                <th>品番</th>
                                <th>型番</th>
                                <th>ピン<br>位置番号</th>
                                <th>ピン交換日<br>(出庫日)</th>
                                <th>基準<br>ショット数</th>
                                <th>ショット数</th>
                                <th>ピン<br>入出庫</th>
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <input type="hidden" name="event" value="<?=$event?>">
        <input type="hidden" name="xxxxx">
    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="js/jquery.blockUI.js"></script>
    <script>
        $(function(){
            // 画面読み込み時に実行
            getPinItemList();

            // 検索条件が変更された時に実行
            $('.filter-input').on('change', function() {
                getPinItemList();
            });

            // 検索ボタン
            $('#btnSearch').on('click', function() {
                getPinItemList();
            });

            // 新規登録ボタン
            $('#btnNew').on('click', function() {
                var leftPosition = (window.screen.width / 2) - (600 / 2);
                var topPosition = (window.screen.height / 2) - (400 / 2);
                window.open('pin_new.php', 'pinNew', 'width=600,height=400,left='+leftPosition+',top='+topPosition);
            });

            // 変更ボタン
            $('#btnUpdate').on('click', function() {
                var errmsg = "";

                var checkbox = false;
                $('#tbody input[name^="Checkbox"]').each(function(index, value) {
                    var pinIdx = value.name.replace('Checkbox', '').replace('[', '\\[').replace(']', '\\]');
                    if (value.checked == true) {
                        checkbox = true;
                        // 発注点の入力チェック
                        if ($(`#OdrQty${pinIdx}`).val() == "") {
                            $(`#OdrQty${pinIdx}`).focus();
                            errmsg += '発注点を入力してください。\n';
                            return false;
                        }
                        // 基準ショット数の入力チェック
                        if ($(`#StdQty${pinIdx}`).val() == "") {
                            $(`#StdQty${pinIdx}`).focus();
                            errmsg += '基準ショット数を入力してください。\n';
                            return false;
                        }
                    }
                });
                // チェックボックスにチェックがない場合はエラー
                if (checkbox == false) {
                    errmsg += '変更するピンのチェックボックスにチェックを入れてください。\n';
                }

                if (errmsg != "") {
                    alert(errmsg);
                    return false;
                } else {
                    document.frm1.event.value = 'update';
                    document.frm1.submit();
                }
            });

            // 削除ボタン
            $('#btnDelete').on('click', function() {
                var errmsg = "";

                var checkbox = false;
                $('#tbody input[name^="Checkbox"]').each(function(index, value) {
                    var pinIdx = value.name.replace('Checkbox', '').replace('[', '\\[').replace(']', '\\]');
                    if (value.checked == true) {
                        checkbox = true;
                        return true;
                    }
                });
                // チェックボックスにチェックがない場合はエラー
                if (checkbox == false) {
                    errmsg += '削除するピンのチェックボックスにチェックを入れてください。\n';
                }

                if (errmsg != "") {
                    alert(errmsg);
                    return false;
                } else {
                    document.frm1.event.value = 'delete';
                    document.frm1.submit();
                }
            });

            // 紐付ボタン
            $('#btnLink').on('click', function() {
                var leftPosition = (window.screen.width / 2) - (900 / 2);
                var topPosition = (window.screen.height / 2) - (700 / 2);
                window.open('pin_link.php', 'pinLink', 'width=900,height=700,left='+leftPosition+',top='+topPosition);
            });

            $('#tbody').on('click', 'a[id^=xxx]', function(event) {
                event.preventDefault();
                window.open('', 'new_window', 'width=600,height=600');
                document.frm1.xxxxx.value = this.id;
                document.frm1.method = 'POST';
                document.frm1.action = 'xxx.php';
                document.frm1.target = 'new_window';
                document.frm1.submit();
            });
        });

        // Ajaxの処理が全て終わってから実行される
        $(document).ajaxStop(function() {
            $.unblockUI();
        });

        // 一覧データを取得
        function getPinItemList() {
            $.blockUI();

            var PinName = $('#PinName').val();
            var ItemCd = $('#ItemCd').val();
            var MoldItemCd = $('#MoldItemCd').val();

            var StockOut = $('#chkStockOut').prop('checked');
            var DelFlg = $('#chkDelFlg').prop('checked');

            var tbody = $('#tbody');
            tbody.empty();

            $.ajax({
                type: 'POST',
                url: 'ajax_pin.php',
                data: {
                    target: 'PinItemList',
                    PIN_NAME: PinName,
                    ITEM_CD: ItemCd,
                    MOLD_ITEM_CD: MoldItemCd,
                    STOCK_OUT: StockOut,
                    DEL_FLG: DelFlg,
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $.each(data, function(index, value) {
                        var tbodyRow = '<tr class="text-center">';
                        if (value.PIN_INDEX == 0) {
                            if (value.DEL_FLG == '0') {
                                tbodyRow += `<td rowspan="${value.PIN_CNT}"><input type="checkbox" class="form-check-input" name="Checkbox[${index}]" id="Checkbox[${index}]"></td>`;
                                tbodyRow += `<td rowspan="${value.PIN_CNT}" class="text-nowrap" style="width:150px;">${value.PIN_NAME}</td>`;
                                tbodyRow += `<input type="hidden" name="PinNameVal[${index}]" value="${value.PIN_NAME}">`;
                            } else {
                                tbodyRow += `<td rowspan="${value.PIN_CNT}"></td>`;
                                tbodyRow += `<td rowspan="${value.PIN_CNT}" class="text-nowrap" style="width:150px; background-color:lightgray;">${value.PIN_NAME}</td>`;
                            }
                            tbodyRow += `<td rowspan="${value.PIN_CNT}" style="width:50px;">` + (value.SLOPE_PIN_FLG == 1 ? '✓':'') + `</td>`;
                            if (value.DEL_FLG == '0') {
                                tbodyRow += `<td rowspan="${value.PIN_CNT}" style="width:80px;"><input type="number" name="OdrQty[${index}]" id="OdrQty[${index}]" class="form-control form-control-sm text-center pe-0" value="${value.ODR_QTY}" min="0"></td>`;
                            } else {
                                tbodyRow += `<td rowspan="${value.PIN_CNT}" style="width:80px;">${value.ODR_QTY}</td>`;
                            }
                            if (parseInt(value.ODR_QTY) >= parseInt(value.STOCK_QTY) && value.DEL_FLG == '0') {
                                tbodyRow += `<td rowspan="${value.PIN_CNT}" style="width:80px; color:red; font-weight:bold;">${value.STOCK_QTY}</td>`;
                            } else {
                                tbodyRow += `<td rowspan="${value.PIN_CNT}" style="width:80px;">${value.STOCK_QTY}</td>`;
                            }
                        }
                        tbodyRow += `<td style="width:200px;">${value.ITEM_CD}</td>`;
                        tbodyRow += `<td style="width:80px;">${value.MOLD_ITEM_CD}</td>`;
                        tbodyRow += `<td style="width:100px;">${value.PIN_POSITION_NO}</td>`;
                        tbodyRow += `<td style="width:100px;"></td>`;
                        if (value.PIN_INDEX == 0) {
                            tbodyRow += `<td rowspan="${value.PIN_CNT}" style="width:100px;">`;
                            if (value.SLOPE_PIN_FLG == 0) {
                                if (value.DEL_FLG == '0') {
                                    tbodyRow += `<input type="number" name="StdQty[${index}]" id="StdQty[${index}]" value="${value.STD_QTY}" class="form-control form-control-sm text-center pe-0" min="0">`;
                                } else {
                                    tbodyRow += `${value.STD_QTY}`;
                                }
                            }
                            tbodyRow += `</td>`;
                        }
                        tbodyRow += `<td style="width:100px;"></td>`;
                        tbodyRow += `<td>
                                        <button type="button" class="btn btn-secondary btnInsert">登録</button>
                                        <button type="button" class="btn btn-secondary">一覧</button>
                                        <a href="#" id="xxx[${index}]">xxx</a>
                                     </td>`;
                        tbody.append(tbodyRow);
                    });
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    </script>
</body>
</html>