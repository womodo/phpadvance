<?php






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
                            検索
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-around">
                                <div class="d-flex">
                                    <label class="col-form-label" for="PinName">ピン名(%)：</label>
                                    <input type="text" class="form-control text-center filter-text" style="width:200px;" id="PinName" name="PinName">
                                </div>
                                <div class="d-flex">
                                    <label class="col-form-label" for="ItemCd">品番(%)：</label>
                                    <input type="text" class="form-control text-center filter-text" style="width:200px;" id="ItemCd" name="ItemCd">
                                </div>
                                <div class="d-flex">
                                    <label  class="col-form-label"for="MoldItemCd">型番(%)：</label>
                                    <input type="text" class="form-control text-center filter-text" style="width:100px;" id="MoldItemCd" name="MoldItemCd">
                                </div>
                            </div>
                            <div>
                                ・削除のピンも表示する（削除フラグ）<br>
                                ・在庫数が発注点以下<br>
                                ・ショット数が基準ショット数以上<br>
                            </div>
                            <!-- <div class="row justify-content-center">
                                <label class="col-form-label col-2 text-end" for="PinName" style="width:90px;">ピン名(%)</label>
                                <div class="col-2" style="width:200px;">
                                    <input type="text" class="form-control text-center filter-text" id="PinName" name="PinName">
                                </div>
                                <label class="col-form-label col-2 text-end" for="ItemCd" style="width:90px;">品番(%)</label>
                                <div class="col-2" style="width:200px;">
                                    <input type="text" class="form-control text-center filter-text" id="ItemCd" name="ItemCd">
                                </div>
                                <label  class="col-form-label col-2 text-end"for="MoldItemCd" style="width:90px;">型番(%)</label>
                                <div class="col-2" style="width:100px;">
                                    <input type="text" class="form-control text-center filter-text" id="MoldItemCd" name="MoldItemCd">
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            処理
                        </div>
                        <div class="card-body text-center ps-1 pe-1">
                            <button type="button" class="btn btn-primary" id="btnSearch">検<br>索</button>
                            <button type="button" class="btn btn-success" id="btnNew" title="ピンを新規登録する画面を表示">新規<br>登録</button>
                            <button type="button" class="btn btn-warning" id="btnUpdate" title="一覧の中でチェックが入っているピンの発注点、基準ショット数を変更">変<br>更</button>
                            <button type="button" class="btn btn-danger">削<br>除</button>
                            <button type="button" class="btn btn-info" id="btnCsv">CSV<br>出力</button>
                            <button type="button" class="btn btn-outline-success" id="btnLink" title="品番＋型番へピンを紐付ける画面を表示">紐<br>付</button>
                            <button type="button" class="btn btn-dark" style="width:60px;" id="btnClose">閉じる</button>
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
                                <th><input type="checkbox" name="" id=""></th>
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

    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="js/jquery.blockUI.js"></script>
    <script>
        $(function(){
            // 画面読み込み時に実行
            getPinItemList();

            // 検索条件が変更された時に実行
            $('.filter-text').on('change', function() {
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

            // 紐付ボタン
            $('#btnLink').on('click', function() {
                var leftPosition = (window.screen.width / 2) - (900 / 2);
                var topPosition = (window.screen.height / 2) - (700 / 2);
                window.open('pin_link.php', 'pinLink', 'width=900,height=700,left='+leftPosition+',top='+topPosition);
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
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $.each(data, function(index, value) {
                        var tbodyRow = '<tr class="text-center">';
                        if (value.PIN_INDEX == 0) {
                            tbodyRow += `<th rowspan="${value.PIN_CNT}"><input type="checkbox" name="" id=""></th>`;
                            tbodyRow += `<td rowspan="${value.PIN_CNT}" style="width:150px;">${value.PIN_NAME}</td>`;
                            tbodyRow += `<td rowspan="${value.PIN_CNT}" style="width:50px;">` + (value.SLOPE_PIN_FLG == 1 ? '✓':'') + `</td>`;
                            tbodyRow += `<td rowspan="${value.PIN_CNT}" style="width:80px;"><input type="number" class="form-control form-control-sm" value="${value.ODR_QTY}" min="0" style="text-align:center; padding-right:0;"></td>`;
                            if (parseInt(value.ODR_QTY) >= parseInt(value.STOCK_QTY)) {
                                
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
                                tbodyRow += `<input type="number" value="${value.STD_QTY}" class="form-control form-control-sm" min="0" style="text-align:center; padding-right:0;">`;
                            }
                            tbodyRow += `</td>`;
                        }
                        tbodyRow += `<td style="width:100px;"></td>`;
                        tbodyRow += `<td>
                                        <button type="button" class="btn btn-secondary btn-sm">登録</button>
                                        <button type="button" class="btn btn-secondary btn-sm">一覧</button>
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