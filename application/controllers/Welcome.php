<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
        $this->load->helper('url');
        $this->load->helper("form");
        $this->load->library("form_validation");
//         đây là nơi gọi thư viện với data nè em gõ đúng tên vào đó

        $this->load->model("Model_dk");
        $this->load->library('encrypt');
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $this->load->view('modules/header');
        $this->load->view('modules/nav');
        $this->load->view('login');
        $this->load->view('modules/footer');
    }

//        if (isset($_POST["dk"])) {
//            $_SESSION["dk"] = 1;
//        }
//        if (isset($_POST["out"])) {
//            $this->session->unset_userdata("dk");
//        }    

    public function check_dn() {
        if (isset($_POST["login"])) {
            $this->form_validation->set_rules('ten', 'Tên', 'trim|required|min_length[1]|callback__ten');
            $this->form_validation->set_rules('pass', 'Mật khẩu', 'trim|required|min_length[1]|callback_welcome[' . $this->input->post('ten') . ']');
            $this->form_validation->set_message('required', '%s Không Được Để Trống ');
            $this->form_validation->set_error_delimiters('<div class="error"><div>', '</div></div>');

            if ($this->form_validation->run()) {
                $_SESSION['ten'] = $this->input->post('ten');
                redirect('welcome/loadroom');
            } else {
                $this->load->view('modules/header');
                $this->load->view('modules/nav');
                $this->load->view('login');
                $this->load->view('modules/footer');
            }
        }
        if (isset($_POST['dk'])) {
            redirect('welcome/load_dangky');
        }
    }

    public function _ten($ten = '') {
        $count = $this->Model_dk->total(array('name' => $ten));
        if ($count == 0) {
            $this->form_validation->set_message('_ten', 'Tài khoản không đúng');
            $this->form_validation->set_error_delimiters('');
            return FALSE;
        }
        return TRUE;
    }

    public function welcome($pass = '') {
        $ten = $this->input->post('ten');
        $user = $this->Model_dk->get('name, pass', array('name' => $ten));
        if ($user['pass'] != $pass) {
            $this->form_validation->set_message('welcome', 'Mật khẩu không đúng');
            return FALSE;
        }
        return TRUE;
    }

    public function load_dangky() {
        $this->load->view('modules/header');
        $this->load->view('modules/nav');
        $this->load->view('form_dangky');
        $this->load->view('modules/footer');
    }

    public function check_dangky() {
        if (isset($_POST['dangky'])) {
            $this->form_validation->set_rules('ten', 'Tên', 'trim|required');
            $this->form_validation->set_rules('pass', 'Mật khẩu', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_message('required', '%s Không Được Để Trống ');
            $this->form_validation->set_error_delimiters('');
            if ($this->form_validation->run()) {

                // data và gửi lên đb
                $data3 = array(
                    "name" => $_POST["ten"],
                    "time" => time(),
                    "email" => $_POST["email"],
                    "pass" => $_POST["pass"]
                );
                //var_dump($data3);
                $this->Model_dk->insert_user($data3);
            }
            $this->load->view('modules/header');
            $this->load->view('modules/nav');
            $this->load->view('form_dangky');
            $this->load->view('modules/footer');
        }
        if (isset($_POST['out'])) {
            redirect('welcome/out');
        }
    }

    public function out() {
        $this->load->view('modules/header');
        $this->load->view('modules/nav');
        $this->load->view('login');
        $this->load->view('modules/footer');
    }

    public function loadtintuc() {
        $this->load->view('modules/header');
        $this->load->view('modules/nav');
        $this->load->view('tintuc');
        $this->load->view('modules/footer');
    }

    public function load_hotro() {
        $this->load->view('modules/header');
        $this->load->view('modules/nav');
        $this->load->view('hotro');
        $this->load->view('modules/footer');
    }

    public function loadroom() {
        $this->load->view('modules/header');
        $this->load->view('modules/nav');
        $data["data"] = $this->Model_dk->get_room();
        $this->load->view('load_phong', $data);
        $this->load->view('modules/footer');
    }

    public function load_ingame() {
        $id = $_GET['id'];
        $data = $this->Model_dk->check_phong($id);
        foreach ($data as $item) {
            $sl = $item['sl_nguoi'];
        }
        if ($sl < 2) {
            $_SESSION['id_phong'] = $id;
            $this->Model_dk->update_sl_nguoi($id);
            echo "ok";
        }
    }

    public function load_game() {
        $this->load->view('modules/header');
        $this->load->view('modules/nav');
        $this->load->view('loadgame');
        $this->load->view('modules/footer');
    }

    public function load_gameX() {
        $this->load->view('modules/header');
        $this->load->view('modules/nav');
        $this->load->view('loadgame_x');
        $this->load->view('modules/footer');
    }

    public function vao_phong() {

        $this->load->view('modules/header');
        $this->load->view('modules/nav');
        $this->load->view('load_room');
        $this->load->view('modules/footer');
    }

    public function update_tv($row = '') {
        $data = array("sl_nguoi" => $row);
        $this->db->where("id", $id);
        $this->db->update("phong", $data);
    }

    public function load_chat() {
        //$user= $_REQUEST['_user'];
        //$message= $_REQUEST['_message'];
        if (isset($_POST['submit'])) {
            $user = $_SESSION['ten'];
            $message = $_POST['_message'];
            // $message= $_REQUEST['msg'];
            if (!empty($message)) {
                $data1 = array("_user" => $user,
                    "_msg" => $message);
                $this->Model_dk->chatbox($data1);
            }
        }
        $this->load->view('modules/header');
        $this->load->view('modules/nav');
        $this->load->view('loadgame');
        $this->load->view('modules/footer');
    }

    public function load_message() {
        $data4 = $this->Model_dk->load_chat();
    }

}
