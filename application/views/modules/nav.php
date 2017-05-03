 <div class="container-flud nav">
            <ul>
                <li><a href="#">Đại sảnh</a></li>
                 <li><a href="<?php echo base_url('welcome/loadtintuc'); ?>">Tin tức</a></li>
                 <li><a href="<?php echo base_url('welcome/load_hotro'); ?>">Hỗ trợ</a></li>
            </ul>
                 <a href="#" id="tt_ten">
                 <?php
                  if (isset($_SESSION['ten'])&& $_SESSION['ten']!="") {
                    echo"Xin chào:" . $_SESSION['ten'];
                } else {
                    echo"Xin chào bạn";
                }
                     ?>
                 </a>
           
  </div>
  <div class="clearfix"></div>     