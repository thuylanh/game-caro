<script type="text/javascript">
    $(document).ready(function () {
       $("button").click(function(){
           var a=$(this).attr('id');
          $.get("<?php echo base_url('welcome/load_ingame'); ?>",{'id':a},function(data){
             if(data=="ok"){
                window.location="http://localhost/welcome/load_game";}
          });
       });
    });
</script>
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

<div class="dsphong">
    <p id="te"></p>
    <?php
    foreach ($data as $e) {
        ?>
        <div class="box">
            <p><?php echo $e['ten_phong']; ?></p>
            <p1>Số người:<?php echo $e['sl_nguoi']; ?></p1>                           
            <button type="button" name="bt_phong" class="phong" id="<?php echo $e['id']; ?>"value="<?php echo $e['sl_nguoi']; ?>">vào phòng</button>
        </div>

    <?php } ?>


</div>
</div>