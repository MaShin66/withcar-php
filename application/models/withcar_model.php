<?php
class Withcar_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function insert($table, $data) {
		date_default_timezone_set('Asia/Seoul');
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
		return $this->db->order_by('created', 'DESC')->get_where($table, array($column => $data)) -> result(); // row(); 로 바꿔보기
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
