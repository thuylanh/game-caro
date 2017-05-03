<?php
if (isset($_SESSION['ten'])) {
    $ten = $_SESSION['ten'];
}
?>    
<!--<script>
function submitChat(){
//    if(form1.msg.value){
//        alert('Nhập tin nhắn!');
//        return ;
//    }
    var uname=form1._user.value;
    var msg = form1._msg.value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById('chatlogs').innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open('POST','welcome/load_chat.php?_user='.$uname.'_msg='.$msg,true);
    xmlhttp.send();
}
</script>-->
<div class="container-flud content">
    <div class="slibar">
        <div class="load-quan">
            <form method="post" action="#" class="load-chon-quan" >
                <p> Quân O </p>
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
                    <input type="hidden" class="room" value="<?php echo $_SESSION['id_phong'] ?>" />
                    <button type="submit"  name="thamgia"> Tham gia </button> 
                <?php } ?>
            </form>
            <!--                        </div>
                                    <div class="load-quan1">-->
            <form method="post" action="#" class="load-chon-quan1">
                <p> Quân X </p>
                <?php
                if (isset($_POST['thamgia1'])) {
                    echo $_SESSION['ten'];
                    $ten = $_SESSION['ten'];
                    $data = array("tennguoichoi" => $ten);
                    $this->Model_dk->insert_room($data);
                } else {
                    ?>
                    <input type="hidden" class="token" value="O">
                    <input type="hidden" class="room" value="<?php echo $_SESSION['id_phong'] ?>" />
                    <button type="submit" name="thamgia1"> Tham gia </button>
                    <?php
                }
                ?>
            </form>
        </div>
    </div>

    <div class="manchoi">
        <div class="man">
            <table>
                <?php
                for ($i = 0; $i < 10; $i++) {
                    echo "<tr>";
                    for ($j = 0; $j < 10; $j++) {
                        $a = base64_encode(intval($i . $j));
                        //$b=intval('$i.$j',base64_encode($i.$j));
                        $array = intval($i . $j);
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
<!--        <input type="hidden" class="token" value="O">-->
<!--        <input type="hidden" class="room" value="ISA">
        <input type="hidden" class="map" value="ISA">-->
        <script src="https://www.gstatic.com/firebasejs/3.9.0/firebase.js"></script>
        <script>//danh x,o

                    window.onload = function () {
                        init();
                    };
                    function init() {

                        this.map = [];
                        this.token = document.querySelector(".token").value;
                        this.room = document.querySelector(".room").value + "/";
                        this._end = document.querySelector(".room").value + "_end/";
                        this._matchstatus = document.querySelector(".room").value + "_matchstatus/";
                        this.config = {
                            apiKey: "AIzaSyCUcx1m1X-UVm5gIaDHlOtJeBIYqMe8NmA",
                            authDomain: "caro-449a7.firebaseapp.com",
                            databaseURL: "https://caro-449a7.firebaseio.com",
                            storageBucket: "caro-449a7.appspot.com"
                        };
                        firebase.initializeApp(this.config);

                        for (var i = 0; i < 100; i++) {
                            this.map.push({token: ""});
                        }

                        //contructor map
                        this.mapsRef = firebase.database().ref(this.room);
                        this.mapsRef.set(this.map);
                        this.mapsRef.on("value", function (snapshot) {
                            var arr = snapshot.val();
                            var index = 0;
                            document.querySelectorAll("button.caro").forEach(function (value) {
                                value.innerText = arr[index++].token;
                            });
                        }, function (error) {
                            console.log("Error: " + error.code);
                        });

                        // generate end status
                        this.matchRef = firebase.database().ref(this._matchstatus);
                        this.matchRef.set({
                            win: false,
                            turn: "X"
                        });
                        this.matchRef.on("value", function (snapshot) {
                            this.win = snapshot.val().win;
                            this.turn = snapshot.val().turn;
                        }, function (error) {
                            console.log("Error: " + error.code);
                        });

                        this._endsRef = firebase.database().ref(this._end);
                        this._endsRef.set({
                            "turnon": "X"
                        });
                        this._endsRef.on("value", function (snapshot) {
                            this._turnon = snapshot.val().turnon;
                        }, function (error) {
                            console.log("Error: " + error.code);
                        });

                    }

                    function end() {
                        this.matchRef.update({
                            "win": true
                        });

                    }

                    function changeTurn() {
                        if (this.token == "X") {
                            this._endsRef.update({
                                "turnon": "O"
                            });
                        } else
                            this._endsRef.update({
                                "turnon": "X"
                            });

                    }

                    function my(k) {
                        if (this.win == false) {
                            if (this.token == this._turnon) {
                                rawPoint(k);
                                changeTurn();
                            }

                        } else
                            end();
                    }

                    function rawPoint(k) {
                        this.point = firebase.database().ref(this.room + k);
                        point.update({
                            "token": this.token
                        });
                        result(k);
                    }

                    function result(index) {
                        this.x = parseInt(index / 10);
                        this.y = index % 10;
                        this.total = -1;
                        this.left = index - this.y;
                        this.right = (this.x + 1) * 10;

                        //check ngang
                        for (var i = index; i <= this.right; i++) {
                            var selector = "#" + btoa(i).replace("=", "").replace("=", "");
                            if (document.querySelector(selector) == null)
                                break;
                            if (document.querySelector(selector).innerHTML == this.token)
                                this.total++;
                            else
                                break;
                        }
                        for (var i = index; i >= this.left; i--) {
                            var selector = "#" + btoa(i).replace("=", "").replace("=", "");
                            if (document.querySelector(selector) == null)
                                break;
                            if (document.querySelector(selector).innerHTML == this.token)
                                this.total++;
                            else
                                break;
                        }
                        if (this.total >= 5) {
                            end();
                            alert("You win");
                            return true;
                        } else
                            this.total = -1;

                        //check doc
                        for (var i = this.x; i <= 9; i++) {
                            var point = parseInt(String(i) + String(this.y));
                            var selector = "#" + btoa(point).replace("=", "").replace("=", "");
                            if (document.querySelector(selector) == null)
                                break;
                            if (document.querySelector(selector).innerHTML == this.token)
                                this.total++;
                            else
                                break;
                        }
                        for (var i = this.x; i >= 0; i--) {
                            var point = parseInt(String(i) + String(this.y));
                            var selector = "#" + btoa(point).replace("=", "").replace("=", "");
                            if (document.querySelector(selector) == null)
                                break;
                            if (document.querySelector(selector).innerHTML == this.token)
                                this.total++;
                            else
                                break;
                        }

                        if (this.total >= 5) {
                            end();
                            alert("You win");
                            return true;
                        } else
                            this.total = -1;

                        //check cheo trai
                        var i = this.x;
                        var j = this.y;
                        while (true) {
                            var point = parseInt(String(i++) + String(j--));
                            var selector = "#" + btoa(point).replace("=", "").replace("=", "");
                            if (document.querySelector(selector) == null)
                                break;
                            if (document.querySelector(selector).innerHTML == this.token)
                                this.total++;
                            else
                                break;
                        }
                        var i = this.x;
                        var j = this.y;
                        while (true) {
                            var point = parseInt(String(i--) + String(j++));
                            var selector = "#" + btoa(point).replace("=", "").replace("=", "");
                            if (document.querySelector(selector) == null)
                                break;
                            if (document.querySelector(selector).innerHTML == this.token)
                                this.total++;
                            else
                                break;
                        }

                        if (this.total >= 5) {
                            end();
                            alert("You win");
                            return true;
                        } else
                            this.total = -1;

                        //check cheo phai
                        var i = this.x;
                        var j = this.y;
                        while (true) {
                            var point = parseInt(String(i++) + String(j++));
                            var selector = "#" + btoa(point).replace("=", "").replace("=", "");
                            if (document.querySelector(selector) == null)
                                break;
                            if (document.querySelector(selector).innerHTML == this.token)
                                this.total++;
                            else
                                break;
                        }
                        var i = this.x;
                        var j = this.y;
                        while (true) {
                            var point = parseInt(String(i--) + String(j--));

                            var selector = "#" + btoa(point).replace("=", "").replace("=", "");
                            if (document.querySelector(selector) == null)
                                break;
                            if (document.querySelector(selector).innerHTML == this.token)
                                this.total++;
                            else
                                break;
                        }

                        if (this.total >= 5) {
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
<!--            <form name="form1" action="<?php echo base_url('welcome/load_message'); ?>">
                <div id="chatlogs" style="width: 150px; height: 300px;">
                    LAODING ......
                </div>
            </form>
            <form action="<?php echo base_url('welcome/load_chat'); ?>">
                <div >
                    <?php echo $_SESSION['ten']; ?></b>
                    <input type="text" name="_msg" >
                    <a href="#" onclick="submitChat()">Send</a>
                </div>
            </form>-->
            <table width="130px" boder="1" align="center">
                <input type="hidden" class="room" value="<?php echo $_SESSION['id_phong'] ?>" />
                <tr>
                    <td>
                        <iframe src="<?php echo base_url('welcome/load_message'); ?>" id="ochat">
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
    </div>  
    <div class="clearfix"></div>  
</div>






