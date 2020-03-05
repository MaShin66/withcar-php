<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withcar extends CI_Controller {
  function __construct() { // 초기화 하는 곳이라 처음 생성할 때 로드하는 곳
        parent::__construct();
        $this->load->model('Withcar_model');
	}

    public function index() { // 처음 게시판
        if($this->session->userdata('is_driving') === '0') { // 탑승자 모드
            $return_ride_value = $this->Withcar_model->get_result3('ride', 'user_id', $this->session->userdata('user_id'),'status', 'ONROUTE');
            if($return_ride_value) { // ONROUTE 인 운행이 있다면 운행중인 페이지 보여주고
                $this->riding($return_ride_value->ride_id);
            } else { // 운행중인 페이지 없다면 운행 리스트 보여주기
                $session_data = $this->session->userdata();
                $this->load->view('section/head', array('session_data' => $session_data));
                $this->load->view('withcar_view', array('session_data' => $session_data));
                $this->load->view('section/footer');
            }
        } else if($this->session->userdata('is_driving') === '1') { // 운행자 모드
            $return_ride_value = $this->Withcar_model->get_result3('ride', 'driver_id', $this->session->userdata('user_id'),'status', 'ONROUTE');
            if($return_ride_value) { // ONROUTE 인 운행이 있다면 운행중인 페이지 보여주고
                $this->riding($return_ride_value->ride_id);
            } else { // 운행중인 페이지 없다면 운행 리스트 보여주기
                $this->ridelist();
            }
        } else { // 비로그인
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
                'is_driving' => $return_value->is_driving,
                'is_login' => true));
            redirect('withcar', 'refresh');
        } else {
            echo '<script>alert("로그인을 실패했습니다.");</script>';
            redirect($_SERVER['HTTP_REFERER'], 'refresh'); // 이전 페이지로 리다이렉트
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

    function email_authentication() {
        $this->load->view('section/head');
        $this->load->view('email_authentication');
        $this->load->view('section/footer');
    }

    function email_check($email) {
        $return_value = $this->Withcar_model->get_row('user', 'email', $email);
        
        echo json_encode($return_value, JSON_UNESCAPED_UNICODE);
    }

    function email_send($email, $code) {
        $this->load->library('email');

        $this->email->from('withcar666@gmail.com', '나');
        $this->email->to($email);
        $this->email->subject('WITHCAR 메일 인증');

        $this->email->message('인증번호는 '.$code.' 입니다.');

        echo $code;
        
        // if($this->email->send()) {
        //     echo $code;
        // } else {
        //     echo $this->email->print_debugger();
        // }
    }

    function email_signup() {
        $email_id = $this->input->post('email');

        $this->load->view('section/head');
        $this->load->view('email_signup', array('email_id' => $email_id));
        $this->load->view('section/footer');
    }

    function email_signup2() {
        $data = $this->input->post();
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
        $this->_login_check();
        $session_data = $this->session->userdata();
        if($this->input->post()) { // 이전페이지가 운행 등록이라면
            $ride_info = $this->input->post();
            if($ride_info['payment'] === 'CASH') { // 현금같은 경우 십원 단위는 버려야하므로 십의자리에서 반올림해서 등록
                $ride_info['withcar_price'] = (int)preg_replace("/[^\d]/i", "", $ride_info['withcar_price']);
                $ride_info['withcar_price'] = round($ride_info['withcar_price'], -2);
                $ride_info['withcar_price'] = substr($ride_info['withcar_price'], -4, 1).','.substr($ride_info['withcar_price'], -3).' 원';
            }
            $this->Withcar_model->insert('ride', $ride_info);
            echo '<script>alert("등록이 완료되었습니다.")</script>';
            redirect('withcar/ridelist', 'refresh');
        } else { // 이전 페이지가 운행등록이 아니라면
            if($session_data['is_driving'] === '1') { // 드라이버라면 자신을 제외한 대기중인 운행 가져오고
                $return_ridelist = $this->Withcar_model->get_requesting_ride($session_data['user_id']);
            } else if($session_data['is_driving'] === '0') { // 운행자라면 자신이 신청한 운행만 가져오기
                $return_ridelist = $this->Withcar_model->get_self_ride($session_data['user_id']);
            }
            
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('ridelist', array('return_ridelist' => $return_ridelist));
            $this->load->view('section/footer');
        }
        
    }

    function ride($ride_id) {
        $this->_login_check();
        $session_data = $this->session->userdata();
        $return_ride_value = $this->Withcar_model->get_row('ride', 'ride_id', $ride_id);
        
        // ACCEPTED + 탑승자 모드 + 이전 페이지가 requested_ride 아닐 때
        if($return_ride_value->status === 'ACCEPTED' && $session_data['is_driving'] === '0' && !strstr($_SERVER['HTTP_REFERER'], 'requested_ride')) {
            echo '<script>alert("드라이버가 요청을 수락했습니다.");</script>';
        // 드라이버 모드 + ride db에 다른 드라이버 id 가 있을 경우 + ACCEPTED 상태
        } else if(($return_ride_value->driver_id != $session_data['user_id']) && $return_ride_value->status === 'ACCEPTED' && $session_data['is_driving'] === '1') {
            echo '<script>alert("다른 드라이버가 요청을 수락했습니다.");</script>';
        } else if($return_ride_value->status === 'ONROUTE' && ($session_data['user_id'] === $return_ride_value->user_id || $session_data['user_id'] === $return_ride_value->driver_id)) {
            if(!strstr($_SERVER['HTTP_REFERER'], 'onroute_ride')) {
                echo '<script>alert("드라이버가 운행을 시작했습니다. 운행정보 페이지로 이동합니다.");</script>';
            }
            redirect('withcar/onroute/'.$return_ride_value->ride_id, 'refresh');
        }

        if($return_ride_value->status === 'UNPAID') {
            $return_value = $this->Withcar_model->update_data('ride_id', $ride_id, 'status', 'UNPAID', 'ride');
            // 굳이 있을 필요가..?

            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('riding', array('return_value' => $return_value));
            $this->load->view('section/footer');
        }

        $this->load->view('section/head', array('session_data' => $session_data));
        $this->load->view('ride', array('return_ride_value' => $return_ride_value));
        $this->load->view('section/footer');
    }

    function riding($ride_id) {
        $this->_login_check();
        
        $session_data = $this->session->userdata();
        if($session_data['is_driving'] === '1' && !strstr($_SERVER['HTTP_REFERER'], 'requested_ride')) {
            echo '<script>alert("운행을 예약했습니다")</script>';    
        }
        // 유저쪽에서 신청한 ride의 status가 ACCEPTED 로 변경됐을 때 알림 필요
        $return_value = $this->Withcar_model->update_data('ride_id', $ride_id, 'status', 'ACCEPTED', 'ride'); 
        $data['status'] = 'ACCEPTED';
        $data['driver_id'] = $this->session->userdata('user_id');
        $data['driver_name'] = $this->session->userdata('user_name');
        $data['driver_phone'] = $this->session->userdata('phone');
        $return_value = $this->Withcar_model->update_data2('ride_id', $ride_id, $data, 'ride');
        $this->load->view('section/head', array('session_data' => $session_data));
        $this->load->view('riding', array('return_value' => $return_value));
        $this->load->view('section/footer');
    }

    function my_route($user_id) {
        $this->_login_check();
            if($this->session->userdata('is_driver') === '1') {
                $return_value = $this->Withcar_model->get_result2('ride', 'driver_id', $user_id, 'status', 'REQUESTING');
            } else if ($this->session->userdata('is_driver') === '0') {
                $return_value = $this->Withcar_model->get_result2('ride', 'user_id', $user_id, 'status', 'REQUESTING');
            }
            
            $session_data = $this->session->userdata();
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('my_route', array('return_value' => $return_value));
            $this->load->view('section/footer');
        
    }

    function onroute($ride_id) { // 현재 운행중인 경로
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
        if($get_value->status === 'FINISHED') {
            echo '<script>alert("결제가 완료되었습니다")</script>';
        } else {
            $return_value = $this->Withcar_model->update_data('ride_id', $ride_id, 'status', 'UNPAID', 'ride');    
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
            $return_admin_value = $this->Withcar_model->get_row('admin', true, true);

            $session_data = $this->session->userdata();
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('payment', array(
                'return_ride_value' => $return_ride_value, 
                'return_user_value' => $return_user_value,
                'return_admin_value' => $return_admin_value));
            $this->load->view('section/footer');
        }
    }

    function requested_ride($ride_id) { // 요청이 'ACCEPTED' 인 요청들
        $this->_login_check();
        $session_data = $this->session->userdata();
        if($session_data['is_driving'] === '1') {
            $return_ride_value = $this->Withcar_model->driver_get_accepted_ride($session_data['user_id']);
        } else if($session_data['is_driving'] === '0') {
            $return_ride_value = $this->Withcar_model->user_get_accepted_ride($session_data['user_id']);
        }
        
        if($return_ride_value) {
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('ridelist', array('return_ridelist' => $return_ride_value));
            $this->load->view('section/footer');
        } else {
            echo '<script>alert("수락 운행이 없습니다. 리스트 페이지로 이동합니다.");</script>';
             redirect(site_url().'/withcar/ridelist', 'refresh');
        }
        
    }

    function onroute_ride($ride_id) { // 메뉴에서 운행중인 경로
        $this->_login_check();
        $session_data = $this->session->userdata();
        if($session_data['is_driving'] === '1') {
            $return_ride_value = $this->Withcar_model->driver_get_onroute_ride($session_data['user_id']);
        } else if($session_data['is_driving'] === '0') {
            $return_ride_value = $this->Withcar_model->user_get_onroute_ride($session_data['user_id']);
        }
        
        if($return_ride_value) {
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('ridelist', array('return_ridelist' => $return_ride_value));
            $this->load->view('section/footer');
        } else {
             echo '<script>alert("운행중인 경로가 없습니다. 리스트 페이지로 이동합니다.");</script>';
             redirect(site_url().'/withcar/ridelist', 'refresh');
        }
    }
    
    function ride_cancel($ride_id) {
        echo '<script>alert("탑승을 취소했습니다")</script>';

        $return_value = $this->Withcar_model->update_data('ride_id', $ride_id, 'status', 'REQUESTING', 'ride');
        redirect('withcar/ridelist', 'refresh');
    }

    function driver_enroll($user_id) {
        $this->_login_check();
        $session_data = $this->session->userdata();
        $this->load->view('section/head', array('session_data' => $session_data));
        $this->load->view('driver_enroll', array('user_id' => $user_id));
        $this->load->view('section/footer');
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
            $return_user_value = $this->Withcar_model->get_row('user', 'user_id', $user_id);
            $return_unpiad_price = $this->Withcar_model->price_unpiad_get('ride', 'driver_id', $user_id);
            $return_finished_price = $this->Withcar_model->price_finished_get('ride', 'driver_id', $user_id);
        
            $session_data = $this->session->userdata();
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('calculate', array(
                'return_unpiad_price' => $return_unpiad_price,
                'return_finished_price' => $return_finished_price,
                'return_user_value' => $return_user_value));
            $this->load->view('section/footer');
        }
    }

    function edit_account($user_id) {
        $return_user_value = $this->Withcar_model->get_row('user', 'user_id', $user_id);

        $session_data = $this->session->userdata();
        $this->load->view('section/head', array('session_data' => $session_data));
        $this->load->view('edit_account', array('return_user_value' => $return_user_value));
        $this->load->view('section/footer');
    }

    function edit_account2() {
        $user_id = $this->session->userdata('user_id');        
        $input_data = $this->input->post();
        $return_value = $this->Withcar_model->update_data2('user_id', $user_id, $input_data, 'user');
        if($return_value) {
            echo '<script>alert("계좌정보가 되었습니다.")</script>';
            redirect('withcar', 'refresh');
        } else {
            echo '<script>alert("오류로 인해 계좌정보 변경에 실패했습니다.")</script>';
        }

    }

    function contact() {
        $session_data = $this->session->userdata();
        $this->load->view('section/head', array('session_data' => $session_data));
        $this->load->view('contact');
        $this->load->view('section/footer');
    }

    function total_user() {
        $session_data = $this->session->userdata();
        if($session_data['user_id'] === '1') {  
            $return_user_value = $this->Withcar_model->get_result('user', true, true);
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('total_user', array('return_user_value' => $return_user_value));
            $this->load->view('section/footer');
        } else {
            redirect('withcar', 'refresh');
        }
    }

    function total_calculate() {
        $session_data = $this->session->userdata();
        if($session_data['user_id'] === '1') {    
            $this->load->view('section/head', array('session_data' => $session_data));
            $this->load->view('total_calculate');
            $this->load->view('section/footer');
        } else {
            redirect('withcar', 'refresh');
        }
    }

    function change_mode($user_id) {
        $this->_login_check();
        $return_user_value = $this->Withcar_model->get_row('user', 'user_id', $user_id);
        if($return_user_value->is_driving === '0') {
            $this->session->set_userdata(array('is_driving' => '1'));
            $this->Withcar_model->update_data('user_id', $user_id, 'is_driving', 1, 'user');
            echo '<script>alert("운전 모드로 전환됐습니다")</script>';
        } else if($return_user_value->is_driving === '1') {
            $this->session->set_userdata(array('is_driving' => '0'));
            $this->Withcar_model->update_data('user_id', $user_id, 'is_driving', 0, 'user');
            echo '<script>alert("탑승자 모드로 전환됐습니다")</script>';
        }
        redirect('withcar', 'refresh');
    }

}
