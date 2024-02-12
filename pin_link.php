<?php
$dbname = "phpadvance";
$servername = "localhost";
$username = "root";
$password = "zaq12wsx";
$dsn = "mysql:dbname=".$dbname.";host=".$servername;
$dbh = new PDO($dsn, $username, $password);

$event = htmlspecialchars($_POST["event"]);
$hdNum = htmlspecialchars($_POST["hdNum"]);

$ItemCd = htmlspecialchars($_POST["ItemCd"]);
$MoldItemCd = htmlspecialchars($_POST["MoldItemCd"]);
$PinPositionNo = $_POST["PinPositionNo"];
$PinName = $_POST["PinName"];

if ($event == "update") {
    // ピン位置を洗い替え（削除→追加）
    $dbh->beginTransaction();
    
    $sql = "DELETE FROM m_pin_link ";
    $sql.= "WHERE ITEM_CD = '$ItemCd' AND MOLD_ITEM_CD = '$MoldItemCd' ";
    $dbh->exec($sql);

    $sql = "SELECT DISTINCT PIN_ID,PIN_NAME FROM m_pin ";
    $sql.= "WHERE 0 = 0 ";
    $sql.= "ORDER BY PIN_ID ";
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $PinNameList = [];
    foreach ($result as $rows) {
        foreach ($rows as $key => $value) {
            if ($value == null) {
                $value = "";
            }
            $row[$key] = $value;
        }
        $PinNameList[] = $row;
    }

    foreach ($PinPositionNo as $key => $PinPositionNoVal) {
        $PinNameVal = $PinName[$key];
        $PinId = 0;
        foreach ($PinNameList as $row) {
            if ($PinNameVal == $row["PIN_NAME"]) {
                $PinId = $row["PIN_ID"];
                break;
            }
        }

        $sql = "INSERT INTO m_pin_link ";
        $sql.= "(ITEM_CD,MOLD_ITEM_CD,PIN_POSITION_NO,PIN_ID) ";
        $sql.= "VALUES ('$ItemCd', '$MoldItemCd', '$PinPositionNoVal', '$PinId') ";
        $dbh->exec($sql);
    }
    $dbh->commit();
    $flg = "upd";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ピン紐付け</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <form method="post" name="frm1" onsubmit="return false;">
        <div class="container-fluid mt-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            「品番＋型番＋ピン位置番号」と「ピン」の紐付け
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <label for="ItemCd" class="col-form-label col-2">品番</label>
                                <div class="col-6">
                                    <input type="text" name="ItemCd" id="ItemCd" list="ItemCdList" class="form-control" value="<?=$ItemCd?>">
                                    <datalist id="ItemCdList"></datalist>
                                </div>
                                <div class="col-4 text-end">
                                    <button type="button" class="btn btn-primary" style="width:120px;" id="btnUpdate">更新</button>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="MoldItemCd" class="col-form-label col-2">型番</label>
                                <div class="col-6">
                                    <input type="hidden" name="MoldItemCdVal" id="MoldItemCdVal" value="<?=$MoldItemCd?>">
                                    <select name="MoldItemCd" id="MoldItemCd" class="form-select" disabled></select>
                                </div>
                                <div class="col-4 text-end">
                                    <button type="button" class="btn btn-dark" style="width:120px;" id="btnClose">閉じる</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8 text-end">
                                    <!-- ピン紐付け一覧 -->
                                    <button type="button" class="btn btn-secondary mb-1" style="width:120px;" id="btnAdd">ピン位置追加</button>
                                    <table class="table table-bordered table-sm align-middle">
                                        <thead class="table-dark">
                                            <tr class="text-center align-middle">
                                                <th style="width:150px;">ピン位置番号</th>
                                                <th>ピン名</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody"></tbody>
                                    </table>
                                </div>
                                <div class="col-4">
                                    <!-- 図面 -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <datalist id="PinNameList"></datalist>
        <input type="hidden" name="event" value="<?=$event?>">
        <input type="hidden" name="hdNum" id="hdNum">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(function(){
            // 画面読み込み時に実行：ピン名
            $.ajax({
                type: 'POST',
                url: 'ajax_pin.php',
                data: {
                    target: 'PinName',
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $.each(data, function(index, value) {
                        $('#PinNameList').append(`<option value="${value.PIN_NAME}"></option>`);
                    });
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
            // 画面読み込み時に実行：品番
            $.ajax({
                type: 'POST',
                url: 'ajax_pin.php',
                data: {
                    target: 'ItemCd',
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $.each(data, function(index, value) {
                        $('#ItemCdList').append(`<option value="${value.ITEM_CD}">${value.ITEM_CD}</option>`);
                    });
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

            // 更新ボタン
            $('#btnUpdate').on('click', function() {
                // 入力チェック

                document.frm1.event.value = "update";
                document.frm1.submit();
            });

            // 閉じるボタン
            $('#btnClose').on('click', function() {
                window.close();
            });

            // ピン位置追加ボタン
            $('#btnAdd').on('click', function() {
                var tbody = $('#tbody');
                var index = $('#hdNum').val();
                if (index == "") {
                    index = 0;
                }
                tbody.append(`<tr class="text-center">
                                <td><input type="number" class="form-control form-control-sm text-center" name="PinPositionNo[${index}]"></td>
                                <td><input type="text" class="form-control form-control-sm text-center" list="PinNameList" name="PinName[${index}]"></td>
                                <td><button type="button" class="btn btn-danger btn-sm btnRemove">削除</button></td>
                              </tr>`);
                $('#hdNum').val(parseInt(index) + 1);
            });

            // 行削除ボタン
            $('#tbody').on('click', '.btnRemove', function() {
                $(this).closest('tr').remove();
            });

            // 品番変更時
            $('#ItemCd').on('change', function() {
                var ItemCd = $('#ItemCd').val();

                var tbody = $('#tbody');
                tbody.empty();

                if (ItemCd == "") {
                    $('#MoldItemCd').prop('disabled', true);
                    $('#MoldItemCd').val('');

                } else {
                    // 型番
                    $('#MoldItemCd').prop('disabled', false);
                    $('#MoldItemCd').val('');
                    $('#MoldItemCd').empty();

                    $.ajax({
                        type: 'POST',
                        url: 'ajax_pin.php',
                        data: {
                            target: 'MoldItemCd',
                            ITEM_CD: ItemCd,
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            var MoldItemCdVal = $('#MoldItemCdVal').val();
                            $('#MoldItemCd').append(`<option value=""></option>`);
                            $.each(data, function(index, value) {
                                if (value.MOLD_ITEM_CD == MoldItemCdVal) {
                                    $('#MoldItemCd').append(`<option value="${value.MOLD_ITEM_CD}" selected>${value.MOLD_ITEM_CD}</option>`);
                                } else {
                                    $('#MoldItemCd').append(`<option value="${value.MOLD_ITEM_CD}">${value.MOLD_ITEM_CD}</option>`);
                                }
                            });
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });

            // 型番変更時
            $('#MoldItemCd').on('change', function() {
                var ItemCd = $('#ItemCd').val();
                var MoldItemCd = $('#MoldItemCd').val();
                
                var tbody = $('#tbody');
                tbody.empty();

                if (ItemCd != "" && MoldItemCd != "") {
                    $.ajax({
                        type: 'POST',
                        url: 'ajax_pin.php',
                        data: {
                            target: 'PinLinkList',
                            ITEM_CD: ItemCd,
                            MOLD_ITEM_CD: MoldItemCd,
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            $.each(data, function(index, value) {
                                var tbodyRow = `<tr class="text-center">`;
                                tbodyRow += `<td><input type="number" class="form-control form-control-sm text-center" name="PinPositionNo[${index}]" value="${value.PIN_POSITION_NO}"></td>`;
                                tbodyRow += `<td><input type="text" class="form-control form-control-sm text-center" name="PinName[${index}]" value="${value.PIN_NAME}" list="PinNameList"></td>`;
                                tbodyRow += `<td><span id="mySpan[${index}]">xxx${index}</span><button type="button" class="btn btn-info btn-sm btnXXX" name="btnXXX[${index}]">テスト</button></td>`;
                                tbodyRow += `<td><button type="button" class="btn btn-danger btn-sm btnRemove">削除</button></td>`;
                                tbodyRow += `</tr>`;
                                tbody.append(tbodyRow);
                                $('#hdNum').val(index + 1);
                            });
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });

            $('#tbody').on('click', '.btnXXX', function() {
                console.log($(this).attr('name'));
                var name = $(this).attr('name');
                var index = name.replace('btnXXX','');
                console.log(index);
                // var mySapn = '#mySpan' + index.replace(/\[/g, '\\[').replace(/\]/g, '\\]');
                var mySapn = '#mySpan' + index.replace('[', '\\[').replace(']', '\\]');
                console.log($(mySapn).text());
                console.log(mySapn);
                $(mySapn).text(Date.now());
                // console.log($('#mySpan[0]').text());
                // console.log($('#mySpan\\[0\\]').text());
                // $('#mySpan\\[0\\]').text('xxx');
            });
        });
    </script>

    <script>
        // 処理終了時
        var flg = '<?php echo($flg)?>';
        if (flg == 'upd') {
            alert('更新しました。');
            window.close();
            // 呼び出し元の関数(getPinItemList)を呼び出す
            window.opener.getPinItemList();
        }
    </script>
</body>
</html>