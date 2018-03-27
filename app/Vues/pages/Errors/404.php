<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=$json->error404->description ?>">
    <meta name="author" content="EdFramework">
    <link rel="icon" href="<?=RES?>/images/logo.png">

    <title> <?=$json->error404->title ?> </title>

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="<?=RES?>/assets/css/bootstrap.min.css">

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="<?=RES?>/assets/css/bootstrap-extend.css">

    <link rel="stylesheet" href="<?=RES?>/assets/css/font-awesome.min.css">


</head>
<body>
    <div>
        <div class="container text-center">

            <h2 style="font-size: 180px;font-weight: 900;color: #48b0f7;"> 404 </h2>

            <h3><i class="fa fa-warning" style="color: #48b0f7;"></i> <?=$json->error404->notFound ?> !</h3>

            <p>
                <?=$json->error404->errorMsg ?>
            </p>
            <div class="text-center">
                <a href="<?=WROOT?>Generator/GController/gen" class="btn btn-info col-3"><?=$json->error404->returnBtn ?></a>
            </div>
        </div>
    </div>


<!-- jQuery 3 -->
<script src="<?=RES?>/assets/js/jquery.min.js"></script>

<!-- popper -->
<script src="<?=RES?>/assets/js/popper.min.js"></script>

<!-- Bootstrap 4.0-->
<script src="<?=RES?>/assets/js/bootstrap.min.js"></script>


</body>

</html>
