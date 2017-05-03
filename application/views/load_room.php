<?php
if (!isset($_SESSION['ten'])) {
    
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
    <?php echo $_SESSION['id_phong'];
    ?>
    <div class="loadroom">
        <div class="load-quan">
            <form method="post" action="<?php echo base_url('welcome/load_gameX'); ?>" class="load-chon-quan" >
                <p> Quân X </p>
                <?php
                if (isset($_POST['thamgia'])) {
                    echo $_SESSION['ten'];
                    $ten = $_SESSION['ten'];
                    $data2 = array(
                        "tennguoichoi" => $ten
                    );
                    $this->Model_dk->insert_room($data2);
                } else {
                    ?>
        <!--                <input type="hidden" class="token" value="O">-->
<!--                    <input type="hidden" value="<?php echo $_SESSION['id_phong'] ?>" />-->
                    <button type="submit"  name="thamgia"> Tham gia </button> 
                    <?php
                }
                ?>
            </form>
            <!--                        </div>
                                    <div class="load-quan1">-->
            <form method="post" action="<?php echo base_url('welcome/load_game'); ?>" class="load-chon-quan1">
                <p> Quân O </p>
                <?php
                if (isset($_POST['thamgia1'])) {
                    echo $_SESSION['ten'];
                    $ten = $_SESSION['ten'];
                    $data = array(
                        "tennguoichoi" => $ten
                    );
                    $this->Model_dk->insert_room($data);
                } else {
                    ?>
<!--                    <input type="hidden" value="<?php echo $_SESSION['id_phong'] ?>" />-->
                    <button type="submit" name="thamgia1"> Tham gia </button>
                    <?php
                }
                ?>
            </form>
        </div>
    </div>
</div>
