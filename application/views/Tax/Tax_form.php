<?php echo form_open(); ?>
<input type="hidden" id="hdEmpSalary" value="<?php echo $empDetail["EmpSalary"]; ?>">
<div class="section">
	<div class="input-field">
		<input type="text" id="inputTotalReduceTaxYear2" value="0">
		<label for="inputTotalReduceTaxYear2">จำนวนเงินที่ลดหย่อนได้ต่อปี</label>
	</div>
	<div class="input-field">
		<input type="text" id="inputTotalReduceTaxMonth2" value="0">
		<label for="inputTotalReduceTaxMonth2">จำนวนเงินที่ลดหย่อนได้ต่อเดือน</label>
	</div>
</div>
<div class="divider"></div>
<div class="row">
	<div class="col s12">
		<table class="bordered">
			<thead>
				<tr>
					<th style="width:30%;"></th>
					<th></th>
					<th>จำนวนเงินที่ลดหย่อนได้สูงสุด</th>
					<th>จำนวนเงินที่ลดหย่อนได้จริง</th>
				</tr>
			</thead>
			<?php foreach ($dataList as $row): ?>
				<tr>
					<td>
						<input type="checkbox" id="inputReduceTaxId_<?php echo $row["reducetax_id"]; ?>" name="inputReduceTaxId[]" 
						value="<?php echo $row["reducetax_id"]; ?>"
						<?php if(!empty($row["ert_reducetaxid"]) && $row["reducetax_id"] === $row["ert_reducetaxid"]): echo "checked"; endif; ?>/>
					    <label id="labelReduceTaxId_<?php echo $row["reducetax_id"]; ?>" for="inputReduceTaxId_<?php echo $row["reducetax_id"]; ?>"><?php echo $row["reducetax_name"]; ?></label>
					    <div id="divAlertTaxId_<?php echo $row["reducetax_id"]; ?>" class="red-text hide">
					    	
					    </div>
			    	</td>
			    	<td class="input-field near">
			    		<?php echo checkReduceInput($row,$empDetail["EmpSalary"]); ?>
			    	</td>
			    	<td>
			    		<?php echo checkReduceNotOver($row); ?>
			    	</td>
			    	<td>
			    		<div class="input-field">
			    			<input type="text" readonly="true" name="reduceTaxYear_<?php echo $row["reducetax_id"]; ?>" id="reduceTaxYear_<?php echo $row["reducetax_id"]; ?>" value="<?php echo calcReduceTaxYear($row,$empDetail["EmpSalary"]); ?>">
			    			<label for="reduceTaxYear_<?php echo $row["reducetax_id"]; ?>">ต่อปี</label>
			    		</div>
			    		<div class="input-field">
			    			<input type="text" readonly="true" name="reduceTaxMonth_<?php echo $row["reducetax_id"]; ?>" id="reduceTaxMonth_<?php echo $row["reducetax_id"]; ?>" value="<?php echo calcReduceTaxMonth($row,$empDetail["EmpSalary"]); ?>">
			    			<label for="reduceTaxMonth_<?php echo $row["reducetax_id"]; ?>">ต่อเดือน</label>
			    		</div>
			    		
			    		<!-- <span id="reduceTaxYear_<?php echo $row["reducetax_id"]; ?>"><?php echo calcReduceTaxYear($row,$empDetail["EmpSalary"]); ?></span>/ปี -->
			    		
			    		<!-- <span id="reduceTaxMonth_<?php echo $row["reducetax_id"]; ?>"><?php echo calcReduceTaxMonth($row,$empDetail["EmpSalary"]); ?></span>/เดือน
			    		 -->
			    		 
			    	</td>
		    	</tr>
			<?php endforeach ?>
		</table>
	</div>
</div>
<div class="divider"></div>
<div class="section">
	<div class="input-field">
		<input type="text" id="inputTotalReduceTaxYear" value="0">
		<label for="inputTotalReduceTaxYear">จำนวนเงินที่ลดหย่อนได้ต่อปี</label>
	</div>
	<div class="input-field">
		<input type="text" id="inputTotalReduceTaxMonth" value="0">
		<label for="inputTotalReduceTaxMonth">จำนวนเงินที่ลดหย่อนได้ต่อเดือน</label>
	</div>
</div>
<div class="divider"></div>
<div class="section">
	<div class="row">
        <div class="col s2">
            <input type="submit" onclick="return checkBeforeSubmit();" class="btn" value="บันทึก">
        </div>
        <div class="col s2 offset-s6 m2 offset-m8 right-align">
            <a href="<?php echo site_url('home') ?>" class="btn red lighten-1 right-align">ยกเลิก</a>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<?php
	function checkReduceInput($array,$salary){
		$id = $array["reducetax_id"];
		$reduceNotOverBy = "baht";
		$reduceNotOver = 0;
		$value = 0;

		if(!empty($array["ert_reducetaxid"]) && $array["reducetax_id"] === $array["ert_reducetaxid"]){
			$value = $array["ert_value"];
		}

		if($array["reducetax_notover_baht"] !== "-1"){
			$reduceNotOverBy = "baht";
		}else if($array["reducetax_notover_percent"] !== "-1"){
			$reduceNotOverBy = "percent";
		}

		if(trim($array["reducetax_input"]) !== ""){ //ส่งไป bind event มีการกำหนดว่า ห้ามใส่เกินเท่าไหร่ดว้ย บางข้อเป็นแบบ บาทเลย หรือเป็นแบบเปอร์เซนต์จากเงินเดือน
			return "<input type='number' id='inputValue_".$id."' name='inputValue[]' 
					value='".$value."'>
					<label for='inputValue_".$id."'>".$array["reducetax_input_label"]."</label>
					<input type='hidden' id='hdNotOverBy_".$id."' value='".$reduceNotOverBy."'>
					<input type='hidden' id='hdInputMath_".$id."' value='".$array["reducetax_input_math"]."'>
					<input type='hidden' id='hdInputMultiplied_".$id."' value='".$array["reducetax_input_multiplied"]."'>
					<input type='hidden' id='hdInputPercent_".$id."' value='".$array["reducetax_input_percent"]."'>
					<input type='hidden' id='hdWithTaxIdInputNotOverValue_".$id."' value='".$array["reducetax_withtaxid_input_notover_value"]."'>
					<input type='hidden' id='hdWithTaxId_".$id."' value='".$array["reducetax_withtaxid"]."'>
					<input type='hidden' id='hdWithTaxIdNotOver_".$id."' value='".$array["reducetax_withtaxid_notover_baht"]."'>
					";
					//WithTaxId ใช้คิดเงื่อนไขร่วมกับอันอื่นว่า ถ้าต้องคิดร่วมกับอันอื่นจะต้องไม่เกินอะไรเท่าไหร่บ้าง
		}else{
			return "<input type='number' id='inputValue_".$id."' name='inputValue[]' class='hide' value='-1'>
					<input type='hidden' id='hdWithTaxIdInputNotOverValue_".$id."' value='".$array["reducetax_withtaxid_input_notover_value"]."'>
					<input type='hidden' id='hdWithTaxId_".$id."' value='".$array["reducetax_withtaxid"]."'>
					<input type='hidden' id='hdWithTaxIdNotOver_".$id."' value='".$array["reducetax_withtaxid_notover_baht"]."'>
					";
		}
		//bind event เช็คค่าใส่ห้ามเกิน เท่าไหร่ลงไปที่ textbox ด้วย
	}
	//จำนวนเงินที่ลดหย่อนได้สูงสุด
	function checkReduceNotOver($array){
		$id = $array["reducetax_id"];
		$reduceBy = "baht";
		$reduce = 0;
		$reduceNotOverBy = "baht";
		$reduceNotOver = 0;
		$reducePer = 1;
		$sigmath = "";

		if($array["reducetax_baht"] !== "-1"){
			$reduceBy = "baht";
		}else if($array["reducetax_percent"] !== "-1"){
			$reduceBy = "percent";
		}
		$reduce = $array["reducetax_".$reduceBy];

		if($array["reducetax_notover_baht"] !== "-1" && $array["reducetax_notover_percent"] === "-1"){
			$reduceNotOverBy = "baht";
		}else if($array["reducetax_notover_baht"] === "-1" && $array["reducetax_notover_percent"] !== "-1"){
			$reduceNotOverBy = "percent";
			$sigmath = "%";
		}

		$reduceNotOver = $array["reducetax_notover_".$reduceNotOverBy] === "-1" ? "ลดหย่อนได้ตามอัตราจริง" : $array["reducetax_notover_".$reduceNotOverBy];
		if($reduceNotOverBy === "baht"){	
			$reduceNotOverMonth = is_numeric($reduceNotOver) ? ceil($reduceNotOver/12) : "ลดหย่อนได้ตามอัตราจริง";
		}else if($reduceNotOverBy === "percent"){
			$reduceNotOverMonth = is_numeric($reduceNotOver) ? number_format($reduceNotOver/12,2) : "ลดหย่อนได้ตามอัตราจริง";
		}
		
		$text = "<span id=\"reduceTaxNotOverYear_".$id."\">".$reduceNotOver.$sigmath."</span>/ปี
				<br>
				<span id=\"reduceTaxNotOverMonth_".$id."\">".$reduceNotOverMonth.$sigmath."</span>/เดือน";
		// if($reduceBy === "percent"){
		// 	$text .= "<input type='hidden' id='hdMultipliedPercent' value='".$reduce."'>";
		// }
		//ส่วนที่บอกว่า จะมี
		return $text;
	}
	//คำนวณอัตราที่สามารถลดหย่อนได้ต่อปี
	function calcReduceTaxYear($array,$salary){
		$reduceBy = "baht";
		$reduce = 0;
		$reduceNotOverBy = "baht";
		$reduceNotOver = 0;
		$reducePer = 1;

		if($array["reducetax_baht"] !== "-1"){
			$reduceBy = "baht";
		}else if($array["reducetax_percent"] !== "-1"){
			$reduceBy = "percent";
		}else{
			$reduceBy = "notover";
		}

		if($array["reducetax_notover_baht"] !== "-1"){
			$reduceNotOverBy = "baht";
		}else if($array["reducetax_notover_percent"] !== "-1"){
			$reduceNotOverBy = "percent";
		}

		if($array["reducetax_per"] === "month"){
			$reducePer = 12;
		}

		if($reduceBy !== "notover"){
			$reduce = $array["reducetax_".$reduceBy];
			$reduceNotOver = $array["reducetax_notover_".$reduceNotOverBy];
			if(!empty($array["ert_baht_year"])){
				return $array["ert_baht_year"];
			}else{
				if(trim($array["reducetax_input"]) === ""){
					if($reduceBy === "baht"){
						return $reduce;
					}else if($reduceBy === "percent"){
						$total = ceil(($salary*($reduce*$reducePer))/100);
						$total = $total > $reduceNotOver ? $reduceNotOver : $total;
						return $total === "-1" ? "ลดหย่อนได้ตามอัตราจริง" : $total;
					}
				}else{
					return 0;
				}
			}
		}else{
			if(!empty($array["ert_baht_year"])){
				return $array["ert_baht_year"];
			}else{
				if(trim($array["reducetax_input"]) === ""){
					return $array["reducetax_notover_".$reduceNotOverBy] === "-1" ? "ลดหย่อนได้ตามอัตราจริง" : $array["reducetax_notover_".$reduceNotOverBy];
				}else{
					return 0;
				}
			}
		}
	}
	//คำนวณอัตราที่สามารถลดหย่อนได้ต่อเดือน
	function calcReduceTaxMonth($array,$salary){
		$reduce = calcReduceTaxYear($array,$salary);

		if(is_numeric($reduce)){
			return ceil($reduce/12);
		}
		return $reduce;
	}
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("[id^='inputReduceTaxId_']").click(function(){
			var spliter = $(this).attr("id").split("_");
			sumReduceTotal("inputValue_"+spliter[1]);
		});
		bindEventAll();

		//sumReduceTotal("");
	});
	function bindEventAll()
	{
		$("[id^='inputValue_']").each(function(){
			obj = $(this);
			//ตอนสร้าง input มีการสร้าง onclick เพื่อ bind event เลยต้องเอาออก แล้วทำการ bind event อันใหม่ที่เหมาะสมเข้าไป
			obj.unbind('click').removeAttr('onclick');

			//bind event อันใหม่เข้าไป
			obj.keyup(function(){
				sumReduceTotal($(this).attr("id"));
			}).change(function(){
				if($.trim($(this).val()) === "" || $(this).val() < 0){
					$(this).val(0);
				}
			}).click(function(){
				if($(this).val() === 0){
					$(this).val("");
				}
				sumReduceTotal($(this).attr("id"));
			});
		});
		
	}
	function checkBeforeSubmit(){
		return true;
	}
	function sumReduceTotal(objId){
		var totalYear = 0;
		var totalMonth = 0;
		//typeNotOver,numNotOver,math,salary

		$("[id^='inputReduceTaxId_']:checked").each(function(){

			var spliter = $(this).attr("id").split("_");
			var id = spliter[1];
			var objInput = $("#inputValue_"+id);
			var value = parseInt(objInput.val()); //ค่าที่กรอก
			var objRealReduceYear = $("#reduceTaxYear_"+id); //ลดหย่อนได้จริงต่อปี
			var objRealReduceMonth = $("#reduceTaxMonth_"+id); //ลดหย่อนได้จริงต่อเดือน
			var typeNotOver = $("#hdNotOverBy_"+id).val();//ประเภทค่าสูงสุดที่ไม่ให้เกิน มีค่าเป็น baht หรือ percent
			var math = $("#hdInputMath_"+id).val();//ตัวคำนวณ เช่น คูณ หรือ บวก
			var inputMultiplied = $("#hdInputMultiplied_"+id).val();
			var inputPercent = $("#hdInputPercent_"+id).val();
			var reduceTaxNotOverYear = parseInt($("#reduceTaxNotOverYear_"+id).html());//ค่าสูงสุดไม่ให้เกินต่อปี
			var reduceTaxNotOverMonth = parseInt($("#reduceTaxNotOverMonth_"+id).html());//ค่าสูงสุดไม่ให้เกินต่อเดือน
			var salary = $("#hdEmpSalary").val();

			//WithTaxId ใช้คิดเงื่อนไขร่วมกับอันอื่นว่า ถ้าต้องคิดร่วมกับอันอื่นจะต้องไม่เกินอะไรเท่าไหร่บ้าง
			var withTaxIdInputNotOver = $("#hdWithTaxIdInputNotOverValue_"+id).val();
			var withTaxIdNotOver = parseInt($("#hdWithTaxIdNotOver_"+id).val());
			var withTaxId = $("#hdWithTaxId_"+id).val();

			if(value == "-1"){
				value = parseInt(objRealReduceYear.val());
			}

			//ถ้าค่าใน DB มีค่าตัวคูณอยู่ให้คูณค่าที่ใส่เข้ามาใน input ก่อน
			if(inputMultiplied != undefined && inputMultiplied !== "-1"){
				value = value * inputMultiplied;
			}
			//ถ้าค่าใน DB มีค่าตัวเปอร์เซ็นต์อยู่ให้คิดเปอร์เซ็นที่ใส่เข้ามาใน input ก่อน
			if(inputPercent != undefined && inputPercent !== "-1"){
				value = (value * inputPercent) / 100;
			}
			//ถ้าไม่มี input อันที่ไม่มี input จะมี class hide อยู่
			if(objInput.hasClass("hide") && withTaxId === "-1"){
				value = parseInt(objRealReduceYear.val());
			}else{
				//ถ้าตัว ลดหย่อนได้สูงสุดไม่เท่ากับตัวเลข
				if(!$.isNumeric($("#reduceTaxNotOverYear_"+id).html())){
					if(typeNotOver === "percent"){
						//field reducetax_notover_percent	
						//ไม่เกิน 10% ของเงินได้พึงประสงค์ = เงินเดือน * 10%
						if(value > ((salary * reduceTaxNotOverYear)/100)){
							value = (salary * reduceTaxNotOverYear)/100;
						}
					}
				}else{ //ถ้าจำนวนลดหย่อนสูงสุดเป็นตัวเลข
					if($("#inputValue_"+id).not(".hide").length || withTaxId !== "-1"){ //ถ้าจำนวนลดหย่อนไม่ว่าง แต่ว่ามีช่องให้กรอก เอาค่าจากที่ต้องกรอกมาใส่
						if(math === "*"){
							//ใช้กับ withTaxIdInputNotOver (Value)
							if(withTaxId !== "-1"){
								var spliter2 = withTaxId.split(",");
								var counter = 0;
								var withTaxIdName = "";
								var num = 0;
								var numValue = 0;
								for (var i = 0; i < spliter2.length; i++) {
									var checkbox = $("#inputReduceTaxId_"+spliter2[i]);

									if(checkbox.prop("checked")){
										numValue = $("#inputValue_"+spliter2[i]).val();
										counter += parseInt(numValue);
										withTaxIdName += $("#labelReduceTaxId_"+spliter2[i]).html()+",";

										//นับว่าถ้าค่าที่กำลัง count เกินค่าสูงสุดที่นับไว้หรือยังโดยอิงตัวเองเป็นหลักจะได้ว่า
										////ถ้า value ของเราตัวเดียวก็เกินแล้ว
										if(value >= withTaxIdInputNotOver){
											if("inputValue_"+id === objId){
												value = withTaxIdInputNotOver;
											}else{
												//ถ้าไม่ใช่ของตัวเอง แล้ว counter > ค่าที่กำหนดสูงสุด
												if(counter >= withTaxIdInputNotOver){
													num = $("#inputValue_"+spliter2[i]).val() - value
													if(num < 0){
														num = 0;
													}
													value = num;
												}else{ //ถ้าไม่ใช่ของตัวเองแล้ว counter < ค่าที่กำหนดสูงสุด ให้ยึดค่าช่องที่กรอกเป็นหลัก 
													value = value - numValue;
												}
											}
											break;
										}else if(counter >= withTaxIdInputNotOver){ //ถ้านับแล้วได้เกิน
											if("inputValue_"+id !== objId){
												num = withTaxIdInputNotOver - counter;
												if(num < 0){
													num = 0;
												}
												value = num;
											}
											break;
										}else if((counter+value) > withTaxIdInputNotOver){//ถ้านับแล้วยังไม่เกินแต่พอรวมกับค่าใหม่แล้วเกิน
											if("inputValue_"+id !== objId){ //ถ้ากำลังคีย์ตอนนี้อยู่ ต้องลดตัวอื่นเพราะอิงตอนคีย์อยู่นี้เป็นหลัก
												value = withTaxIdInputNotOver - counter;
												break;
											}
										}
									}
									
								};
							}
							if(typeNotOver === "percent"){
								value = (value * reduceTaxNotOverYear) / 100;
							}else{
								value = value * reduceTaxNotOverYear;
							}
						}else{
							//ใช้กับ withTaxIdNotOver (Baht)
							if(withTaxId !== "-1"){
								var spliter2 = withTaxId.split(",");
								var counter = 0;
								var withTaxIdName = "";
								var num = 0;
								var numValue = 0;
								

								for (var i = 0; i < spliter2.length; i++) {
									var withNotInput = false;
									var checkbox = $("#inputReduceTaxId_"+spliter2[i]);

									if(checkbox.prop("checked")){
										numValue = parseInt($("#inputValue_"+spliter2[i]).val());
										if(numValue === -1){
											numValue = parseInt($("#reduceTaxYear_"+spliter2[i]).val());
											withNotInput = true;
										}
										counter += parseInt(numValue);
										withTaxIdName += $("#labelReduceTaxId_"+spliter2[i]).html()+",";


										//นับว่าถ้าค่าที่กำลัง count เกินค่าสูงสุดที่นับไว้หรือยังโดยอิงตัวเองเป็นหลักจะได้ว่า
										////ถ้า value ของเราตัวเดียวก็เกินแล้ว
										if(value >= withTaxIdNotOver){
											value = withTaxIdNotOver;
											if("inputValue_"+id === objId){
												if(withNotInput === true){
													value = value - numValue;
													withNotInput = false;
												}else{
													value = withTaxIdNotOver;
													withNotInput = false;
												}
												
											}else{
												//ถ้าไม่ใช่ของตัวเอง แล้ว counter > ค่าที่กำหนดสูงสุด
												if(counter >= withTaxIdNotOver){
													num = value - $("#inputValue_"+spliter2[i]).val();
													if(num < 0){
														num = 0;
													}
													value = num;
													value = 0;
												}else{ //ถ้าไม่ใช่ของตัวเองแล้ว counter < ค่าที่กำหนดสูงสุด ให้ยึดค่าช่องที่กรอกเป็นหลัก 
													//value = value - numValue;
													value = value - counter;
													//value = value - counter + numValue;
												}
											}
											//break;
										}else if(counter >= withTaxIdNotOver){ //ถ้านับแล้วได้เกิน
											if("inputValue_"+id !== objId){ //ถ้ากำลังคีย์ตอนนี้อยู่ ต้องลดตัวอื่นเพราะอิงตอนคีย์อยู่นี้เป็นหลัก
												if(withNotInput == false && $("#inputValue_"+id).not(".hide").length){
													//num = withTaxIdNotOver - value;
													// num = withTaxIdNotOver - counter;
													// if(num < 0){
													// 	num = 0;
													// }
													// value = num;
													value = withTaxIdNotOver - counter;
												}else{
													if($("#inputValue_"+id).not(".hide").length){

														num = withTaxIdNotOver - counter;
														if(num < 0){
															num = 0;
														}
														value = num;
													}
													withNotInput = false;
												}
											}
										}else if((counter+value) >= withTaxIdNotOver){//ถ้านับแล้วยังไม่เกินแต่พอรวมกับค่าใหม่แล้วเกิน
											if("inputValue_"+id !== objId){ //ถ้ากำลังคีย์ตอนนี้อยู่ ต้องลดตัวอื่นเพราะอิงตอนคีย์อยู่นี้เป็นหลัก
												if(withNotInput == false && $("#inputValue_"+id).not(".hide").length){									
														value = withTaxIdNotOver - counter + numValue;	
												}else{
													if($("#inputValue_"+id).not(".hide").length){
														num = withTaxIdNotOver - counter;
														if(num < 0){
															num = 0;
														}
														value = num;
													}else
													{
														value = withTaxIdNotOver - counter;	
													}
													withNotInput = false;
												}
											}else{
												 if(withNotInput == true){//ถ้ากำลังคีย์อยู่แต่ตัวอื่นเป็น checkbox ค่าเฉยๆ ไม่มีให้กรอก ให้ลดตัวเองลง
													 value = (withTaxIdNotOver - counter);
													 withNotInput = false;
												}else{
													value = (withTaxIdNotOver - counter) + numValue;
													counter = counter - numValue;												
												}
											}
										}
									}

								};
								if(counter < 1 && value >= withTaxIdNotOver){
									value = withTaxIdNotOver;
								}
							}else{
								if(value > reduceTaxNotOverYear){
									value = reduceTaxNotOverYear;
								}
							}
						}
					}else{
						value = reduceTaxNotOverYear;
					}
				}
			}
			totalYear = totalYear + value;
			totalMonth = Math.ceil(totalYear/12);

			//if(!$("#"+objId).hasClass("hide")){
				objRealReduceYear.val(value);
				objRealReduceMonth.val(Math.ceil(value/12));
			//}
			
		});
	
		$("#inputTotalReduceTaxYear").val(totalYear);
		$("#inputTotalReduceTaxMonth").val(totalMonth);
		$("#inputTotalReduceTaxYear2").val(totalYear);
		$("#inputTotalReduceTaxMonth2").val(totalMonth);
	}
</script>