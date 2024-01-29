<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>datalist連携</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <form>
        <label for="inputA">A: </label>
        <input list="datalistA" id="inputA" name="inputA">
        <datalist id="datalistA">
            <option value="value1" label="ラベル-01"></option>
            <option value="value1" label="ラベル-0A"></option>
            <option value="value1" label="ラベル-0B"></option>
            <option value="value1" label="ラベル-0C"></option>
            <option value="value2" label="ラベル-02"></option>
            <option value="value3" label="ラベル-03"></option>
        </datalist>

        <label for="inputB">B: </label>
        <input type="text" name="inputB" id="inputB">

        <input type="text" id="my-input" list="data-list">
        <datalist id="data-list">
            <option value="John" data-id="1"></option>
            <option value="George" data-id="2"></option>
            <option value="John" data-id="3"></option>
            <option value="George" data-id="4"></option>
            <option value="John" data-id="5"></option>
        </datalist>
    </form>

    <script>
        $(function(){
            // Aの選択に応じてBの値を更新
            $('#inputA').on('input', function() {
                var selectedOption = $('#datalistA option[value="' + $(this).val() + '"]');
                $('#inputB').val(selectedOption.length ? selectedOption.attr('label') : '');

                var selectedValue = $(this).val();
                $('#inputA').val(selectedValue);
                var matchingOptions = $('#datalistA option[value="' + selectedValue + '"]');
                if (matchingOptions.length > 0) {
                    var selectedIndex = $('#datalistA option').index(matchingOptions.first());
                    console.log('選択されたオプションのインデックス: ' + selectedIndex);
                }
            });


            $("#data-list option").each(function(){
                var sameOpt = $(this).parent().find("[value='"+this.value+"']:gt(0)");
                sameOpt.val(function(i, val){
                    return val+'-'+(sameOpt.index(this)+2);
                });
            });
            $("#my-input").change(function(){
                var v = $("#data-list option[value='"+this.value+"']").attr('data-id');
                console.log(v);
            });

            $("#datalistA option").each(function(){
                var sameOpt = $(this).parent().find("[value='"+this.value+"']:gt(0)");
                sameOpt.val(function(i, val){
                    var spaceCount = sameOpt.index(this) + 1; // 重複した数に応じたスペースの数
                    return val + ' '.repeat(spaceCount);
                });
            });

        });
    </script>
</body>
</html>