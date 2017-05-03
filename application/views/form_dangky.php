<html>
    <head>
        <title>CARO</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="tk/css/bootstrap.min.css">
        <link rel="stylesheet" href="tk/css/style.css">
        <script  type="text/javascript" src="tk/jquery.min.js"></script>
        <script  type="text/javascript" src="tk/js/bootstrap.min.js"></script>

    </head>
    <body>
        <div class="container-flud content">
            <div class="slibar">
                <div class="slibar-box">
                    <div class="box"  id="anh1">
                        <a href="#" id="anh1"></a>
                    </div>
                    <div class="box">
                        <a href="#" id="anh2"></a>
                    </div>
                    <div class="box">
                        <a href="#" id="anh3"></a>
                    </div>
                    <div class="box">
                        <a href="#" id="anh4"></a>
                    </div>
                    <div class="box">
                        <a href="#" id="anh5"></a>
                    </div>
                </div>
            </div>
            <div class="formdk">
                <div class="form">
                    <form method="post" action="<?php echo base_url('welcome/check_dangky'); ?>">
                        <h3> Đăng ký thành viên:</h3>
                        <label>Tên:</label><input type="text" name="ten"/></br>
                        <label>Email:</label> <input type="text" name="email"/><br>
                        <label>Mật khẩu:</label><input type="password" name="pass"/><br>

                        <button type="submit" name="dangky" id="dk"> Đăng ký </button>
                        <button type="submit" name="out" >Thoát </button>
                        <?php //echo validation_errors(); ?>
                    </form>
                    <p style="text-align: left;color: white;"><?= !empty(form_error('ten')) ? " + " . form_error('ten') . " ." : "" ?></p>
                    <p style="text-align: left;color: white;"><?= !empty(form_error('pass')) ? " + " . form_error('pass') . " ." : "" ?></p>
                    <p style="text-align: left;color: white;"><?= !empty(form_error('email')) ? " + " . form_error('email') . " ." : "" ?></p>    
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

<!--        <script>
var url="index.php/Welcome/check_login";
$("#update").load(url);
</script>-->
    </body>
</html>
