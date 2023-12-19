<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>連動するSelect要素</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(function() {
            $('select[id^=select1]').on('change', function() {
                var select1 = $(this).val();
                var index = $(this).attr('id').replace('select1', '').replace('[', '').replace(']', '');
                var select2s = $('select[id^=select2]');
                $.each(select2s, function(idx, el) {
                    if (idx == index) {
                        setOptions(index, getOptions(select1, getOtherSelects(index)));
                    } else {
                        var select2 = document.getElementById(`select2[${idx}]`).value;
                        var options = getOptions(document.getElementById(`select1[${idx}]`).value, getOtherSelects(idx));
                        if (select2 != "") {
                            options.push(select2);
                            options.sort();
                        }
                        setOptions(idx, options, select2);
                    }
                });
            });

            $('select[id^=select2]').on('change', function() {
                var index = $(this).attr('id').replace('select2', '').replace('[', '').replace(']', '');
                var select2s = $('select[id^=select2]');
                $.each(select2s, function(idx, el) {
                    if (idx != index) {
                        var select1 = document.getElementById(`select1[${idx}]`).value;
                        var select2 = document.getElementById(`select2[${idx}]`).value;
                        var options = getOptions(select1, getOtherSelects(idx));
                        if (select2 != "") {
                            options.push(select2);
                            options.sort();
                        }
                        setOptions(idx, options, select2);
                    }
                });
            });
        });

        function setOptions(index, options, selectedValue) {
            var select2 = document.getElementById(`select2[${index}]`);
            $(select2).children().remove();
            $(select2).append('<option value=""></option>');
            $.each(options, function(idx, value) {
                if (value == selectedValue) {
                    $(select2).append('<option value="'+value+'" selected>'+value+'</option>');
                } else {
                    $(select2).append('<option value="'+value+'">'+value+'</option>');
                }
            });
        }

        function getOtherSelects(index) {
            var select1 = document.getElementById(`select1[${index}]`).value;
            var select1s = $('select[id^=select1]');
            var select2s = $('select[id^=select2]');
            var otherSelects = [];
            $.each(select1s, function(idx1, el1) {
                if (el1.value == select1) {
                    $.each(select2s, function(idx2, el2) {
                        if (idx1 == idx2 && el2.value != "") {
                            otherSelects.push(el2.value);
                        }
                    });
                }
            });
            return otherSelects;
        }

        function getOptions(select1, otherSelects) {
            var items = [];
            switch (select1) {
                case 'option1':
                    items = ['11','12','13','14','15'];
                    break;
                case 'option2':
                    items = ['21','22','23','24','25'];
                    break;
                case 'option3':
                    items = ['31','32','33','34','35'];
                    break;
            }

            if (otherSelects) {
                var result = items.filter(function(item) {
                    return !otherSelects.includes(item);
                });
                return result;
            } else {
                return items;
            }
        }
    </script>
</head>

<body>

    <label for="select1[0]">select1[0]:</label>
    <select id="select1[0]">
        <option value=""></option>
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
    </select>
    <label for="select2[0]">select2[0]:</label>
    <select id="select2[0]"></select>

    <br>

    <label for="select1[1]">select1[1]:</label>
    <select id="select1[1]">
        <option value=""></option>
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
    </select>
    <label for="select2[1]">select2[1]:</label>
    <select id="select2[1]"></select>

<br>

<label for="select1[2]">select1[2]:</label>
<select id="select1[2]">
    <option value=""></option>
    <option value="option1">Option 1</option>
    <option value="option2">Option 2</option>
    <option value="option3">Option 3</option>
</select>
<label for="select2[2]">select2[2]:</label>
<select id="select2[2]"></select>

</body>

</html>