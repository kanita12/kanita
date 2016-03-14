$(document).ready(function() {

	var section = $("#ddlSection").val();
	var emp_id = $("#hdEmpID").val();
	var site_url = $("#hd_site_url").val();
	//set input only numeric
	 $("#txtSalary,#txtIDCard,#txtHeight,#txtWeight").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	//limit text

	
	$("#txtTelePhone,#txtMobilePhone,#txtTelePhoneFriend,#txtMobilePhoneFriend,#txtTelePhoneFather,#txtMobilePhoneFather,#txtTelePhoneMother,#txtMobilePhoneMother").keydown(function(e){
		// Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
		else if($(this).val().length > 9)
		{
			e.preventDefault();
		}
	});
	$("#txtIDCard").keydown(function(e){
		// Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
		else if($(this).val().length > 12)
		{
			e.preventDefault();
		}
	});
	$("#txtNumberOfChildren,#txtNumberOfBrother").keydown(function(e){
		// Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
		else if($(this).val().length > 0)
		{
			e.preventDefault();
		}
	});
	$("#txtHeight,#txtWeight").keydown(function(e){
		// Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
		else if($(this).val().length > 2)
		{
			e.preventDefault();
		}
	});
	//menu collection add/remove class active
	$(".collection > .collection-item").click(function(){
			activeCollection(this);
	});
	//left menu for scroll bottom position fix
	var menu = $('#menu');
	var menu_width = menu.width();
	$(document).scroll(function(){
        if ( $(this).scrollTop() >= $(window).height() - menu.height() ){
        menu.css("position","fixed").css("top",50).css("width",menu_width);
        } else {
        menu.css("position","relative").css("top",0);
        }
	});
	//check validation_errors if have then alert
	var validation_errors = $("#hd_validation_errors").val();
	if(validation_errors != "")
	{
		swal({
			title: "ผิดพลาด",
			html: validation_errors,
			type: "error"
		});
	}
	//set date picker
	$('#txtStartWorkDate,#txtSuccessTrialWorkDate').datetimepicker({
		timepicker:false,
		format:'d/m/Y',
		lang:'th',
		closeOnDateSelect:true
	});
	//dropdownlist
	if( section !== "0" )
	{
		if( $("#hd_emp_headman_level_1").val() !== "" )
		{
			var thisval = $("#hd_emp_headman_level_1").val();
			$.ajax({
				type : "POST",
				url : site_url+"hr/AjaxEmployee/get_list_headman/"+section+"/"+emp_id,
				async:false,
				success : function(data) {
					$("#ddlHeadman_level_1").html(data).val(thisval); 

					$.ajax({
						type : "POST",
						url : site_url+"hr/AjaxEmployee/get_list_headman/" + section+"/"+emp_id+"/"+thisval,
						async:false,
						success : function(data) {
							$("[id$='ddlHeadman_level_2']").html(data);
						}
					});
				}
			});

			if( $("#hd_emp_headman_level_2").val() !== "" )
			{
				var thisval2 = $("#hd_emp_headman_level_2").val();
				$("#ddlHeadman_level_2").val(thisval2); 

				$.ajax({
					type : "POST",
					url : site_url+"hr/AjaxEmployee/get_list_headman/" +section+"/"+emp_id+"/"+thisval+"/"+thisval2,
					success : function(data) {
						$("[id$='ddlHeadman_level_3']").html(data);
					}
				});

				if( $("#hd_emp_headman_level_2").val() !== "" )
				{
					var thisval3 = $("#hd_emp_headman_level_3").val();
					$("#ddlHeadman_level_3").val(thisval3); 
				}
			}

		}
		
	}
	$("[id$='ddlAddressProvince']").change(function() {
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListAmphur/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressAmphur']").html(data);
				$('#ddlAddressAmphur').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
				$("[id$='ddlAddressAmphur']").change();
			}
		});
	});
	$("[id$='ddlAddressAmphur']").change(function() {
		var provinceID = $("[id$='ddlAddressProvince']").val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListDistrict/" + provinceID + "/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressDistrict']").html(data);
				$('#ddlAddressDistrict').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
				$("[id$='ddlAddressDistrict']").change();
			}
		});
	});
	$("[id$='ddlAddressDistrict']").change(function() {
		var provinceID = $("[id$='ddlAddressProvince']").val();
		var amphurID = $("[id$='ddlAddressAmphur']").val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListZipcode/" + provinceID + "/" + amphurID + "/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressZipcode']").html(data);
				$('#ddlAddressZipcode').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
			}
		});
	});

	$("[id$='ddlAddressProvinceHouseReg']").change(function() {
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListAmphur/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressAmphurHouseReg']").html(data);
				$('#ddlAddressAmphurHouseReg').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
				$("[id$='ddlAddressAmphurHouseReg']").change();
			}
		});
	});
	$("[id$='ddlAddressAmphurHouseReg']").change(function() {
		var provinceID = $("[id$='ddlAddressProvinceHouseReg']").val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListDistrict/" + provinceID + "/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressDistrictHouseReg']").html(data);
				$('#ddlAddressDistrictHouseReg').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
				$("[id$='ddlAddressDistrictHouseReg']").change();
			}
		});
	});
	$("[id$='ddlAddressDistrictHouseReg']").change(function() {
		var provinceID = $("[id$='ddlAddressProvinceHouseReg']").val();
		var amphurID = $("[id$='ddlAddressAmphurHouseReg']").val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListZipcode/" + provinceID + "/" + amphurID + "/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressZipcodeHouseReg']").html(data);
				$('#ddlAddressZipcodeHouseReg').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
			}
		});
	});

	$("[id$='ddlAddressProvinceFather']").change(function() {
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListAmphur/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressAmphurFather']").html(data);
				$('#ddlAddressAmphurFather').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
				$("[id$='ddlAddressAmphurFather']").change();
			}
		});
	});
	$("[id$='ddlAddressAmphurFather']").change(function() {
		var provinceID = $("[id$='ddlAddressProvinceFather']").val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListDistrict/" + provinceID + "/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressDistrictFather']").html(data);
				$('#ddlAddressDistrictFather').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
				$("[id$='ddlAddressDistrictFather']").change();
			}
		});
	});
	$("[id$='ddlAddressDistrictFather']").change(function() {
		var provinceID = $("[id$='ddlAddressProvinceFather']").val();
		var amphurID = $("[id$='ddlAddressAmphurFather']").val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListZipcode/" + provinceID + "/" + amphurID + "/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressZipcodeFather']").html(data);
				$('#ddlAddressZipcodeFather').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
			}
		});
	});

	$("[id$='ddlAddressProvinceMother']").change(function() {
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListAmphur/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressAmphurMother']").html(data);
				$('#ddlAddressAmphurMother').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
				$("[id$='ddlAddressAmphurMother']").change();
			}
		});
	});
	$("[id$='ddlAddressAmphurMother']").change(function() {
		var provinceID = $("[id$='ddlAddressProvinceMother']").val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListDistrict/" + provinceID + "/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressDistrictMother']").html(data);
				$('#ddlAddressDistrictMother').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
				$("[id$='ddlAddressDistrictMother']").change();
			}
		});
	});
	$("[id$='ddlAddressDistrictMother']").change(function() {
		var provinceID = $("[id$='ddlAddressProvinceMother']").val();
		var amphurID = $("[id$='ddlAddressAmphurMother']").val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListZipcode/" + provinceID + "/" + amphurID + "/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressZipcodeMother']").html(data);
				$('#ddlAddressZipcodeMother').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
			}
		});
	});


	$("[id$='ddlAddressProvinceFriend']").change(function() {
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListAmphur/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressAmphurFriend']").html(data);
				$('#ddlAddressAmphurFriend').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
				$("[id$='ddlAddressAmphurFriend']").change();
			}
		});
	});
	$("[id$='ddlAddressAmphurFriend']").change(function() {
		var provinceID = $("[id$='ddlAddressProvinceFriend']").val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListDistrict/" + provinceID + "/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressDistrictFriend']").html(data);
				$('#ddlAddressDistrictFriend').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
				$("[id$='ddlAddressDistrictFriend']").change();
			}
		});
	});
	$("[id$='ddlAddressDistrictFriend']").change(function() {
		var provinceID = $("[id$='ddlAddressProvinceFriend']").val();
		var amphurID = $("[id$='ddlAddressAmphurFriend']").val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListZipcode/" + provinceID + "/" + amphurID + "/" + $(this).val(),
			success : function(data) {
				$("[id$='ddlAddressZipcodeFriend']").html(data);
				$('#ddlAddressZipcodeFriend').material_select();
				$("select").closest('.input-field').children('span.caret').remove();
			}
		});
	});

	$("[id$='ddlDepartment']").change(function() {
		var ID = $(this).val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListSection/" + ID,
			success : function(data) {
				$("[id$='ddlSection']").html(data).material_select();
				$("select").closest('.input-field').children('span.caret').remove();
			}
		});
	});
	$("[id$='ddlSection']").change(function() {
		var ID = $(this).val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListUnit/" + ID,
			success : function(data) {
				$("[id$='ddlUnit']").html(data).material_select();
				$("select").closest('.input-field').children('span.caret').remove();
			}
		});
	});
	$("[id$='ddlUnit']").change(function() {
		var ID = $(this).val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/getListGroup/" + ID,
			success : function(data) {
				$("[id$='ddlGroup']").html(data).material_select();
				$("select").closest('.input-field').children('span.caret').remove();
			}
		});
	});

	$("[id$='ddlSection']").change(function() {
		var ID = $(this).val();
		$.ajax({
			type : "POST",
			url : site_url+"hr/AjaxEmployee/get_list_headman/" + ID+"/"+emp_id,
			success : function(data) {
				$("[id$='ddlHeadman_level_1']").html(data).material_select();
				$("select").closest('.input-field').children('span.caret').remove();
			}
		});

	});

	$('#ddlHeadman_level_1').change(function()
	{
		var ID = $('#ddlSection').val();
		
		if( $(this).val() != 0 )
		{
			$.ajax({
				type : "POST",
				url : site_url+"hr/AjaxEmployee/get_list_headman/" + ID+"/"+emp_id+"/"+$(this).val(),
				success : function(data) {
					$("[id$='ddlHeadman_level_2']").html(data).material_select();
					$("select").closest('.input-field').children('span.caret').remove();
				}
			});
		}
	});
	$('#ddlHeadman_level_2').change(function()
	{
		var ID = $('#ddlSection').val();
		if( $(this).val() != 0 )
		{
			$.ajax({
				type : "POST",
				url : site_url+"hr/AjaxEmployee/get_list_headman/" + ID+"/"+emp_id+"/"+$('#ddlHeadman_level_1').val()+"/"+$(this).val(),
				success : function(data) {
					$("[id$='ddlHeadman_level_3']").html(data);
					$('#ddlHeadman_level_3').material_select();
					$("select").closest('.input-field').children('span.caret').remove();
				}
			});
		}
	});

	gen_history_study_template();
	gen_history_work_template();
});


function activeCollection(obj)
{
	obj = $(obj);
	var now_active = "";
	$(".collection > a").each(function(){
		if($(this).hasClass("active"))
		{
			now_active = $(this).attr("href");
		}
		$(this).removeClass("active");
	});
	
	$(".collection > a[href='"+obj.attr("href")+"']").addClass("active");

}
function check_before_submit() 
{

	var empID 			= $("#txtEmpID").val();
	var user 			= $("#txtUsername").val();
	var email 			= $("#txtEmail").val();
	var idcard 			= $("#txtIDCard").val();
	var msg = '';
	$("input[type=text],input[type=select]").click();
	
	if(empID == '')
	{
		msg += '- รหัสพนักงาน';
	}
	if(user == '')
	{
		msg += '<br/>- Username';
	}
	if(email == '')
	{
		msg += '<br/>- Email';
	}
	if(idcard == '')
	{
		msg += '<br/>- รหัสบัตรประชาขน';
	}

	if(msg != '')
	{
		swal({
			title: 'กรุณากรอกข้อมูลต่อไปนี้',
			html: msg,
			type: 'error'
		});
		return false;
	}
	else
	{
		return true;
	}

}


function gen_option_day_for_dropdown(set_present)
{
	var current = (new Date).getDate();
	var text = '';
	for (var i = 1; i < 32; i++) 
	{
		if( set_present === true )
		{
			if( i === current )
			{
				text += "<option value='"+i+"' selected='selected'>"+i+"</option>";
			}
			else
			{
				text += "<option value='"+i+"'>"+i+"</option>";
			}
		}
		else
		{
			if( typeof(set_present) != "undefined" && set_present !== null )
			{
				if( i === parseInt(set_present) )
				{

					text += "<option value='"+i+"' selected='selected'>"+i+"</option>";
				}
				else
				{
					text += "<option value='"+i+"'>"+i+"</option>";
				}
			}
			else
			{
				text += "<option value='"+i+"'>"+i+"</option>";
			}	
		}
	};
	return text;
}
function gen_option_month_for_dropdown(set_present)
{
	var current = (new Date).getMonth();
	var month = ['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
				'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
	var text = '';
	for (var i = 1; i < 13; i++) 
	{
		if( set_present === true )
		{
			if( i === current )
			{
				text += "<option value='"+i+"' selected='selected'>"+month[i]+"</option>";
			}
			else
			{
				text += "<option value='"+i+"'>"+month[i]+"</option>";
			}
		}
		else
		{
			if( typeof(set_present) != "undefined" && set_present !== null )
			{
				if( i === parseInt(set_present) )
				{

					text += "<option value='"+i+"' selected='selected'>"+month[i]+"</option>";
				}
				else
				{
					text += "<option value='"+i+"'>"+month[i]+"</option>";
				}
			}
			else
			{
				text += "<option value='"+i+"'>"+month[i]+"</option>";
			}	
		}
	};
	return text;
}
function gen_option_year_for_dropdown(set_present)
{
	var now_year = (new Date).getFullYear()+543;
	var text = '';
	for (var i = now_year; i > now_year-100; i--) 
	{
		if( set_present === true )
		{
			if( i === now_year )
			{
				text += "<option value='"+i+"' selected='selected'>"+i+"</option>"
			}
			else
			{
				text += "<option value='"+i+"'>"+i+"</option>"
			}
		}
		else
		{
			if( typeof(set_present) != "undefined" && set_present !== null )
			{
				if( i === ( parseInt(set_present)+543 ) )
				{

					text += "<option value='"+i+"' selected='selected'>"+i+"</option>";
				}
				else
				{
					text += "<option value='"+i+"'>"+i+"</option>";
				}
			}
			else
			{
				text += "<option value='"+i+"'>"+i+"</option>";
			}	
		}
		
	};
	return text;
}
function gen_education_level_for_dropdown(id)
{
	var education_level = {
		0:"--เลือก--"
		,1:"ระดับประถมศึกษา"
		,2:"ระดับมัธยมศึกษา"
		,3:"ระดับอาชีวะ หรือวิชาชีพ"
		,4:"ระดับวิทยาลัย"
		,5:"ระดับมหาวิทยาลัย"
		};
	var text = '';
	$.each(education_level,function(key,value){
		if( key === id )
		{
			text += "<option value='"+key+"' selected='selected'>"+value+"</option>"
		}
		else
		{
			text += "<option value='"+key+"'>"+value+"</option>"
		}
	});
	return text;
}
function gen_history_study_template()
{
	var text = '';
	var i = $("[id^='history_study_number_']").size();
	var data_id = $("[id^='hd_history_study_id_']");
	if( i < 1 && data_id.size() > 0 )
	{
		var academy;
		var education_level;
		var bachelor
		var major;
		var desc;
		var year_start;
		var year_end;
		var grade_avg;
		var degree;

		for (var i = 1; i <= data_id.size(); i++) 
		{
			academy         = $("#hd_history_study_academy_"+i).val();
			education_level = $("#hd_history_study_education_level_"+i).val();
			bachelor = $("#hd_history_study_bachelor_"+i).val();
			major           = $("#hd_history_study_major_"+i).val();
			desc            = $("#hd_history_study_desc_"+i).val();
			year_start       = $("#hd_history_study_year_start_"+i).val();
			year_end         = $("#hd_history_study_year_end_"+i).val();
			grade_avg = $("#hd_history_study_grade_avg_"+i).val();
			degree = $("#hd_history_study_degree_"+i).val();

			text 	= 	"<div class='card'>\
						<div class='card-content'>\
							<div id='history_study_number_"+i+"'>\
								<div class='row'>\
									<div class='input-field col s12'>\
										<input type='text' id='history_study_academy_"+i+"' name='history_study_academy[]' \
										value='"+academy+"'>\
										<label for='history_study_academy_"+i+"'>ชื่อสถาบันการศึกษา</label>\
									</div>\
								</div>\
								<div class='row'>\
									<div class='input-field col s6'>\
										<select id='history_study_education_level_"+i+"' name='history_study_education_level[]'>\
											"+gen_education_level_for_dropdown(education_level)+"\
										</select>\
										<label for='history_study_education_level_"+i+"'>ระดับการศึกษา</label>\
									</div>\
									<div class='input-field col s6'>\
										<input type='text' id='history_study_degree_"+i+"' name='history_study_degree[]' \
										value='"+degree+"'>\
										<label for='history_study_degree_"+i+"'>วุฒิการศึกษา</label>\
									</div>\
									<div class='input-field col s6'>\
										<input type='text' id='history_study_bachelor_"+i+"' name='history_study_bachelor[]' \
										value='"+bachelor+"'>\
										<label for='history_study_bachelor_"+i+"'>คณะ</label>\
									</div>\
									<div class='input-field col s6'>\
										<input type='text' id='history_study_major_"+i+"' name='history_study_major[]' \
										value='"+major+"'>\
										<label for='history_study_major_"+i+"'>สาขาวิชา</label>\
									</div>\
								</div>\
								<div class='row'>\
									<div class='input-field col s6'>\
										<select id='history_study_year_start_"+i+"' name='history_study_year_start[]'>\
											"+gen_option_year_for_dropdown(year_start)+"\
										</select>\
										<label for='history_study_year_start_"+i+"'>ปีการศึกษา</label>\
									</div>\
									<div class='input-field col s6'>\
										<select id='history_study_year_end_"+i+"' name='history_study_year_end[]'>\
											"+gen_option_year_for_dropdown(year_end)+"\
										</select>\
										<label for='history_study_year_end_"+i+"'>จนถึง</label>\
									</div>\
									<div class='input-field col s12'>\
										<input type='text' id='history_study_grade_avg_"+i+"' name='history_study_grade_avg[]' \
										value="+grade_avg+">\
										<label for='history_study_grade_avg_"+i+"'>เกรดเฉลี่ย</label>\
									</div>\
									<div class='input-field col s12'>\
										<textarea id='history_study_desc_"+i+"' name='history_study_desc[]' class='materialize-textarea'>"+desc+"</textarea>\
										<label for='history_study_desc_"+i+"'>คำอธิบาย</label>\
									</div>\
								</div>\
							</div>\
						</div>\
					<div>\
					";
			$('#history_study_list').append(text);
			$("#history_study_number_"+i+" select").material_select();
		}
	}
	else
	{
		i++;
		
		text 	= 	"<div class='card'>\
						<div class='card-content'>\
							<div id='history_study_number_"+i+"'>\
								<div class='row'>\
									<div class='input-field col s12'>\
										<input type='text' id='history_study_academy_"+i+"' name='history_study_academy[]'>\
										<label for='history_study_academy_"+i+"'>ชื่อสถาบันการศึกษา</label>\
									</div>\
								</div>\
								<div class='row'>\
									<div class='input-field col s6'>\
										<select id='history_study_education_level_"+i+"' name='history_study_education_level[]'>\
											"+gen_education_level_for_dropdown()+"\
										</select>\
										<label for='history_study_education_level_"+i+"'>ระดับการศึกษา</label>\
									</div>\
									<div class='input-field col s6'>\
										<input type='text' id='history_study_degree_"+i+"' name='history_study_degree[]'>\
										<label for='history_study_degree_"+i+"'>วุฒิการศึกษา</label>\
									</div>\
									<div class='input-field col s6'>\
										<input type='text' id='history_study_bachelor_"+i+"' name='history_study_bachelor[]'>\
										<label for='history_study_bachelor_"+i+"'>คณะ</label>\
									</div>\
									<div class='input-field col s6'>\
										<input type='text' id='history_study_major_"+i+"' name='history_study_major[]'>\
										<label for='history_study_major_"+i+"'>สาขาวิชา</label>\
									</div>\
								</div>\
								<div class='row'>\
									<div class='input-field col s6'>\
										<select id='history_study_year_start_"+i+"' name='history_study_year_start[]'>\
											"+gen_option_year_for_dropdown()+"\
										</select>\
										<label for='history_study_year_start_"+i+"'>ปีการศึกษา</label>\
									</div>\
									<div class='input-field col s6'>\
										<select id='history_study_year_end_"+i+"' name='history_study_year_end[]'>\
											"+gen_option_year_for_dropdown()+"\
										</select>\
										<label for='history_study_year_end_"+i+"'>จนถึง</label>\
									</div>\
									<div class='input-field col s12'>\
										<input type='text' id='history_study_grade_avg_"+i+"' name='history_study_grade_avg[]'>\
										<label for='history_study_grade_avg_"+i+"'>เกรดเฉลี่ย</label>\
									</div>\
									<div class='input-field col s12'>\
										<textarea id='history_study_desc_"+i+"' name='history_study_desc[]' class='materialize-textarea'></textarea>\
										<label for='history_study_desc_"+i+"'>คำอธิบาย</label>\
									</div>\
								</div>\
							</div>\
						</div>\
					<div>\
					";
		$('#history_study_list').append(text);
		$("#history_study_number_"+i+" select").material_select();
		var obj_card = $("#history_study_number_"+i).parent().parent();
		obj_card.effect("highlight", {}, 2000);
	}
}
function gen_history_work_template()
{
	var text = '';
	var i = $("[id^='history_work_number_']").size();
	var data_id = $("[id^='hd_history_work_id_']");
	if( i < 1 && data_id.size() > 0 )
	{
		var company;
		var position;
		var district;
		var desc;
		var date_from;
		var date_from_day;
		var date_from_month;
		var date_from_year;
		var date_to;
		var date_to_day;
		var date_to_month;
		var date_to_year;

		for (var i = 1; i <= data_id.size(); i++) 
		{
			company         = $("#hd_history_work_company_"+i).val();
			position        = $("#hd_history_work_position_"+i).val();
			district        = $("#hd_history_work_district_"+i).val();
			desc            = $("#hd_history_work_desc_"+i).val();
			date_from       = $("#hd_history_work_date_from_"+i).val().split("-");
			date_from_day   = date_from[2];
			date_from_month = date_from[1];
			date_from_year  = date_from[0];
			date_to         = $("#hd_history_work_date_to_"+i).val().split("-");
			date_to_day     = date_to[2];
			date_to_month   = date_to[1];
			date_to_year    = date_to[0];
			text 	= 	"<div class='card'>\
							<div class='card-content'>\
								<div id='history_work_number_"+i+"'>\
									<div class='row'>\
										<div class='input-field'>\
											<input type='text' id='history_work_company_"+i+"' name='history_work_company[]' value='"+company+"'>\
											<label for='history_work_company_"+i+"'>บริษัท</label>\
										</div>\
										<div class='input-field'>\
											<input type='text' id='history_work_position_"+i+"' name='history_work_position[]' value='"+position+"'>\
											<label for='history_work_position_"+i+"'>ตำแหน่งงาน</label>\
										</div>\
										<div class='input-field'>\
											<input type='text' id='history_work_district_"+i+"' name='history_work_district[]' value='"+district+"'>\
											<label for='history_work_district_"+i+"'>เมือง</label>\
										</div>\
										<div class='input-field'>\
											<textarea id='history_work_desc_"+i+"' name='history_work_desc[]' class='materialize-textarea'>"+desc+"</textarea>\
											<label for='history_work_desc_"+i+"'>คำอธิบาย</label>\
										</div>\
									</div>\
									<div class='row'>\
										<div class='input-field col s4'>\
											<select id='history_work_date_from_day_"+i+"' name='history_work_date_from_day[]'>\
												"+gen_option_day_for_dropdown(date_from_day)+"\
											</select>\
											<label for='history_work_date_from_day_"+i+"'>ตั้งแต่</label>\
										</div>\
										<div class='input-field col s4'>\
											<select id='history_work_date_from_month_"+i+"' name='history_work_date_from_month[]'>\
												"+gen_option_month_for_dropdown(date_from_month)+"\
											</select>\
										</div>\
										<div class='input-field col s4'>\
											<select id='history_work_date_from_year_"+i+"' name='history_work_date_from_year[]'>\
												"+gen_option_year_for_dropdown(date_from_year)+"\
											</select>\
										</div>\
									</div>\
									<div class='row'>\
										<div class='input-field col s4'>\
											<select id='history_work_date_to_day_"+i+"' name='history_work_date_to_day[]'>\
												"+gen_option_day_for_dropdown(date_to_day)+"\
											</select>\
											<label for='history_work_date_to_day_"+i+"'>จนถึง</label>\
										</div>\
										<div class='input-field col s4'>\
											<select id='history_work_date_to_month_"+i+"' name='history_work_date_to_month[]'>\
												"+gen_option_month_for_dropdown(date_to_month)+"\
											</select>\
										</div>\
										<div class='input-field col s4'>\
											<select id='history_work_date_to_year_"+i+"' name='history_work_date_to_year[]'>\
												"+gen_option_year_for_dropdown(date_to_year)+"\
											</select>\
										</div>\
									</div>\
								</div>\
							</div>\
						<div>\
						";
			$('#history_work_list').append(text);
			$("#history_work_number_"+i+" select").material_select();
		}
	}
	else
	{
		i++;
		text 	= 	"<div class='card'>\
						<div class='card-content'>\
							<div id='history_work_number_"+i+"'>\
								<div class='row'>\
									<div class='input-field'>\
										<input type='text' id='history_work_company_"+i+"' name='history_work_company[]'>\
										<label for='history_work_company_"+i+"'>บริษัท</label>\
									</div>\
									<div class='input-field'>\
										<input type='text' id='history_work_position_"+i+"' name='history_work_position[]'>\
										<label for='history_work_position_"+i+"'>ตำแหน่งงาน</label>\
									</div>\
									<div class='input-field'>\
										<input type='text' id='history_work_district_"+i+"' name='history_work_district[]'>\
										<label for='history_work_district_"+i+"'>เมือง</label>\
									</div>\
									<div class='input-field'>\
										<textarea id='history_work_desc_"+i+"' name='history_work_desc[]' class='materialize-textarea'></textarea>\
										<label for='history_work_desc_"+i+"'>คำอธิบาย</label>\
									</div>\
								</div>\
								<div class='row'>\
									<div class='input-field col s4'>\
										<select id='history_work_date_from_day_"+i+"' name='history_work_date_from_day[]'>\
											"+gen_option_day_for_dropdown()+"\
										</select>\
										<label for='history_work_date_from_day_"+i+"'>ตั้งแต่</label>\
									</div>\
									<div class='input-field col s4'>\
										<select id='history_work_date_from_month_"+i+"' name='history_work_date_from_month[]'>\
											"+gen_option_month_for_dropdown()+"\
										</select>\
									</div>\
									<div class='input-field col s4'>\
										<select id='history_work_date_from_year_"+i+"' name='history_work_date_from_year[]'>\
											"+gen_option_year_for_dropdown()+"\
										</select>\
									</div>\
								</div>\
								<div class='row'>\
									<div class='input-field col s4'>\
										<select id='history_work_date_to_day_"+i+"' name='history_work_date_to_day[]'>\
											"+gen_option_day_for_dropdown()+"\
										</select>\
										<label for='history_work_date_to_day_"+i+"'>จนถึง</label>\
									</div>\
									<div class='input-field col s4'>\
										<select id='history_work_date_to_month_"+i+"' name='history_work_date_to_month[]'>\
											"+gen_option_month_for_dropdown()+"\
										</select>\
									</div>\
									<div class='input-field col s4'>\
										<select id='history_work_date_to_year_"+i+"' name='history_work_date_to_year[]'>\
											"+gen_option_year_for_dropdown()+"\
										</select>\
									</div>\
								</div>\
							</div>\
						</div>\
					<div>\
					";
		$('#history_work_list').append(text);
		$("#history_work_number_"+i+" select").material_select();
		var obj_card = $("#history_work_number_"+i).parent().parent();
		obj_card.effect("highlight", {}, 2000);
	}
}
function selectShiftwork(id)
{
	var name = $("#allShiftworkList #shiftworkName_"+id).html();


	var tr = "<tr>";
	tr += "<input type=\"hidden\" name=\"hdShiftworkId[]\" value=\""+id+"\">";
	tr += "<td id=\"shiftworkName_"+id+"\">"+name+"</td>";
	tr += "<td class=\"right-align\"><a href=\"javascript:void(0);\" class=\"btn red\" onclick=\"removeShiftwork('"+id+"');\">ลบ</a></td>";
	tr += "</tr>";

	$("#selectedShiftworkList").append(tr);

	//ซ่อนรายชื่อนี้จากรายการ
	$("#allShiftworkList #shiftworkName_"+id).parent().addClass("hide");
}
function removeShiftwork(id)
{
	var tr = $("#selectedShiftworkList #shiftworkName_"+id).parent();
	tr.remove();

	//คืนรายชื่อนี้ไปสู่รายการ
	$("#allShiftworkList #shiftworkName_"+id).parent().removeClass("hide");
}