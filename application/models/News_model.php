<?php
class News_model extends CI_Model
{
	private $table = 'news';
	private $table_type = 'news_type';
	private $table_user = 't_users';
	public function __construct()
	{
		parent::__construct();
	}
	public function count_all($newstype_id = 0, $keyword = "")
	{
		if($newstype_id > 0){ $this->db->where("news_newstype_id",$newstype_id); }
		if($keyword !== ""){ $this->db->like("news_topic",$keyword); }
		return $this->db->count_all_results($this->table);
	}
	public function get_list($limit, $start, $newstype_id = 0, $keyword = "",$show_all = FALSE)
	{
		$this->db->limit($limit,$start);
		$this->db->select("news_id,news_newstype_id,news_topic,news_detail".
			",date(news_show_start_date) news_show_start_date,date(news_show_end_date) news_show_end_date".
			",news_create_by,news_create_date,news_latest_update_by,news_latest_update_date,news_status,is_hot".
			",newstype_name"
		);
		$this->db->from($this->table);
		$this->db->where("news_status",1);
		if($newstype_id > 0)
		{
			$this->db->where("news_newstype_id",$newstype_id);
		}
		if($keyword !== ""){ $this->db->like("news_topic",$keyword); }
		if($show_all === FALSE)
		{
			$this->db->where("IF(news_show_start_date = '0000-00-00',NOW(),news_show_start_date) <= NOW()");
			$this->db->where("IF(news_show_end_date = '0000-00-00',NOW(),news_show_end_date) >= NOW()");
		}
		$this->db->join($this->table_type,"news_newstype_id = newstype_id","left");
		$this->db->order_by("news_id","DESC");
		return $this->db->get();
	}
	public function get_detail_by_id($news_id)
	{
		$this->db->select("news_id,news_newstype_id,news_topic,news_detail".
			",date(news_show_start_date) news_show_start_date,date(news_show_end_date) news_show_end_date".
			",news_create_by,news_create_date,news_latest_update_by,news_latest_update_date,news_status,is_hot"
		);
		$this->db->from($this->table);
		$this->db->where("news_status",1);
		$this->db->where("news_id",$news_id);
		return $this->db->get();
	}
	public function insert($data = array())
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function update($data,$where)
	{
		$this->db->where($where);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
}