<?php
class Newstype_model extends CI_Model
{
	private $table = "news_type";
	public function __construct()
	{
		parent::__construct();
	}
	public function get_list_for_dropdownlist()
	{
		$dropdownlist = array("0"=>"--เลือก--");

		$this->db->select("newstype_id,newstype_name");
		$this->db->from($this->table);
		$this->db->where("newstype_status",1);
		$query = $this->db->get();

		$query = $query->result_array();
		foreach ($query as $row) 
		{
			$dropdownlist[$row["newstype_id"]] = $row["newstype_name"];	
		}
		
		return $dropdownlist;
	}
}