<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP advance CRUD</title>

    <!-- bootstrap css link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- link css file -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1 class="bg-dark text-light text-center py-2">PHP advance CRUD</h1>

    <div class="container">    
        <div class="displaymessage text-center bg-dark text-light mb-3"></div>

        <!-- form modal -->
        <?php include 'form.php'; ?>
        <?php include 'profile.php'; ?>

        <!-- input search and button section -->
        <div class="row mb-3">
            <div class="col-10">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-dark"><i class="fa fa-search text-light"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search user..." id="searchinput">
                </div>
            </div>
            <div class="col-2">
                <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#usermodal" id="adduserbtn">
                    Add new User
                </button>
            </div>
        </div>

        <!-- table -->
        <?php require_once 'tableData.php'; ?>

        <!-- pagination -->
        <nav aria-label="Page navigation example" id="pagination">
        </nav>

        <input type="hidden" name="currentpage" id="currentpage" value="1">
    </div>

    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- bootstrap popper and js link -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    <!-- js file -->
    <script src="js/script.js"></script>
</body>
</html>