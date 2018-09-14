<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Model {

	public function fetch($table, $where = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$query = $this->db->get($table);
		return ($query->num_rows() > 0) ? $query->result() : FALSE;
	}

	public function fetch_distinct($table, $where = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->select('*');
		$this->db->group_by('reservation_key');
		$query = $this->db->get($table);
		return ($query->num_rows() > 0) ? $query->result() : FALSE;
	}

	public function fetch_like($table, $column, $pattern, $where = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->like($column, $pattern);
		$query = $this->db->get($table);
		return ($query->num_rows() > 0) ? $query->result() : FALSE;
	}

	public function fetchDateBetween($table, $start, $end) {
		$this->db->where('reservation_in BETWEEN "' . $start . '" and "' . $end . '" AND reservation_status = 1');
		$query = $this->db->get($table);
		return ($query->num_rows() > 0) ? $query->result() : FALSE;
	}

	public function fetch_or($table, $where = NULL, $orwhere = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
			$this->db->or_where($orwhere);
		}
		$query = $this->db->get($table);
		return ($query->num_rows() > 0) ? $query->result() : FALSE;
	}

	public function getSum($table, $column, $where = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$query = $this->db->select_sum($column);
		$query = $this->db->get($table);
		return ($query->num_rows() > 0) ? $query->result() : FALSE;
	}

	public function fetch_last($table, $column, $where = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$query = $this->db->order_by($column, "desc")->limit(1)->get($table)->row();
		return ($query) ? $query : FALSE;
	}

	public function fetch_first($table, $column, $where = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$query = $this->db->order_by($column, "asc")->limit(1)->get($table)->row();
		return ($query) ? $query : FALSE;
	}

	public function countResult($table, $where = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$query = $this->db->get($table);
		return $query->num_rows();
	}

	public function insert($table, $data) {
		if (!$this->db->insert($table, $data)) {
			return $this->db->error(); // Has keys 'code' and 'message'
		} else {
			return $this->db->affected_rows();
		}
	}

	public function insert_batch($table, $data) {
		if (!$this->db->insert_batch($table, $data)) {
			return $this->db->error(); // Has keys 'code' and 'message'
		} else {
			return $this->db->affected_rows();
		}
	}

	public function update($table, $data, $where = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}

	public function delete($table, $where = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->delete($table);
		return $this->db->last_query();
	}

	public function fetch_join($table, $col = NULL, $join = NULL, $jointype = NULL, $where = NULL, $distinct = NULL, $resultinarray = NULL, $wherein = NULL, $like = NULL, $orwherein = NULL, $orderby = NULL) {
// ver2
		if (!empty($where)) {
			$this->db->where($where);
		}
		if (!empty($orderby)) {
			$this->db->order_by($orderby[0], $orderby[1]);
		}
		if ($distinct == TRUE) {
			//depends sa irereturn na cols
			$this->db->distinct();
		}
		if (!empty($col)) {
			$this->db->select($col);
		} else {
			$this->db->select('*');
		}
		if (!empty($table)) {
			$this->db->from($table);
		}
		if (!empty($orwherein)) {
			$this->db->or_where_in($orwherein[0], $orwherein[1]);
		}
		if (!empty($wherein)) {
			$this->db->where_in($wherein[0], $wherein[1]);
		}
		if (!empty($join) && !empty($jointype)) {
			foreach ($join as $val) {
				$this->db->join($val[0], $val[1], $jointype);
			}
		} else if (!empty($join) && empty($jointype)) {
			foreach ($join as $val) {
				$this->db->join($val[0], $val[1]);
			}
		}
		if (!empty($like)) {
			foreach ($like as $val) {
				$this->db->like($val[0], $val[1]);
			}
		}
		$query = $this->db->get();
		if (!empty($resultinarray) && $resultinarray == TRUE) {
			//changed to if-else for compatibility issues - mark
			return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
		} else {
			return ($query->num_rows() > 0) ? $query->result() : FALSE;
		}
	}

	public function generateReports() {
		$orderby = ["r.room_id", "ASC"];
		$col = "r.room_name, r.room_status, r.reservation_key, rt.room_type_price, rt.room_type_pax, rt.room_type_name, rt.room_type_id";
		$join = [
			// ["reservation as res", "res.reservation_key = r.reservation_key"],
			["room_type as rt", "rt.room_type_id = r.room_type_id"],
		];
		$result = $this->Crud->fetch_join("room as r", $col, $join, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $orderby);
		$col = "reservation_id";
		foreach ($result as $sub) {
			$where = [
				"room_type_id" => $sub->room_type_id,
				"reservation_key" => $sub->reservation_key,
			];
			if ($res = $this->Crud->fetch_join("reservation", $col, NULL, NULL, $where)) {
				$sub->res_key = $res[0]->reservation_id;
			} else {
				$sub->res_key = "—";
			}
		}
		return $result;
	}
}

/* End of file Crud.php */
/* Location: ./application/models/Crud.php */
