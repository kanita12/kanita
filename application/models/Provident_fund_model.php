<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Provident_fund_model extends CI_Model{
	private $table = "t_provident_fund";
	private $fieldIdName = "pvdid";
	private $fieldStatusName = "pvdstatus";
	private $fieldStatusValue = "-999";

	public function __construct(){
		parent::__construct();
	}
	public function countAll($keyword = "")
	{
		$this->db->select($this->fieldIdName);
		$this->db->from($this->table);
		if(trim($keyword) !== "")
		{
			$this->db->like("pvdname",$keyword);
			$this->db->or_like("pvdcode",$keyword);
			$this->db->or_like("pvdratepercent",$keyword);
		}
		$this->db->where($this->fieldStatusName." <>",$this->fieldStatusValue);
		return $this->db->count_all_results();
	}
	public function getList($limit = 0,$start = 0,$keyword = ""){
		$this->db->limit($start,$limit);
		$this->db->select("pvdid,pvdcode,pvdname,pvddesc,pvdratepercent
			,pvdresponsibleman,pvdstatus");
		$this->db->from($this->table);
		$this->db->where($this->fieldStatusName." <>",$this->fieldStatusValue);
		if($keyword != ""){
			$this->db->group_start();
			$this->db->like("pvdname",$keyword);
			$this->db->or_like("pvdcode",$keyword);
			$this->db->or_like("pvdratepercent",$keyword);
			$this->db->group_end();
		}
		$query = $this->db->get();
		return $query;
	}
	public function getListForDropdownlist($firstRow="--เลือก--")
	{
		$this->db->select("pvdid,pvdcode,pvdname");
        $this->db->from($this->table);
        $this->db->where($this->fieldStatusName." <>",$this->fieldStatusValue);
        $query = $this->db->get();

        $dropDownList = array();
        $dropDownList[0] = $firstRow;
        foreach ($query->result_array() as $dropdown) 
        {
            $dropDownList[$dropdown["pvdid"]] = "[".$dropdown["pvdcode"]."] ".$dropdown["pvdname"];
        }
        
        return $dropDownList;
	}
	public function getDetailById($id){
		$this->db->select("pvdid,pvdcode,pvdname,pvddesc,pvdratepercent
			,pvdresponsibleman,pvdstatus");
		$this->db->from($this->table);
		$this->db->where($this->fieldStatusName." <>",$this->fieldStatusValue);
		$this->db->where("pvdid",$id);
		$query = $this->db->get();
		return $query;
	}
	public function insert($data){
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function update($data,$where){
		$this->db->where($where);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
	public function delete($where){
		$this->db->where($where);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
	public function deleteTypeChangeStatusById($id){
		$data = array();
		$data[$this->fieldStatusName] = $this->fieldStatusValue;
		$this->db->where($this->fieldIdName,$id);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
}
/* End of file Provident_fund_model.php */
/* Location: ./application/models/Provident_fund_model.php */