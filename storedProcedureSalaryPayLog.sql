DELIMITER $$
/*
	- หาว่าตอนนี้มีเงินเดือนเท่าไหร่
	- ได้โอทีเท่าไหร่ (คิดยังไงวะ)
	- มีรายได้/รายหักพิเศษเท่าไหร่
		- ใช้การ select ทั้งหมดออกมาแล้วเอามาวน loop เพื่อ sum ค่าทั้งหมด
		- ทำการบันทึกแต่ละรายการลง salary_pay_log_detail_specialmoney เพราะต้องเก็บ log ต่างๆไว้ด้วย
	- มีลดหย่อนอะไรบ้าง
		- ใช้การ select ทั้งหมดออกมาแล้วเอามาวน loop เพื่อ sum ค่าทั้งหมด
		- ทำการบันทึกแต่ละรายการลง salary_pay_log_detail_reduce_tax เพราะต้องเก็บ log ต่างๆไว้ด้วย (ยังไม่ได้ทำการสร้าง)
	- นำเงินได้พึงประสงค์ทั้งหมดมาคิดว่าเสียภาษีเท่าไหร่ (rate_tax)
	- นำเงินได้มาหักค่าของที่บริษัทต้องหัก (deduction)
		- ใช้การ select ทั้งหมดออกมาแล้วเอามาวน loop เพื่อ sum ค่าทั้งหมด
		- ทำการบันทึกแต่ละรายการลง salary_pay_log_detail_deduction เพราะต้องเก็บ log ต่างๆไว้ด้วย
	
*/
DROP PROCEDURE IF EXISTS Salary_pay_all_user; $$
CREATE PROCEDURE Salary_pay_all_user(
	IN transYear INT,
	IN transMonth INT
)
BEGIN
	/* DECLARE transYear INT DEFAULT (SELECT DATE_FORMAT(CURDATE(),'%Y')); */ /* ปีที่ทำการคำนวณ */
	/* DECLARE transMonth INT DEFAULT (SELECT DATE_FORMAT(CURDATE(),'%m')); */ /* เดือนที่ทำการคำนวณ */
	DECLARE transUserId INT; /* user id ที่กำลังคำนวณ */
	DECLARE transEmpId VARCHAR(50); /* emp id ที่กำลังคำนวณ */
	DECLARE transSalary INT; /* เงินเดือน */
	DECLARE transSalaryPerHour INT; /* รายได้ต่อชั่วโมง */
	DECLARE numberDayOfMonth INT; /* จำนวนวันในเดือนนั้นๆ */
	DECLARE otMoney INT; /* เงินค่าทำโอที */
	DECLARE otHour FLOAT; /* จำนวนชั่วโมงโอที */
	DECLARE specialMoney INT; /* เงินได้เงินหักพิเศษที่สรุปแล้วได้เท่าไหร่ */
	DECLARE reduceTax INT; /* หักลดหย่อนภาษีเท่าไหร่ */
	DECLARE rateTax INT; /* คำนวณภาษีแล้วต้องเสียภาษีเท่าไหร่ */
	DECLARE deductionMoney INT; /* หักค่าอะไรอีกของบริษัทเช่น ประกันสังคม */
	DECLARE tempName VARCHAR(250) DEFAULT '';
	DECLARE done INT DEFAULT FALSE; /* สถานะเสร็จสิ้น */
	DECLARE cur CURSOR FOR SELECT UserID,EmpID,EmpSalary FROM t_employees LEFT JOIN t_users ON User_EmpID = EmpID;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
	/*DELETE FROM checker;*/

	/* หาว่า เดือนนี้มีทั้งหมดกี่วันเพื่อเอาไปคำนวณรายได้ต่อชั่วโมงในเดือนนั้น เพื่อใช้คูณค่ากับโอที */
	SET numberDayOfMonth = DAY(LAST_DAY(transYear+'-'+transMonth+'-1'));

	

	/* หาว่า จำนวนชั่วโมงในการทำงานของกะที่ทำอยู่ใช้เวลากี่ชั่วโมง เพื่อหารายได้ต่อชั่วโมงในเดือนนั้นไ */
-- 	select min(swdday+1)as minWork,max(swdday+1)as maxWork,swdtotaltime from t_emp_shiftwork 
-- left join t_shiftwork on esw_swid = swid
-- left join t_shiftworkdetail on swid = swd_swid
-- where 1=1 and esw_userid = 4
-- and swdiswork = 1
	OPEN cur;
		getEmp: LOOP
			FETCH cur INTO transUserId,transEmpId,transSalary;
				IF done THEN
            		LEAVE getEmp;
        		END IF;
        		/*ตอนนี้จะได้ค่าของ userId,userEmpId,salary มาแล้ว*/

				/* หารายได้ต่อชั่วโมงเพื่อเอาไปคิดเป็นโอที */
				SET transSalaryPerHour = (transSalary / numberDayOfMonth) / 8;

				/* การคิดโอทีต้องคำนึงด้วยว่าวันนั้นเป็นวันหยุดเพราะอัตราจะไม่เท่ากัน ดังนั้น
				ต้องใช้การวนทีละแถวมาเพื่อดูด้วยว่าโอทีเป็นวันหยุดหรือวันปกติ */
				BLOCK_OT: BEGIN
					DECLARE tempTimeFrom TIME;
					DECLARE tempTimeTo TIME;
					DECLARE tempRequestHour INT;
					DECLARE tempDayOfWeek INT;
					DECLARE tempIsWork INT;
					DECLARE tempTimeEnd TIME;
					DECLARE tempOtRate FLOAT DEFAULT 1.5;
					DECLARE done6 INT DEFAULT FALSE;
					DECLARE cur6 CURSOR FOR SELECT wot_time_from,wot_time_to
											,wot_request_hour,swdday,swdiswork
											,CASE WHEN swdtimeend2 IS NULL 
												THEN swdtimeend1 
												ELSE swdtimeend2 
											END AS swdtimeend 
											FROM
											(
												SELECT wot_request_hour,wot_time_from,wot_time_to
												,dayofweek(wot_date)-1 as otday,wot_request_by
												FROM t_worktime_ot 
												WHERE 1=1
												AND wot_request_by = transUserId AND wot_workflow_id = 21
												AND YEAR(wot_date) = transYear AND MONTH(wot_date) = transMonth
											)AS a
											LEFT JOIN t_emp_shiftwork on esw_userid = wot_request_by
											LEFT JOIN t_shiftwork on esw_swid = swid
											LEFT JOIN t_shiftworkdetail on swid = swd_swid AND otday = swdday;
        			DECLARE CONTINUE HANDLER FOR NOT FOUND SET done6 = TRUE;
        			OPEN cur6;
        				getOt: LOOP
	        				FETCH cur6 INTO tempTimeFrom,tempTimeTo,tempRequestHour,tempDayOfWeek,tempIsWork,tempTimeEnd;
	        				IF done6 THEN
	        					LEAVE getOt;
	        				END IF;
	        				/* ได้จำนวนชั่วโมงโอทีที่ทำในเดือนที่คำนวณแล้ว เอาไปคูณเป็นเงิน
							มี 3 เรท
							1.5 = วันปกติ
							2 = ทำงานในวันหยุด
							3 = ล่วงเวลาในวันหยุด
							*/
						
							/* ถ้าทำงานในวันหยุด */
							CASE tempIsWork
								WHEN 0 THEN SET tempOtRate = 2;
								ELSE SET tempOtRate = 1.5;
							END CASE;

							/* ถ้ามาทำงานในวันหยุดนักขัตฤกษ์ */
							
        				END LOOP getOt;
				END BLOCK_OT;
				
				/* มีรายได้/รายหักพิเศษเท่าไหร่ */
        		BLOCK_SPECIAL_MONEY: BEGIN
        			DECLARE tempId INT DEFAULT 0;
					DECLARE tempMoney INT DEFAULT 0;
					DECLARE done2 INT DEFAULT FALSE;
        			DECLARE cur2 CURSOR FOR SELECT SMMID,SMMTopic,SMMMoney FROM t_specialmoneyofmonth WHERE 1=1 AND SMMUserID = transUserId AND SMMYear = transYear AND SMMMonth = transMonth;
        			DECLARE CONTINUE HANDLER FOR NOT FOUND SET done2 = TRUE;
        			OPEN cur2;
        				getSpecialMoney: LOOP
        					FETCH cur2 INTO tempId,tempName,tempMoney;
        					IF done2 THEN
            					LEAVE getSpecialMoney;
        					END IF;
        					/* SUM */
        					SET specialMoney = specialMoney + tempMoney;
        					/* Insert detail to salary_pay_log_detail_specialmoney */
        					
        				END LOOP getSpecialMoney;
					CLOSE cur2;
				END BLOCK_SPECIAL_MONEY;
				/* สิ้นสุด มีรายได้/รายหักพิเศษเท่าไหร่ */
				
				/* มีลดหย่อนอะไรบ้าง */
				BLOCK_REDUCE_TAX: BEGIN
					DECLARE tempValue INT;
					DECLARE tempBahtYear INT;
					DECLARE tempBahtMonth INT;
					DECLARE tempSum INT;
					DECLARE done3 INT DEFAULT FALSE;
					DECLARE cur3 CURSOR FOR SELECT ert_value,ert_baht_year,ert_baht_month,reducetax_name FROM t_emp_reduce_tax LEFT JOIN reduce_tax ON ert_reducetaxid = reducetax_id WHERE 1=1 AND ert_userid = transUserId;
					DECLARE CONTINUE HANDLER FOR NOT FOUND SET done3 = TRUE;
					OPEN cur3;
						getReduceTax: LOOP
							FETCH cur3 INTO tempValue,tempBahtYear,tempBahtMonth,tempName;
							IF done3 THEN 
								LEAVE getReduceTax;
							END IF;
							/* SUM */
							IF tempValue > 0 THEN /* ตอนนี้ไม่แน่ใจละว่า ert_value เอาไว้ทำอะไร */
								SET tempSum = tempValue;
							ELSEIF tempBahtYear > 0 THEN
								SET tempSum = tempBahtYear;
							END IF;
							/* Insert detail to salary_pay_log_detail_reduce_tax */
							
						END LOOP getReduceTax;
					CLOSE cur3;
				END BLOCK_REDUCE_TAX;

				/* นำเงินได้พึงประสงค์ทั้งหมดมาคิดว่าเสียภาษีเท่าไหร่ */
				BLOCK_RATE_TAX: BEGIN
					DECLARE tempRatePercent INT;
					DECLARE tempRateBaht INT DEFAULT 0;
					DECLARE tempRateNotOver INT;
					DECLARE done4 INT DEFAULT FALSE;
					DECLARE cur4 CURSOR FOR SELECT ratetax_rate_percent,ratetax_rate_baht,ratetax_rate_not_over 
											FROM rate_tax 
											WHERE 1=1 
											AND ratetax_income_month >= transSalary LIMIT 1;
					DECLARE CONTINUE HANDLER FOR NOT FOUND SET done4 = TRUE;
					OPEN cur4;
						getRateTax: LOOP
							FETCH cur4 INTO tempRatePercent,tempRateBaht,tempRateNotOver;
							IF done4 THEN 
								LEAVE getRateTax;
							END IF;
							/* Calculate rate tax store in rateTax */

						END LOOP getRateTax;
				END BLOCK_RATE_TAX;

				/* นำเงินได้มาหักค่าของที่บริษัทต้องหัก */
				BLOCK_DEDUCTION: BEGIN
					DECLARE tempDeducBaht INT;
					DECLARE tempDeducPercent INT;
					DECLARE tempDeducMinBaht INT;
					DECLARE tempDeducMaxBaht INT;
					DECLARE done5 INT DEFAULT FALSE;
					DECLARE cur5 CURSOR FOR SELECT deduc_name,deduc_baht,deduc_percent
											,deduc_min_baht,deduc_max_baht 
											FROM salary_deduction;
					DECLARE CONTINUE HANDLER FOR NOT FOUND SET done5 = TRUE;
					OPEN cur5;
						getDeduction: LOOP
							FETCH cur5 INTO tempName,tempDeducBaht,tempDeducPercent,tempDeducMinBaht,tempDeducMaxBaht;
							IF done5 THEN 
								LEAVE getDeduction;
							END IF;
							/* Calculate rate tax store in rateTax */

						END LOOP getDeduction;
				END BLOCK_DEDUCTION;
		END LOOP getEmp;
	CLOSE cur;
	SELECT * FROM checker;
	/* INSERT INTO checker(hour)VALUES(tempSum); */
END;
$$
DELIMITER ;