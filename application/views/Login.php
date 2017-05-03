<?php
if (isset($_POST['login'])) {
    $ten = $_POST['ten'];
    $_SESSION['ten'] = $ten;
}
?>

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
                <div class="formdn">
                 
                    <div class="form">
                        <form method="post" action="<?php echo base_url('welcome/check_dn'); ?>">
                            <h3>Đăng nhập</h3>
                            <label>Tên:</label><input type="text" name="ten" value="<?php echo set_value('ten', ''); ?>" autocomplete="on"/></br>
                            <label>Mật khẩu:</label><input type="password" name="pass" value="<?php echo set_value('pass', ''); ?>" autocomplete="off"/></br>
                            <button type="submit" id="dn" name="login">Đăng nhập </button>
                            <button type="submit" name="dk">Đăng ký </button>
                            <?php echo validation_errors(); ?>
                        </form>
<!--                        <p style="text-align: left;color: white;"><?= !empty(form_error('ten')) ? " + " . form_error('ten') . " ." : "" ?></p>
                        <p style="text-align: left;color: white;"><?= !empty(form_error('pass')) ? " + " . form_error('pass') . " ." : "" ?></p>-->
                    </div>
                </div>
            <div class="clearfix"></div>
         </div>
                  
<!--        <script>
   var url="index.php/Welcome/check_login";
   $("#update").load(url);
   </script>-->