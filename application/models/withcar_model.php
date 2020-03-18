<?php
class Withcar_model extends CI_Model {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Seoul');
	}

	function insert($table, $data) {
		$data['created'] = date("Y-m-d H:i:s");
		if($table === 'ride') {
			$data['ride_time'] = $data['date_value'].' '.$data['time_value'];
			unset($data['date_value']);
			unset($data['time_value']);
		}
		
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	function get_row($table, $column, $data) {
		$this->db->select('*');
		return $this->db->get_where($table, array($column => $data)) -> row();
	}

	function get_result($table, $column, $data) {
		$this->db->select('*');
		if($table === 'ride') { // ridelist 는 지금 시간보다 미래의 운행만 보여줘야하고, 가까운 순으로 정렬하기 위해
			$current_date = date("Y-m-d H:i", time());
			$this->db->where('ride_time >=', $current_date);
			return $this->db->order_by('ride_time', 'AEC')->get_where($table, array($column => $data)) -> result(); // row(); 로 바꿔보기
		} else {
			return $this->db->order_by('created', 'DESC')->get_where($table, array($column => $data)) -> result(); // row(); 로 바꿔보기
		}
	}

	function get_result2($table, $column, $data, $column2, $data2) {
		$this->db->select('*');
		$this->db->where_not_in($column2, $data2);
		return $this->db->order_by('created', 'DESC')->get_where($table, array($column => $data)) -> result(); // row(); 로 바꿔보기
	}

	function get_result3($table, $column, $data, $column2, $data2) {
		$this->db->select('*');
		$this->db->where($column2, $data2);
		return $this->db->order_by('ride_time', 'DESC')->get_where($table, array($column => $data)) -> row();
	}

	function get_self_ride($user_id) {
		$this->db->select('*');
		$current_date = date("Y-m-d H:i", time());
		$this->db->where('ride_time >=', $current_date);
		$this->db->where('user_id', $user_id);
		return $this->db->order_by('ride_time', 'AEC')->get_where('ride', array('status' => 'REQUESTING')) -> result();
	}

	function get_requesting_ride($user_id) {
		$this->db->select('*');
		$current_date = date("Y-m-d H:i", time());
		$this->db->where('ride_time >=', $current_date);
		$this->db->where_not_in('user_id', $user_id);
		return $this->db->order_by('ride_time', 'AEC')->get_where('ride', array('status' => 'REQUESTING')) -> result();
	}

	function user_get_accepted_ride($user_id) {
		$this->db->select('*');
		$current_date = date("Y-m-d H:i", time());
		$this->db->where('ride_time >=', $current_date);
		$this->db->where('user_id', $user_id);
		return $this->db->order_by('ride_time', 'AEC')->get_where('ride', array('status' => 'ACCEPTED')) -> result();
	}

	function driver_get_accepted_ride($user_id) {
		$this->db->select('*');
		$current_date = date("Y-m-d H:i", time());
		$this->db->where('ride_time >=', $current_date);
		$this->db->where('driver_id', $user_id);
		return $this->db->order_by('ride_time', 'AEC')->get_where('ride', array('status' => 'ACCEPTED')) -> result();
	}

	function user_get_onroute_ride($user_id) {
		$this->db->select('*');
		$current_date = date("Y-m-d H:i", time());
		$this->db->where('ride_time >=', $current_date);
		$this->db->where('user_id', $user_id);
		return $this->db->order_by('ride_time', 'AEC')->get_where('ride', array('status' => 'ONROUTE')) -> result();
	}

	function driver_get_onroute_ride($user_id) {
		$this->db->select('*');
		$current_date = date("Y-m-d H:i", time());
		$this->db->where('ride_time >=', $current_date);
		$this->db->where('driver_id', $user_id);
		return $this->db->order_by('ride_time', 'AEC')->get_where('ride', array('status' => 'ONROUTE')) -> result();
	}
	
	function update_data($where, $where_data, $set, $set_data, $table) {
		$this->db->where($where, $where_data);
		$this->db->set($set, $set_data);
		$this->db->update($table);

		return $this->db->get_where($table, array($where => $where_data)) -> row();
	}

	function update_data2($where, $where_data, $data, $table) {
		if($table === 'user') { // driver_id 를 유일값으로 못하다보니 user_id 의 값과 같은 것으로 넣기
			$data['driver_id'] = $where_data;
		}
		$this->db->where($where, $where_data);
		$this->db->update($table, $data);

		return $this->db->get_where($table, array($where => $where_data)) -> row();
	}

	function price_unpiad_get($table, $column, $data) {
		$this->db->select_sum('withcar_price');
		$this->db->from($table);
		$this->db->where($column, $data);
		$this->db->where('status', 'UNPAID');

		$query = $this->db->get();
		return $query->row();
	}

	function price_finished_get($table, $column, $data) {
		$this->db->select_sum('withcar_price');
		$this->db->from($table);
		$this->db->where($column, $data);
		$this->db->where('status', 'FINISHED');

		$query = $this->db->get();
		return $query->row();
	}

	function chat_is($ride_id) {
		$this->db->select('*');
		$this->db->from('chat');
		$this->db->where('ride_id', $ride_id);

		$query = $this->db->get();
		return $query->row_array();
	}
	
	function chat_start($data) {
		$data['created'] = date("Y-m-d H:i:s");	
		$this->db->insert('chat', $data);
		return $this->db->insert_id();
	}
	
	function chat_get($chat_id) {
		$this->db->select('*');
		return $this->db->get_where('chat', array('chat_id' => $chat_id)) -> row_array();

		// $return_value = $this->db->get_where('chat', array('chat_id' => $chat_id)) -> row_array();
		// var_dump($return_value);
	}

	function chat_update($chat_id, $data) {
		$this->db->where('chat_id', $chat_id);
		$this->db->update('chat', $data);

		return $this->db->get_where('chat', array('chat_id' => $chat_id)) -> row_array();
	}

	function chat_insert($chat_id, $msg) {
		$session_data = $this->session->userdata();

		// 기존 대화 데이터 있으면 추가하도록 적기
		$origin_msg = $this->chat_get($chat_id);

		if($session_data['is_driving'] === '1') {
			if(isset($origin_msg['driver_msg'])) {
				$decode_origin_msg = json_decode($origin_msg['driver_msg']);
				$current_time = date("Y-m-d H:i:s", time());
				$decode_origin_msg->$current_time = $msg;
				$origin_msg['driver_msg'] = json_encode($decode_origin_msg, JSON_UNESCAPED_UNICODE);
			} else if(!isset($origin_msg['driver_msg'])) {
				$origin_msg['driver_msg'][date("Y-m-d H:i:s")] = $msg;
				$origin_msg['driver_msg'] = json_encode($origin_msg['driver_msg'], JSON_UNESCAPED_UNICODE);
			}
		} else if($session_data['is_driving'] === '0') {
			if(isset($origin_msg['user_msg'])) {
				$decode_origin_msg = json_decode($origin_msg['user_msg']);
				$current_time = date("Y-m-d H:i:s", time());
				$decode_origin_msg->$current_time = $msg;
				$origin_msg['user_msg'] = json_encode($decode_origin_msg, JSON_UNESCAPED_UNICODE);
			} else if(!isset($origin_msg['user_msg'])) {
				$origin_msg['user_msg'][date("Y-m-d H:i:s")] = $msg;
				$origin_msg['user_msg'] = json_encode($origin_msg['user_msg'], JSON_UNESCAPED_UNICODE);
			}
		}

		$this->db->where('chat_id', $chat_id);
		$this->db->update('chat', $origin_msg);

		return $this->db->get_where('chat', array('chat_id' => $chat_id)) -> row_array();
	}



}

// function board()
// {
// 	// $sql = (SELECT * FROM 'board');
// 	$sql = "SELECT * FROM board ORDER BY date DESC";
// 	// $query = $this->db->$sql;
// 	$query = $this -> db -> query($sql);
// 	// $row = array('query' => result);
// 	$row = $query -> result();

// 	// return = $row
// 	return $row;
// }

// function get_data($number){ //36
// 	$this->db->select('*');
// 	$this->db->from('board');
// 	$this->db->where('id', $number);

// 	$query = $this->db->get();

// 	$row = $query->row_array(); // 딱 하나의 결과만을 출력

// 	return $row;
// }

// function receive($title, $user, $contents) {

// 	$data = array(
//         'title' => $title,
//         'user' => $user,
//         'contents' => $contents,
// 				'date' => date("Y-m-d H:i:s")
// );

// $this->db->insert('board', $data);

// $insert_id = $this->db->insert_id();

// return $insert_id;

// }

// 	function delete($id) {
// 		$this->db->where('id', $id); // id 값을 기준으로 지우기 위해 한건가..?
// 		$this->db->delete('board');

// 		return false;
// 	}

// 	function modify($id) {

// 	}

// 	function update($title, $user, $contents, $id){
// 		$data = array(
//         'title' => $title,
//         'user' => $user,
//         'contents' => $contents,
// 		'date' => date("Y-m-d H:i:s")
// );

// 		$this->db->where('id', $id);
// 		$this->db->update('board', $data);

// 		return 0;
// 	}

// // 복습 부분

// 	function receive2($title, $user, $contents){ //receive2 함수를 만들었고 controllers에서 3개의 변수를 받아와야하니 파라미터를 지정

// 		$data2 = array( //array를 이용해 차례로 변수 $data2에 넣는다
// 			'title' => $title,
// 			'user' => $user,
// 			'contents' => $contents,
// 			'date' => date("Y-m-d H:i:s")
// 	);

// $this->db->insert('board', $data2); // $this->db->insert 는 문법이며 board 라는 테이블에 변수 $data2 의 값을 넣으라는 뜻

// $insert2_id = $this->db->insert_id(); // db에서 id까지 넣은 값을 변수 $insert2_id로 대입

// return $insert2_id; // 위의 변수 $insert2_id 값 반환

// 	}

//   } ?>
