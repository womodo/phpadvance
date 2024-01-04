<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax Insert</title>
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        html,body{
            height: 100%;
        }
        .loader{
            display: none;
        }
    </style>
</head>
<body>
    <?php
        $conn = new mysqli("localhost","root","zaq12wsx","test");
        $sql = "SELECT * FROM students ORDER BY id DESC";
        $result = $conn->query($sql);
    ?>
    
    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col-6 mx-auto jumbotron">
                <form method="POST">
                    <div class="form-group">
                        <label>Name :</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email :</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <button class="btn btn-info">Submit</button>

                    <div class="loader">
                        <img src="abc.gif" alt="" style="width: 50px; height: 50px;">
                    </div>
                </form>
                <br>
                <table class="table-bordered table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_object()) { ?>
                            <tr>
                                <td><?php echo $row->id; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->email; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    <script>
        $(function(){
            $("form").submit(function(e){
                e.preventDefault();

                $.ajax({
                    url : "insert.php",
                    method : "POST",
                    data : $("form").serializeArray(),
                    dataType : "json",
                    beforeSend:function() {
                        $('.loader').show();
                    },
                    success:function(data) {
                        txt = '<tr><td>' + data.id + '</td>';
                        txt+= '<td>' + data.name + '</td>';
                        txt+= '<td>' + data.email + '</td>';
                        $('tbody').prepend(txt);
                        $('.loader').hide();
                    }
                });
            });
        });
    </script>
</body>
</html>