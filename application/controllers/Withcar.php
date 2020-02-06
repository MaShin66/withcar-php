<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withcar extends CI_Controller {
  function __construct() { // 초기화 하는 곳이라 처음 생성할 때 로드하는 곳
        parent::__construct();
        $this->load->model('Withcar_model');
	}

    public function index() { // 처음 게시판
        if($this->input->post()){
            $this->_email_signup($this->input->post());
        } else if ($this->session->userdata()) {
            $session_data = $this->session->userdata();
            $this->load->view('section/head', array('session_data' => $session_data));
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
        $return_value = $this->Withcar_model->get_row('user', 'email', $data['email']);
        if($data['email'] === $return_value->email && password_verify($data['password'], $return_value->password)) {
            $this->session->set_userdata(array(
                'email' => $return_value->email,
                'user_id' => $return_value->user_id,
                'user_name' =>  $return_value->user_name,
                'phone' => $return_value->phone,
                'is_driver' => $return_value->is_driver,
                'is_login' => true));
            redirect('withcar', 'refresh');
        } else {
            echo '<script>alert("로그인을 실패했습니다.");</script>';
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
    }
    
    function logout() {
        $this->session->sess_destroy();
        redirect('withcar', 'refresh');
    }

    function _login_check() {
        if(!$this->session->userdata('is_login')) {
            echo '<script>alert("로그인이 필요합니다.")</script>';
            redirect(site_url().'/withcar/login', 'refresh');
        }
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
        $return_value = $this->Withcar_model->insert('user', $data);
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
        if ($this->session->userdata('is_login')) {
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('ride_route', array('session_data' => $session_data, 'ride_address' => $ride_address));
            $this->load->view('section/footer');
        } else {
            $this->load->view('section/head');
            $this->load->view('ride_route', array('ride_address' => $ride_address));
            $this->load->view('section/footer');
        }
    }

    function ridelist() {
        if(!$this->session->userdata('is_login')) {
            echo '<script>alert("로그인이 필요합니다");</script>';
            redirect('/withcar/login', 'refresh');
        } else {
            if($this->input->post()) {
                $ride_info = $this->input->post();
                $this->Withcar_model->insert('ride', $ride_info);
                echo '<script>alert("등록이 완료되었습니다.")</script>';
            } 
    
            $return_ridelist = $this->Withcar_model->get_result('ride', 'status', 'REQUESTING');
            $session_data = $this->session->userdata();
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('ridelist', array('return_ridelist' => $return_ridelist));
            $this->load->view('section/footer');
        }
        
    }

    function ride($ride_id) {
        if(!$this->session->userdata('is_login')) {
            echo '<script>alert("로그인이 필요합니다");</script>';
            redirect('/withcar/login', 'refresh');
        } else {
            $get_value = $this->Withcar_model->get_row('ride', 'ride_id', $ride_id);
        if($get_value->status === 'UNPAID') {
            $return_value = $this->Withcar_model->update_data('ride_id', $ride_id, 'status', 'UNPAID', 'ride');

            $session_data = $this->session->userdata();
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('riding', array('return_value' => $return_value));
            $this->load->view('section/footer');
        }

        $return_ride_value = $this->Withcar_model->get_row('ride', 'ride_id', $ride_id);
        $session_data = $this->session->userdata();
        $this->load->view('section/head', array('session_data' => $session_data));
        $this->load->view('ride', array('return_ride_value' => $return_ride_value));
        $this->load->view('section/footer');
        }
    }

    function riding($ride_id) {
        echo '<script>alert("탑승을 수락했습니다")</script>';
        // 유저쪽에서 신청한 ride의 status가 ACCEPTED 로 변경됐을 때 알림 필요
        $return_value = $this->Withcar_model->update_data('ride_id', $ride_id, 'status', 'ACCEPTED', 'ride'); 
        $data['status'] = 'ACCEPTED';
        $data['driver_id'] = $this->session->userdata('user_id');
        $data['driver_name'] = $this->session->userdata('user_name');
        $data['driver_phone'] = $this->session->userdata('phone');
        $return_value = $this->Withcar_model->update_data2('ride_id', $ride_id, $data, 'ride');
        $session_data = $this->session->userdata();
        $this->load->view('section/head', array('session_data' => $session_data));
        $this->load->view('riding', array('return_value' => $return_value));
        $this->load->view('section/footer');
    }

    function my_route($user_id) {
        if(!$this->session->userdata('is_login')) {
            echo '<script>alert("로그인이 필요합니다");</script>';
            redirect('/withcar/login', 'refresh');
        } else {
            if($this->session->userdata('is_driver') === '1') {
                $return_value = $this->Withcar_model->get_result('ride', 'driver_id', $user_id);
            } else if ($this->session->userdata('is_driver') === '0') {
                $return_value = $this->Withcar_model->get_result('ride', 'user_id', $user_id);
            }
            
            $session_data = $this->session->userdata();
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('my_route', array('return_value' => $return_value));
            $this->load->view('section/footer');
        }
    }

    function onroute($ride_id) {
        $this->_login_check();
        $get_value = $this->Withcar_model->get_row('ride', 'ride_id', $ride_id);
        if($get_value->status === 'UNPAID') {
            $return_value = $this->Withcar_model->update_data('ride_id', $ride_id, 'status', 'UNPAID', 'ride');
        } else {
            $return_value = $this->Withcar_model->update_data('ride_id', $ride_id, 'status', 'ONROUTE', 'ride');
        }

        $session_data = $this->session->userdata();
        $this->load->view('section/head', array('session_data' => $session_data));
        $this->load->view('riding', array('return_value' => $return_value));
        $this->load->view('section/footer');
    }
    
    function finished($ride_id) {
        $get_value = $this->Withcar_model->get_row('ride', 'ride_id', $ride_id);
        if($get_value->status === 'UNPAID') {
            $return_value = $this->Withcar_model->update_data('ride_id', $ride_id, 'status', 'UNPAID', 'ride');
        } else if($get_value->status === 'FINISHED') {
            echo '<script>alert("결제가 완료되었습니다")</script>';
        }

        $session_data = $this->session->userdata();
        $this->load->view('section/head', array('session_data' => $session_data));
        $this->load->view('finished', array('return_value' => $get_value));
        $this->load->view('section/footer');
    }

    function payment($ride_id) {
        if(!$this->session->userdata('is_login')) {
            echo '<script>alert("로그인이 필요합니다");</script>';
            redirect('/withcar/login', 'refresh');
        } else {
            $return_ride_value = $this->Withcar_model->get_row('ride', 'ride_id', $ride_id);
            $return_user_value = $this->Withcar_model->get_row('user', 'user_id', $return_ride_value->driver_id);

            $session_data = $this->session->userdata();
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('payment', array('return_ride_value' => $return_ride_value, 'return_user_value' => $return_user_value));
            $this->load->view('section/footer');
        }
    }
    
    function ride_cancel($ride_id) {
        echo '<script>alert("탑승을 취소했습니다")</script>';

        $return_value = $this->Withcar_model->update_data('ride_id', $ride_id, 'status', 'REQUESTING', 'ride');
        redirect('withcar/ridelist', 'refresh');
    }

    function driver_enroll($user_id) {
        if(!$this->session->userdata('is_login')) {
            echo '<script>alert("로그인이 필요합니다");</script>';
            redirect('/withcar/login', 'refresh');
        } else {
            $session_data = $this->session->userdata();
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('driver_enroll', array('user_id' => $user_id));
            $this->load->view('section/footer');
        }
    }

    function driver_enroll2($user_id) {
        $data = $this->input->post();
        $this->Withcar_model->update_data2('user_id', $user_id, $data, 'user');
        echo '<script>alert("운전자 등록이 완료되었습니다. 다시 로그인해주세요")</script>';
        redirect('withcar/logout', 'refresh');
    }

    function is_pay($ride_id) {
        $this->Withcar_model->update_data('ride_id', $ride_id, 'status', 'FINISHED', 'ride');
        redirect('/withcar', 'refresh');
    }
    
    function editprofile($user_id) {
        if(!$this->session->userdata('is_login')) {
            echo '<script>alert("로그인이 필요합니다");</script>';
            redirect('/withcar/login', 'refresh');
        } else {
            $return_user_value = $this->Withcar_model->get_row('user', 'user_id', $user_id);

            $session_data = $this->session->userdata();
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('editprofile', array('return_user_value' => $return_user_value));
            $this->load->view('section/footer');
        }
    }

    function changepwd($user_id) {
        if(!$this->session->userdata('is_login')) {
            echo '<script>alert("로그인이 필요합니다");</script>';
            redirect('/withcar/login', 'refresh');
        } else {
            $return_user_value = $this->Withcar_model->get_row('user', 'user_id', $user_id);

            $session_data = $this->session->userdata();
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('changepwd', array('return_user_value' => $return_user_value));
            $this->load->view('section/footer');
        }
    }

    function chagepwd2() {
        $user_id = $this->session->userdata('user_id');
        $input_data = $this->input->post();
        $hash_pwd = password_hash($input_data['password'], PASSWORD_BCRYPT);
        $input_data['password'] = $hash_pwd;
        $return_value = $this->Withcar_model->update_data('user_id', $user_id, 'password', $input_data['password'], 'user');
        if($return_value) {
            echo '<script>alert("비밀번호가 변경 되었습니다.")</script>';
            redirect('withcar', 'refresh');
        } else {
            echo '<script>alert("오류로 인해 비밀번호 변경에 실패했습니다.")</script>';
        }
    }

    function calculate($user_id) {
        if(!$this->session->userdata('is_login')) {
            echo '<script>alert("로그인이 필요합니다");</script>';
            redirect('/withcar/login', 'refresh');
        } else {
            $return_unpiad_price = $this->Withcar_model->price_unpiad_get('ride', 'driver_id', $user_id);
            $return_finished_price = $this->Withcar_model->price_finished_get('ride', 'driver_id', $user_id);
        
            $session_data = $this->session->userdata();
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('calculate', array('return_unpiad_price' => $return_unpiad_price, 'return_finished_price' => $return_finished_price));
            $this->load->view('section/footer');
        }
    }


}
