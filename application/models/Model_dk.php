<?php

class Model_dk extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function listall() {
        $query = $this->db->get("login");
        return $query->result();
    }

    public function insert_user($data = array()) {
        $this->db->insert("login", $data);
    }

    public function total($where = NULL) {
        $this->db->from('login');
        if (isset($where) && count($where)) {
            $this->db->where($where);
        }
        return $this->db->count_all_results();
    }

    function get($select = 'name,pass', $where = NULL) {
        $this->db->select($select)->from('login');
        if (isset($where) && count($where)) {
            $this->db->where($where);
        }
        return $this->db->get()->row_array();
    }

    function login($ten, $pass) {
        $this->db->select('id, name, pass');
        $this->db->from('login');
        $this->db->where('name', $ten);
        $this->db->where('pass', sha1($pass));
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function insert_room($data = array()) {
        $this->db->insert("taikhoan", $data);
    }

    public function get_room() {
        $query = $this->db->get("phong");
        return $query->result_array();
    }

    public function check_phong($id) {
        $this->db->select('id,sl_nguoi');
        $this->db->from('phong');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function chatbox($data = array()) {
        $this->db->insert("chatbox", $data);
        $qr = $this->db->query("SELECT * FROM chatbox ORDER BY id");
        return $qr->result_array();
//        while ($result ->mysql_fetch_array($qr)) {
//            echo $result['_user'] . ':' . $result['_msg'] . '<br>';
//        }
        
    }

    public function load_chat() {
        $this->db->get("chatbox");
        //$qr = $this->db->query("SELECT * FROM chatbox");
        $qr = $this->db->query("SELECT * FROM chatbox ORDER BY id");
        // $qr = $this->db->order_by('id', 'ASC');
        while ($row = $qr->unbuffered_row()) {
            echo '<b>'.$row->_user.'</b>' .' : '.$row->_msg.'<br>';
        }
//        Foreach ($qr->result_array() as $row) {
//            echo $row ['_user'] . ' : ' . $row['_msg'] . '<br>';
//        }
    }
    

    public function update_sl_nguoi($id) {
        $this->db->set('sl_nguoi', 'sl_nguoi + 1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('phong');
    }

}
