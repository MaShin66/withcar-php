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
        $return_value = $this->withcar_model->get_row($data);
        if($data['email'] === $return_value->email && password_verify($data['password'], $return_value->password)) {
            $this->session->set_userdata(array(
                'email' => $return_value->email,
                'user_id' => $return_value->user_id,
                'user_name' =>  $return_value->user_name,
                'is_driver' => $return_value->is_driver,
                'is_login' => true));
            redirect('withcar', 'refresh');
        } else {
            echo '로그인 실패';
        }
    }
    
    function logout() {
        $this->session->sess_destroy();
        redirect('withcar', 'refresh');
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
        if($this->input->post()) {
            $ride_info = $this->input->post();
            $this->withcar_model->insert('ride', $ride_info);
            echo '<script>alert("등록이 완료되었습니다.")</script>';
        } 

        $return_ridelist = $this->withcar_model->get_result('ride', 'status', 'REQUESTING');
        $this->load->view('ridelist', array('return_ridelist' => $return_ridelist));
        
    }

    function ride($ride_id) {
        $return_ride_value = $this->withcar_model->get_result('ride', 'ride_id', $ride_id);
        $this->load->view('section/head');
        $this->load->view('ride', array('return_ride_value' => $return_ride_value));
        $this->load->view('section/footer');
    }

    function riding($ride_id) {
        // echo '<script>alert("탑승을 수락했습니다")</script>';
        // 유저쪽에서 신청한 ride의 status가 ACCEPTED 로 변경됐을 때 알림 필요
        $return_value = $this->withcar_model->update_data('ride_id', $ride_id, 'status', 'ACCEPTED', 'ride');
        $this->load->view('section/head');
        $this->load->view('riding', array('return_value' => $return_value));
        $this->load->view('section/footer');
    }

    function my_route($user_id) {
        $return_value = $this->withcar_model->get_result('ride', 'user_id', $user_id);

        $this->load->view('section/head');
        $this->load->view('my_route', array('return_value' => $return_value));
        $this->load->view('section/footer');
    }

    function onroute($ride_id) {
        $return_value = $this->withcar_model->update_data('ride_id', $ride_id, 'status', 'ONROUTE', 'ride');
        
        $this->load->view('section/head');
        $this->load->view('riding', array('return_value' => $return_value));
        $this->load->view('section/footer');
    }

    function ride_cancel($ride_id) {
        echo '<script>alert("탑승을 취소했습니다")</script>';

        $return_value = $this->withcar_model->update_data('ride_id', $ride_id, 'status', 'REQUESTING', 'ride');
        redirect('withcar/ridelist', 'refresh');
    }

    function finished($ride_id) {
        echo '<script>alert("운행이 종료되었습니다")</script>';
        $return_value = $this->withcar_model->update_data('ride_id', $ride_id, 'status', 'FINISHED', 'ride');

        $this->load->view('section/head');
        $this->load->view('finished', array('return_value' => $return_value));
        $this->load->view('section/footer');
        
    }



}
