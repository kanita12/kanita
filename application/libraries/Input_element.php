<?php
class Input_element
{
	public function select_month( $selected = '', $id = '', $name = '', $class = '' )
	{
		if( $id === '' )
		{
			$id = 'select_month';
		}
		if( $name === '' )
		{
			$name = 'select_month';
		}
		if( $selected == '' )
		{
			$selected = 0;
		}

		$open_element = '<select name="'.$name.'" id="'.$id.'" class="'.$class.'">\
		<option value="0">เดือน</option>';
		$close_element = '</select>';
		$content_element = '';

		$month = $this->list_month_name_thai();

		for ($i=0; $i < count( $month ); $i++) 
		{ 

			if( $i == $selected-1 )
			{
				$content_element .= '<option value="'.$i.'" selected="selected">'.$month[$i].'</option>';
			}
			else
			{
				$content_element .= '<option value="'.$i.'">'.$month[$i].'</option>';
			}
		}

		echo $open_element,$content_element,$close_element;
	}

	public function select_year( $start = '', $end = '', $selected = '', $id = '', $name = '', $class = '' )
	{
		if( $id === '' )
		{
			$id = 'select_year';
		}
		if( $name === '' )
		{
			$name = 'select_year';
		}

		$open_element = '<select name="'.$name.'" id="'.$id.'" class="'.$class.'">\
		<option value="0">ปี</option>';
		$close_element = '</select>';
		$content_element = '';

		$year = $this->list_year_thai();

		foreach ($year as $key => $value) 
		{
			if( $key == $selected )
			{
				$content_element .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
			}
			else
			{
				$content_element .= '<option value="'.$key.'">'.$value.'</option>';
			}
		}

		echo $open_element,$content_element,$close_element;
	}

	private function month_name( $month = 1 )
	{
		$year = date("Y");
		return date('F', strtotime("$year-$month-01"));
	}

	private function list_month_name_thai( $month = 1 )
	{
		$array_month_name = array(	
										'มกราคม'
										,'กุมภาพันธ์'
										,'มีนาคม'
										,'เมษายน'
										,'พฤษภาคม'
										,'มิถุนายน'
										,'กรกฎาคม'
										,'สิงหาคม'
										,'กันยายน'
										,'ตุลาคม'
										,'พฤศจิกายน'
										,'ธันวาคม'
		);
		return $array_month_name;
	}

	private function list_year_thai( $start = 2500, $end = '' )
	{
		if( $end == '' )
		{
			$end = date("Y")+543;
		}

		$year = array();

		for ($i=$end; $i > $start; $i--) 
		{ 
			$year[$i-543] = $i;
			
		}
		return $year;
	}
}