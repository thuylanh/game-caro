<?php
if (isset($_SESSION['ten'])) {
    $ten = $_SESSION['ten'];
}
?>    
<div class="container-flud content">
    <div class="slibar">
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
                        <input type="hidden" class="token" value="X">
                    <input type="hidden" value="<?php echo $_SESSION['id_phong'] ?>" />
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
                 <input type="hidden" class="token" value="O">
                    <input type="hidden" value="<?php echo $_SESSION['id_phong'] ?>" />
                    <button type="submit" name="thamgia1"> Tham gia </button>
                    <?php
                }
                ?>
            </form>
        </div>
<!--        <div class="slibar-box">
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
        </div>-->
    </div>
    <div class="manchoi">
        <div class="man">
            <table>
                <?php
                for ($i = 0; $i < 10; $i++) {
                    echo "<tr>";
                    for ($j = 0; $j < 10; $j++) {
                        $a = base64_encode(intval($i.$j));
                        //$a = base64_encode($i . $j);
                        $array=intval($i.$j);
                        $a = str_replace('=', '', $a);
                        ?>
                        <td><button id="<?= $a; ?>" data-x="<?= $i; ?>" data-y="<?= $j; ?>" class="caro" onclick="my('<?= $array ?>')"></button></td>
                        <?php
                    }
                    echo "</tr>";
                }
                ?> 
            </table>
        </div>
<!--        <input type="hidden" class="token" value="X">-->
        <input type="hidden" class="room" value="ISA">
        <input type="hidden" class="map" value="ISA">
        <script src="https://www.gstatic.com/firebasejs/3.9.0/firebase.js"></script>
        <script>//danh x,o
        
             window.onload = function() {
              init();
            };
            function init() {

                this.map = [];
                this.token = document.querySelector(".token").value;
                this.room = document.querySelector(".room").value + "/";
                this._matchstatus = document.querySelector(".room").value + "_matchstatus/";
                this.config = {
                    apiKey: "AIzaSyCUcx1m1X-UVm5gIaDHlOtJeBIYqMe8NmA",
                    authDomain: "caro-449a7.firebaseapp.com",
                    databaseURL: "https://caro-449a7.firebaseio.com",
                    storageBucket: "caro-449a7.appspot.com"
                };
                firebase.initializeApp(this.config);

                for(var i=0;i<100;i++){
                    this.map.push({token:""});
                }

                //contructor map
                this.mapsRef = firebase.database().ref(this.room);
                this.mapsRef.set(this.map);
                this.mapsRef.on("value", function(snapshot) {
                    var arr = snapshot.val();
                    var index = 0;
                    document.querySelectorAll("button.caro").forEach(function(value){
                        value.innerText = arr[index++].token;
                    });
                }, function (error) {
                   console.log("Error: " + error.code);
                });
                
                // generate end status
                this.matchRef = firebase.database().ref(this._matchstatus);
                this.matchRef.set({
                    "win":false,
                    "first": "X",
                    "turn": "X"
                });
                this.matchRef.on("value", function(snapshot) {
                   this.win = snapshot.val().win;
                   this.turn = snapshot.val().turn;
                }, function (error) {
                   console.log("Error: " + error.code);
                });

            }

            function end() {
                this.matchRef.update({
                   "win": true
                });

            }

            function change() {
                if(this.token=="X")
                    this.change="O";
                else
                    this.token = "X";
                this.matchRef.update({
                   "turn": this.change
                });

            }

            function my(k) {
                if(this.win==false && this.turn==this.token) {
                    rawPoint(k);
                    change();
                } else
                    end();
            }

            function rawPoint(k) {
                this.point = firebase.database().ref(this.room+k);
                point.update({
                   "token": this.token
                });
                result(k);
            }

            function result(index) {
                this.x = parseInt(index/10);
                this.y = index%10;
                this.total = -1;
                this.left = index - this.y;
                this.right = (this.x + 1)*10; 

                //check ngang
                for(var i=index;i<=this.right;i++) {
                    var selector = "#"+btoa(i).replace("=","").replace("=","");
                    if(document.querySelector(selector)==null)
                        break;
                    if(document.querySelector(selector).innerHTML==this.token)
                        this.total++;
                    else
                        break;
                }
                for(var i=index;i>=this.left;i--) {
                    var selector = "#"+btoa(i).replace("=","").replace("=","");
                    if(document.querySelector(selector)==null)
                        break;
                    if(document.querySelector(selector).innerHTML==this.token)
                        this.total++;
                    else
                        break;
                }
                if(this.total>=5) {
                    end();
                    alert("You win");
                    return true;
                } else
                    this.total = -1;

                //check doc
                for(var i=this.x;i<=9;i++) {
                    var point = parseInt(String(i)+String(this.y));
                    var selector = "#"+btoa(point).replace("=","").replace("=","");
                    if(document.querySelector(selector)==null)
                        break;
                    if(document.querySelector(selector).innerHTML==this.token)
                        this.total++;
                    else
                        break;
                }
                for(var i=this.x;i>=0;i--) {
                    var point = parseInt(String(i)+String(this.y));
                    var selector = "#"+btoa(point).replace("=","").replace("=","");
                    if(document.querySelector(selector)==null)
                        break;
                    if(document.querySelector(selector).innerHTML==this.token)
                        this.total++;
                    else
                        break;
                }
                
               if(this.total>=5) {
                    end();
                    alert("You win");
                    return true;
                } else
                    this.total = -1;

                //check cheo trai
                var i=this.x;
                var j=this.y;
                while(true) {
                    var point = parseInt(String(i++)+String(j--));
                    var selector = "#"+btoa(point).replace("=","").replace("=","");
                    if(document.querySelector(selector)==null)
                        break;
                    if(document.querySelector(selector).innerHTML==this.token)
                        this.total++;
                    else
                        break;
                }
                var i=this.x;
                var j=this.y;
                while(true) {
                    var point = parseInt(String(i--)+String(j++));
                    var selector = "#"+btoa(point).replace("=","").replace("=","");
                    if(document.querySelector(selector)==null)
                        break;
                    if(document.querySelector(selector).innerHTML==this.token)
                        this.total++;
                    else
                        break;
                }

                if(this.total>=5) {
                    end();
                    alert("You win");
                    return true;
                } else
                    this.total = -1;

                //check cheo phai
                var i=this.x;
                var j=this.y;
                while(true) {
                    var point = parseInt(String(i++)+String(j++));
                    var selector = "#"+btoa(point).replace("=","").replace("=","");
                    if(document.querySelector(selector)==null)
                        break;
                    if(document.querySelector(selector).innerHTML==this.token)
                        this.total++;
                    else
                        break;
                }
                var i=this.x;
                var j=this.y;
                while(true) {
                    var point = parseInt(String(i--)+String(j--));

                    var selector = "#"+btoa(point).replace("=","").replace("=","");
                    if(document.querySelector(selector)==null)
                        break;
                    if(document.querySelector(selector).innerHTML==this.token)
                        this.total++;
                    else
                        break;
                }

                if(this.total>=5) {
                    end();
                    alert("You win");
                    return true;
                } else
                    this.total = -1;
            }

        </script>
        
        <div class="col-sm-5">
            <form class="form-horizontal" >
                <div class="form-group">
                    <label class="col-sm-6 control-label"> Thời gian: </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" disabled id="time">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label"> Lượt chơi: </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" disabled id="turn" value="Người chơi 1">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label"> Tổng thời gian: </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" disabled id="all" value="">
                    </div>
                </div>
            </form>
        </div>
        <div class="chatbox">
            <table width="130px" boder="1" align="center">
                <tr>
                    <td>
                        <iframe src="<?php echo base_url('welcome/load_message'); ?>" width="140px" id="ochat">
                        </iframe> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <form action="<?php echo base_url('welcome/load_chat'); ?>" method="post">
                            <b><?php echo $_SESSION['ten']; ?></b>
                            <input type="text" name="_message" >
                            <input type="submit" name="submit" value="Send">
                        </form>
                    </td>
                </tr>
            </table>
        </div>

<!--        <script>
            var time = 0;
            time_all = 0;
            turn = 0;
            setInterval(function () {
                document.getElementById("time").value = time;
                document.getElementById("all").value = time_all;
                if (time == 30) {
                    time = 0;
                    alert("Mất lượt");
                    if (turn == 0) {
                        document.getElementById("turn").value = "Người chơi 2";
                        turn = 1;
                    } else {
                        document.getElementById("turn").value = "Người chơi 1";
                        turn = 0;
                    }

                }
                time += 1;
                time_all += 1;
            }
            , 1000);
        </script>-->

    </div>  
    <div class="clearfix"></div>  
</div>







