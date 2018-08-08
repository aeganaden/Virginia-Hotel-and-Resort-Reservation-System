<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Model {

	public function fetch($table, $where = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$query = $this->db->get($table);
		return ( $query->num_rows() > 0) ? $query->result() : FALSE;
	}


	public function fetch_like($table,$column,$pattern, $where = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->like($column, $pattern);
		$query = $this->db->get($table);
		return ( $query->num_rows() > 0) ? $query->result() : FALSE;
	}


	public function fetchDateBetween($table,$start,$end) {
		$this->db->where('reservation_in BETWEEN "'. $start. '" and "'.  $end.'" AND reservation_status = 1'); 
		$query = $this->db->get($table);
		return ( $query->num_rows() > 0) ? $query->result() : FALSE;
	}


	public function fetch_or($table, $where = NULL, $orwhere = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
			$this->db->or_where($orwhere);
		}
		$query = $this->db->get($table);
		return ($query->num_rows() > 0) ? $query->result() : FALSE;
	}

	public function getSum($table,$column,$where = NULL)
	{
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
}

/* End of file Crud.php */
/* Location: ./application/models/Crud.php */
