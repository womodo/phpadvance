<?php
if (isset($_POST["event"])) {
    $event = $_POST["event"];
    switch ($event) {
        case 'calc':
            $start_date = new DateTime($_POST['start_date']);
            $end_date = new DateTime($_POST['end_date']);

            $result = array();
            $last_date = clone $end_date;
            $last_date->setTime(23, 59, 59);
            for ($date = clone $start_date; $date <= $last_date; $date->modify('+1 day')) {
                if ($date == $start_date) {
                    if ($start_date->format('Y-m-d') == $end_date->format('Y-m-d')) {
                        $start = new DateTime($start_date->format('Y-m-d H:i:s'));
                        $end = new DateTime($end_date->format('Y-m-d H:i:s'));
                        $interval = $start->diff($end);
                        $diff = $interval->i + ($interval->h * 60) + ($interval->days * 24 * 60);
                        $result[] = [
                            'start' => $start_date->format('Y-m-d H:i:s'),
                            'end'   => $end_date->format('Y-m-d H:i:s'),
                            'diff'  => $diff
                        ];
                    } else {
                        $start = new DateTime($start_date->format('Y-m-d H:i'));
                        $end = new DateTime($date->format('Y-m-d 23:59:59'));
                        $end->modify('+1 second');  //日をまたいだ時のため+1秒している(次の日の0:00にしている)
                        $interval = $start->diff($end);
                        $diff = $interval->i + ($interval->h * 60) + ($interval->days * 24 * 60);
                        $result[] = [
                            'start' => $start_date->format('Y-m-d H:i:s'),
                            'end'   => $date->format('Y-m-d 23:59:59'),
                            'diff'  => $diff
                        ];
                    }
                } else if ($date->format('Y-m-d') == $end_date->format('Y-m-d')) {
                    $start = new DateTime($date->format('Y-m-d 00:00:00'));
                    $end = new DateTime($end_date->format('Y-m-d H:i:s'));
                    $interval = $start->diff($end);
                    $diff = $interval->i + ($interval->h * 60) + ($interval->days * 24 * 60);
                    $result[] = [
                        'start' => $date->format('Y-m-d 00:00:00'),
                        'end'   => $end_date->format('Y-m-d H:i:s'),
                        'diff'  => $diff
                    ];
                } else {
                    $start = new DateTime($date->format('Y-m-d 00:00:00'));
                    $end = new DateTime($date->format('Y-m-d 23:59:59'));
                    $end->modify('+1 second');
                    $interval = $start->diff($end);
                    $diff = $interval->i + ($interval->h * 60) + ($interval->days * 24 * 60);
                    $result[] = [
                        'start' => $date->format('Y-m-d 00:00:00'),
                        'end'   => $date->format('Y-m-d 23:59:59'),
                        'diff'  => $diff
                    ];
                }
            }
            echo json_encode($result);
            break;
    }
    exit;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row justify-content-start">
            <div class="col-4">
                <form name="frm1" id="contact" method="post">
                    <div>
                        <label for="start_date">開始日時:</label>
                        <input type="datetime-local" id="start_date" name="start_date">
                    </div>
                    <div>
                        <label for="end_date">終了日時:</label>
                        <input type="datetime-local" id="end_date" name="end_date">
                    </div>
                    <div>
                        <label for="diff_minutes">差（分）:</label>
                        <input type="text" name="diff_minutes" id="diff_minutes">
                    </div>
                    <input type="button" name="btnExec" id="btnExec" value="実行">
                    <input type="hidden" name="event">
                </form>
            </div>
            <div class="col-8">
                <table class="table table-bordered table-hover table-sm" id="table1" style="display: none;">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">start</th>
                            <th scope="col">end</th>
                            <th scope="col">diff(分)</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="http://malsup.github.io/jquery.blockUI.js"></script>
    <script>
        window.addEventListener('load', function(){
            var now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            now.setMilliseconds(null);
            now.setSeconds(null);
            document.getElementById('start_date').value = now.toISOString().slice(0, -1);
        });

        $(function() {
            // 終了日時を変更した場合
            $('#end_date').on('change', function() {
                var end_date = $(this).val();
                var start_date = $('#start_date').val();

                // 値が存在する場合のみ差を計算
                if (start_date && end_date) {
                    var startDatetime = new Date(start_date);
                    var endDatetime = new Date(end_date);

                    var timeDiff = (endDatetime - startDatetime) / (1000 * 60);

                    $('#diff_minutes').val(timeDiff);
                }
            });

            // 実行ボタンを押した場合
            $('#btnExec').on('click', function() {
                if ($('#end_date').val() == '') {
                    alert('終了日時が入力されていません。');
                    return;
                }
                if ($('#start_date').val() > $('#end_date').val()) {
                    alert('終了日時が開始日より前になっています。');
                    return;
                }

                document.frm1.event.value = 'calc';

                $.blockUI();
                $.ajax({
                    url: 'datetime_test.php',
                    type: 'POST',
                    data: $(document.frm1).serialize(),
                    dataType: 'json',
                    success: function(result) {
                        $('#table1').css('display', 'table');
                        $('#table1 > tbody').empty();
                        $.each(result, function(index, value) {
                            var newRow = $('<tr>');
                            newRow.append('<td>' + value['start'] + '</td>');
                            newRow.append('<td>' + value['end'] + '</td>');
                            newRow.append('<td>' + value['diff'] + '</td>');
                            $('#table1 tbody').append(newRow);
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                }).always(function(){
                    $.unblockUI();
                    document.frm1.event.value = '';
                });
            });
        });
    </script>
</body>
</html>