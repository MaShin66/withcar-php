<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withcar extends CI_Controller {

    /**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

  function __construct() { // 초기화 하는 곳이라 처음 생성할 때 로드하는 곳
        parent::__construct();
        $this->load->model('withcar_model');
	}

    public function index() { // 처음 게시판
        if($this->input->post()){
            $this->_email_signup($this->input->post());
        } else {
            $this->load->view('section/head');
		    // $result = $this->withcar_model->test();
            $this->load->view('withcar_view', array('result'=>$result));
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
        $this->withcar_model->email_get($data);
        
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

    function _rideEnroll($ride_address) {        
    //    var_dump($ride_address);
//        $returnData = $this->model->insert($rideData);

        echo '<script>alert("등록이 완료되었습니다.")</script>';
    }

    function ridecheck() {
        $ride_address = $this->input->post();
        var_dump($ride_address);
        // $this->_rideEnroll($ride_address);

        // $this->load->view('section/head');
        $this->load->view('rideList', array('ride_address' => $ride_address));
        // $this->load->view('section/footer');
    }

    function ridelist() {
        $ride_info = $this->input->post();
        var_dump($ride_info);
    }

    function ride($number) {
//        $ridedata = $this->input->post();
//        $returnData = $this->model->getRide($number);
//        $this->load->view('withcar/ride', array('choiceRideData' => $returnData));
        $this->load->view('section/head');
        $this->load->view('ride');
        $this->load->view('section/footer');
    }



}
