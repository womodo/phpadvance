<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datalist Ajax Example</title>
    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
    <script>
        $(document).ready(function(){

            // フォーカスが外れたらdatalistは空にする（表示がおかしくならないため）
            $('#myInput1').blur(function(){
                var datalist = $('#myDatalist1');
                datalist.empty();
            });

            // フォーカスされたらdatalistを作成する
            $('#myInput1').focus(function(){
                var val2 = $('#myInput2').val();

                // ajaxの場合（古い書き方）
                $.ajax({
                    type: 'POST',
                    url: 'ajax_datalist.php',
                    data: { inputVal : val2 },
                    dataType: 'json',
                    success: function(data){
                        var datalist = $('#myDatalist1');
                        $.each(data, function(index, value) {
                            datalist.append('<option value="' + value + '">' + value + '</option>');
                        });
                    },
                    error: function(error){
                        console.log(error);
                    }
                });

                // ajaxの場合（jQuery1.5以上）
                $.ajax({
                    type: 'POST',
                    url: 'ajax_datalist.php',
                    data: { inputVal : val2 },
                    dataType: 'json'
                }).done((data, textStatus, jqXHR) => {
                    var datalist = $('#myDatalist1');
                    $.each(data, function(index, value) {
                        datalist.append('<option value="' + value + '">' + value + '</option>');
                    });
                }).fail((jqXHR, textStatus, errorThrown) => {
                    console.log(errorThrown);
                });

                // Fetch APIの場合
                fetch('ajax_datalist.php',
                    {
                        method : 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ inputVal : val2 })
                    }
                )
                .then(response => response.json())
                .then(data => {
                    var datalist = $('#myDatalist1');
                    $.each(data, function(index, value) {
                        datalist.append('<option value="' + value + '">' + value + '</option>');
                    });
                })
                .catch(error => {
                    console.log({error});
                });
            });

        });
    </script>
    <form>
        <div>
            <input type="text" id="myInput1" list="myDatalist1" autocomplete="off">
            <datalist id="myDatalist1"></datalist>
        </div>
        <div>
            <input type="text" id="myInput2">
        </div>
    </form>
</body>
</html>