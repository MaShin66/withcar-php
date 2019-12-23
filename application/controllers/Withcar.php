<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withcar extends CI_Controller {
  function __construct() { // 초기화 하는 곳이라 처음 생성할 때 로드하는 곳
        parent::__construct();
        $this->load->model('withcar_model');
	}

    public function index() { // 처음 게시판
        if($this->input->post()){
            $this->_email_signup($this->input->post());
        } else if ($this->session->userdata()) {
            $session_data = $this->session->userdata();

            $this->load->view('section/head');
            $this->load->view('withcar_view', array('session_data' => $session_data));
            $this->load->view('section/footer');
        } else {
            $this->load->view('section/head');
            $this->load->view('withcar_view');
            $this->load->view('section/footer');
        }
        
	}

    function login() { // 회원가입, 로그인
        $this->load->view('section/head');
        $this->load->view('login');
        $this->load->view('section/footer');
    }

    function authentication() {
        $data = $this->input->post();
        $return_value = $this->withcar_model->user_get($data);
        if($data['email'] === $return_value->email && password_verify($data['password'], $return_value->password)) {
            $this->session->set_userdata(array(
                'email' => $return_value->email,
                'user_id' => $return_value->user_id,
                'user_name' =>  $return_value->user_name,
                'is_login' => true));
            redirect('withcar/');
        } else {
            echo '로그인 실패';
        }
    }
    
    function logout() {
        $this->session->sess_destroy();
        redirect('withcar/');
    }

    function signup() {
        $this->load->view('section/head');
        $this->load->view('signup');
        $this->load->view('section/footer');
    }

    function email_signup() {
        $this->load->view('section/head');
        $this->load->view('email_signup');
        $this->load->view('section/footer');
    }

    function _email_signup($data) {
        $hash_pwd = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['password'] = $hash_pwd;
        $return_value = $this->withcar_model->insert('user', $data);
        if($return_value > 0) {
            echo '<script>alert("회원가입이 되었습니다.")</script>';
            redirect('withcar', 'refresh');
        } else {
            echo '<script>alert("오류로 인해 회원가입이 실패했습니다.")</script>';
        }
    }

    function ride_route() {
        $ride_address = $this->input->post();
        $session_data = $this->session->userdata();
        var_dump($ride_address);
        if ($this->session->userdata('is_login')) {
            $this->load->view('section/head');
            $this->load->view('ride_route', array('session_data' => $session_data, 'ride_address' => $ride_address));
            $this->load->view('section/footer');
        } else {
            $this->load->view('section/head');
            $this->load->view('ride_route', array('ride_address' => $ride_address));
            $this->load->view('section/footer');
        }
    }

    function ridelist() {
        $ride_info = $this->input->post();

        // $this->withcar_model->insert('ride', $ride_info);
        // echo '<script>alert("등록이 완료되었습니다.")</script>';

        $return_ridelist = $this->withcar_model->ride_get('status', 'REQUESTING');
        $this->load->view('ridelist', array('return_ridelist' => $return_ridelist));
        
    }

    function ride($ride_id) {
        $return_ride_value = $this->withcar_model->ride_get('ride_id', $ride_id);
        $this->load->view('section/head');
        $this->load->view('ride', array('return_ride_value' => $return_ride_value));
        $this->load->view('section/footer');
    }




}
