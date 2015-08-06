<?php
function asset_url()
{
	return FCPATH.'assets/';
}
function css_url() 
{
	return base_url().'assets/css/';
}
function js_url() 
{
	return base_url().'assets/js/';
}
function img_url() 
{
	return base_url().'assets/images/';
}
function mdl_url()
{
	return base_url().'assets/mdl/';
}
function vendor_url() 
{
	return base_url().'assets/vendor/';
}
function font_url()
{
	return base_url().'assets/font/';
}
function bootstrap_url()
{
	return base_url().'assets/bootstrap/';
}
function materialize_url()
{
	return base_url().'assets/materialize/';
}
function upload_url()
{
	return base_url().'uploads/';	
}
function upload_employee_url($user_id)
{
	return base_url().$this->config->item('upload_employee').'/'.$user_id;
}
