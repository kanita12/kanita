<?php

class	Employeesalary{
	public $user_id 	= 0;
	public $year 		= 0;
	public $month 		= 0;
	private $per_page = 0;
	private $page 		= 1;
	protected $ci;

	public function __construct(array $config = array())
	{
		$this->ci =& get_instance();

		if (count($config) > 0)
		{
			$this->initialize($config);
		}
	}
	public function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$method = 'set_'.$key;

				if (method_exists($this, $method))
				{
					$this->$method($val);
				}
				else
				{
					$this->$key = $val;
				}
			}
		}
		return $this;
	}
	public function set_user_id($value)
	{
		$this->user_id = $value;
	}
	public function set_year($value)
	{
		$this->year = $value;
	}
	public function set_month($value)
	{
		$this->month = $value;
	}
	public function summary_salary()
	{

	}
	/**
	 * แสดงทุกเดือนทั้งปี
	 * @return array
	 */
	public function history_salary()
	{
		$this->ci->load->model('Salary_pay_log_model');
		$query = $this->ci->Salary_pay_log_model->get_detail_by_year_and_month($this->user_id,$this->year,0);
		$query = $query->result_array();
		if( $query[0]['sapay_id'] == null )
		{
			return array();
		}

		return $query;
	}
	public function detail_summary_salary()
	{
		
	}
}