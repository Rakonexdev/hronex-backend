var cust  = new function() {

	this.success = 0;

	/*Employee Onboarding form submission*/	
	this.employeeFormSubmit = function(form)
    {
        var errorContainer = document.getElementById('errorContainer');
        var successMessage = document.getElementById('successMessage');
        var formData = new FormData(form);            

        errorContainer.innerHTML = '';
        successMessage.innerHTML = '';
        
        document.querySelector('#loader').classList.remove('hidden');

        fetch(form.action, {
            method: form.method,
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
            	//form.reset();
                //successMessage.innerHTML = data.message; 

                // Other actions on success
                if(data.user_id){
                	document.getElementById('user_id_m').value = data.user_id;
                	document.getElementById('user_id_o').value = data.user_id;
                	document.getElementById('user_id_f').value = data.user_id;
                	document.getElementById('user_id_p').value = data.user_id;
                }
                cust.tabDisabledToggle('navl-d', 'E');

                Swal.fire({
				  title: Messages.getText('LABELTEXT.SUCCESS_MSG'),
				  text: data.message,
				  icon: 'success',
				  showCancelButton: false,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: "Ok"
				}).then((result) => {
				  	if (result.isConfirmed){
						
						if('M' == data.type){
							cust.tabActiveToggle('nav-link', 'tab-pane', 'o-info', 'oth-info');
						}else if('O' == data.type){
							cust.tabActiveToggle('nav-link', 'tab-pane', 'p-info', 'payroll-info');
						}else if('P' == data.type){
							cust.tabActiveToggle('nav-link', 'tab-pane', 'f-info', 'file-info');
						}else{
							location.reload(); 
						}
						scrollToTop();						
					}
				}) 
				document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
            } else if (data.status === 'error') {

            	if (data.type === 'exception') {	                
	                errorContainer.innerHTML = data.message;
	            }else{
	            	var errorHtml = '<ul>';
	                for (var key in data.errors) {
	                    errorHtml += '<li>' + data.errors[key][0] + '</li>';
	                }
	                errorHtml += '</ul>';
	                errorContainer.innerHTML = errorHtml;
	            }     
                document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
            }            
        })
        .catch(error => {
            errorContainer.innerHTML = Messages.getText('LABELTEXT.ERROR');
            document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
            //console.error(error);            
        });

        if(document.querySelector(".alert-js")){
          setTimeout(function() {
              document.querySelector(".alert-js").innerHTML = '';
            }, 5000);
       }
    };

    this.tabDisabledToggle = function(tabcls, goal){
    	document.querySelectorAll('.'+tabcls).forEach(element => {
    		if('E' == goal){
			    element.classList.remove("disabled");
			    element.setAttribute("aria-disabled", "false");
			}else{
				element.classList.add("disabled");
			    element.setAttribute("aria-disabled", "true");
			}		  
		});
    };

    this.tabActiveToggle = function(tabcls, divcls, tabtyp, divtyp){
    	document.querySelectorAll('.'+tabcls).forEach(element => {    		
			element.classList.remove("active");	
			if(tabtyp == element.id){		
				element.classList.add("active");
			}
		});
		document.querySelectorAll('.'+divcls).forEach(element => {    		
			element.classList.remove("active");	
			if(divtyp == element.id){		
				element.classList.add("active");
			}
		});
    };

	/* Get employee data gratuity creation */
	this.getEmployeeDetails = function(employeeid){		
		let resp = '';
		cust.clearData();		

		/* if( isNaN(employeeid) || 0 >= parseInt(employeeid) ) 
			return false; */		

		$('#loader').removeClass('hidden');
        url = APP_URL+'/employeeDetails';

        data   = JSON.stringify({'employeeid' : employeeid});  
        var req = new XMLHttpRequest();       
        req.open("POST", url);
        req.setRequestHeader("content-type", "application/json");
        req.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

        req.onreadystatechange = function () { 
             
            if (req.readyState != 4 || req.status != 200){
                document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
                return;
            }else{ 
            	resp = req.response;  /*JSON.parse(req.response); */            	
            	document.querySelector('#grat-data').innerHTML = resp;
            	document.querySelector('.submit-section').classList.remove('hidee');
                document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');                 
            }
        };
        
        req.send(data); 
	};

	/* Get gratuity & employee data for gratuity update */
	this.getGratuityDetails = function(gratuityid, gratuitystatus){		
		let resp = '';	
		/*let actionurl = APP_URL+'/gratuity/'+gratuityid;*/	

		if( isNaN(gratuityid) || 0 >= parseInt(gratuityid) ) 
			return false;		

		if('Initiated' != gratuitystatus){
			document.querySelector(".updatebtn").classList.add('hidee');
		}else{
			document.querySelector(".updatebtn").classList.remove('hidee');
		}

		$('#loader').removeClass('hidden');
        url = APP_URL+'/gratuityDetails';

        data   = JSON.stringify({'gratuityid' : gratuityid});  
        var req = new XMLHttpRequest();       
        req.open("POST", url);
        req.setRequestHeader("content-type", "application/json");
        req.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

        req.onreadystatechange = function () { 
             
            if (req.readyState != 4 || req.status != 200){
                document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
                return;
            }else{ 
            	resp = req.response;  /*JSON.parse(req.response); */  
            	document.querySelector('#grat-data-update').innerHTML = resp;
            	document.querySelector('.submit-section').classList.remove('hidee');
            	/*document.querySelector('#gratuity-update-form').action = actionurl; */
                document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');                 
            }
        };
        
        req.send(data); 
	};

	/* Clear some data,field..etc */
	this.clearData = function(){
		document.querySelector('#grat-data').innerHTML = '';		
        document.querySelector('.submit-section').classList.add('hidee');	
	};


	/* Validating & submission of gratuity; work */
	this.validateGratuity = function(formdata){
		/*Client side validation section: will do later*/
		//Extract Each Element Value
	    /*for (var i = 0; i < formdata.elements.length; i++) {
	    	console.log(formdata.elements[15].value);
	    }
	    return;*/
	    if(''==formdata.elements[15].value || 0 >= formdata.elements[15].value){
	    	let tot_mnt = document.querySelector("#total_days_last_month");
	    	/*tot_mnt.style.border = '1px solid #FF0000';*/
	    	tot_mnt.focus();
	    	Swal.fire(
		      Messages.getText('LABELTEXT.ERROR_TITLE'),
		      Messages.getText('GRATUITY.TOTAL_DAYS_LASTMONTH_REQUIRED'),
		      'error'
		    )
		    return false;
	    }

		formdata.submit();   
	};

	/* Get gratuity & employee data for gratuity update */
	this.getGratuityForStatus = function(gratuityid){		
		let resp = '';	
		
		if( isNaN(gratuityid) || 0 >= parseInt(gratuityid) ) 
			return false;		

		$('#loader').removeClass('hidden');
        url = APP_URL+'/getGratuityForStatus/'+gratuityid;

        var req = new XMLHttpRequest();       
        req.open("GET", url);
        req.setRequestHeader("content-type", "application/json");
        req.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

        req.onreadystatechange = function () { 
             
            if (req.readyState != 4 || req.status != 200){
                document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
                return;
            }else{ 
            	resp = req.response;
            	document.querySelector('#grat-stat-div').innerHTML = resp;
                document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');                 
            }
        };
        
        req.send(); 
	};

	/* Update gratuity status */
	this.updateGratuityStatus = function(){		
		let resp = '';

		let id = document.querySelector('#gratuity_id').value; 
		let status = document.querySelector('#grat_status').value; 
		let dest_id = document.querySelector('#dest_id').value; 
		let comment = document.querySelector('#comment').value; 

		if(0 >= status || '' == status)
			return false;		

		$('#loader').removeClass('hidden');
        url = APP_URL+'/updateGratuityStatus';

        data   = JSON.stringify({'id' : id, 'status' : status, 'dest_id' : dest_id, 'comment' : comment});  
        var req = new XMLHttpRequest();       
        req.open("POST", url);
        req.setRequestHeader("content-type", "application/json");
        req.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

        req.onreadystatechange = function () { 
             
            if (req.readyState != 4 || req.status != 200){
                document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
                return;
            }else{ 
            	resp = req.response;
            	console.log(resp);            	            	          	
                document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');    
                Swal.fire({
				  title: Messages.getText('ALL.SUCCESS'),
				  text: resp,
				  icon: 'success',
				  showCancelButton: false,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: "Ok"
				}).then((result) => {
				  if (result.isConfirmed) {
				  	location.reload(); 
				  }
				})
                              
            }
        };
        
        req.send(data); 
	};	

	this.calculateNetPay = function()
	{
		let basic = parseInt(document.getElementById("basic_sal").value);
		let gross = parseInt(document.getElementById("gross_sal").value);
		let actual_np = parseInt(document.getElementById("actual_np").value);
		let noticeperiod = parseInt(document.getElementById("notice_period").value);
		let joining_date = new Date(document.getElementById("joining_date").value);
		let last_day = new Date(document.getElementById("last_working_day").value);		
		let unpaid_leave = document.getElementById('unpaid_leave');		
		let total_days_milli = last_day - joining_date;
		let last_payroll_amnt = parseInt(document.getElementById("last_payroll").value);
		//let total_days_employment = document.getElementById('total_days_employment');

		let total_days_employment = parseInt(total_days_milli / (1000 * 60 * 60 * 24))+1;
		document.getElementById('total_days_employment').value = total_days_employment;

		/*If ntoice period not served then add figure in gratuity deduction */
		let np_deff = parseInt(actual_np) - parseInt(noticeperiod);
		if(np_deff > 0){
			document.getElementById("gratuity_ded").value = Math.round((gross/30)*np_deff).toFixed(2);
		}

		let last_month_days_value = document.getElementById("total_days_last_month").value;
		let total_days_last_month = cust.calculateDateDifferenceNew(last_day);
		if(0 >= last_month_days_value){
			document.getElementById("total_days_last_month").value = total_days_last_month;
		}		

		let noticepay = 0; /**(noticeperiod/30)*gross;*/
		document.getElementById("notice_pay").value = Math.round(noticepay).toFixed(2);
		//document.getElementById("notice_pay_label").innerHTML = Math.round(noticepay).toFixed(2);
  		let currentmonthworking = parseInt(document.getElementById("total_days_last_month").value);
  		let current_month_salary = (gross/30)*currentmonthworking;
  		document.getElementById("current_month_salary").value = current_month_salary.toFixed(2);

  		let net_days_worked = parseFloat(total_days_employment)-parseFloat(unpaid_leave.value); //parseInt(document.getElementById("net_days_worked").value);
  		document.getElementById("net_days_worked").value = net_days_worked;
		let gratuity_check_days = parseInt(document.getElementById("gratuity_check_days").value);

  		let eligible_days = (net_days_worked/365)*gratuity_check_days;
  		document.getElementById("eligible_days").value = eligible_days.toFixed(2);

  		let gratuity_add = Math.round((basic/30))*(eligible_days.toFixed(2)); /*Math.round((basic*12)/365)*Math.round(eligible_days);*/
  		document.getElementById("gratuity_add").value = Math.round(gratuity_add).toFixed(2);

  		let gratuity_ded = parseInt(document.getElementById("gratuity_ded").value);
  		let gratuity_total = gratuity_add-gratuity_ded;
  		document.getElementById("gratuity_total").value = Math.round(gratuity_total).toFixed(2);	

  		//let annual_leave_entitled = parseInt(document.getElementById("annual_leave_entitled").value);
  		let accrued_annual_leave = parseFloat(document.getElementById("accrued_annual_leave").value); //parseInt(Math.round((net_days_worked/30)*2.5));
		document.getElementById("accrued_annual_leave").value = accrued_annual_leave;
  		let annual_leave_availed = parseFloat(document.getElementById("annual_leave_availed").value);
  		let annual_leave_balance = parseFloat(accrued_annual_leave-annual_leave_availed);
		if(annual_leave_balance < 0) annual_leave_balance = 0;
  		document.getElementById("annual_leave_balance").value = annual_leave_balance.toFixed(2); /* Math.round(annual_leave_balance).toFixed(2); */	
  		let leave_accrual_amount = (basic/30)*annual_leave_balance;  
  		document.getElementById("leave_accrual_amount").value = Math.round(leave_accrual_amount).toFixed(2);		

  		let ticket_accrual_amount = parseInt(document.getElementById("ticket_accrual_amount").value);
  		let return_ticket_amount = parseInt(document.getElementById("return_ticket_amount").value);  		

  		let net_pay = current_month_salary+noticepay+gratuity_total+leave_accrual_amount+ticket_accrual_amount+return_ticket_amount;

		if(document.getElementById("last_payroll_chk").checked){
			net_pay = net_pay+last_payroll_amnt;
		}
  		
  		document.getElementById("net_pay_round_off").value = net_pay.toFixed(2);
  		document.getElementById("net_pay").value = Math.ceil(net_pay).toFixed(2);
	};	

	this.calculateDateDifferenceNew = function(inputDate) {
		let daysDifference = 0;

		// Convert inputDate to a JavaScript Date object
		const currentDate = new Date(inputDate);
	
		// Check if the date is less than the 25th of the month
		if (currentDate.getDate() < 25) {
			// Calculate the 25th of the previous month
			const twentyFifthOfPreviousMonth = new Date(currentDate);
			twentyFifthOfPreviousMonth.setMonth(currentDate.getMonth() - 1);
			twentyFifthOfPreviousMonth.setDate(25);
	
			// Calculate the difference in milliseconds
			const timeDifference = currentDate.getTime() - twentyFifthOfPreviousMonth.getTime();
	
			// Convert the time difference to days
			daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
		} else {
			const curMonth = new Date(currentDate);
			curMonth.setMonth(currentDate.getMonth());
			curMonth.setDate(25);
	
			// Calculate the difference in milliseconds
			const timeDifference = currentDate.getTime() - curMonth.getTime();
	
			// Convert the time difference to days
			daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));			
		}

		return parseInt(daysDifference);
	}

	this.calculateGrossTotal = function()
	{
		let basic = parseInt(document.getElementById("basic_salary").value);
		let acmd_alw = parseInt(document.getElementById("accomodation_allowance").value);
		let trnsp_alw = parseInt(document.getElementById("transport_allowance").value);
		let contin_alw = parseInt(document.getElementById("continuous_allowance").value);
		let temp_alw = parseInt(document.getElementById("temp_allowance").value);
		let oth_alw = parseInt(document.getElementById("other_allowance").value);

		if(isNaN(basic) || 0 > basic) basic = 0;
		if(isNaN(acmd_alw) || 0 > acmd_alw) acmd_alw = 0;
		if(isNaN(trnsp_alw) || 0 > trnsp_alw) trnsp_alw = 0;
		if(isNaN(contin_alw) || 0 > contin_alw) contin_alw = 0;
		if(isNaN(temp_alw) || 0 > temp_alw) temp_alw = 0;
		if(isNaN(oth_alw) || 0 > oth_alw) oth_alw = 0;

		let gross = parseInt(basic+acmd_alw+trnsp_alw+contin_alw+temp_alw+oth_alw);
		document.getElementById("gross_total").value = gross.toFixed(2);
	};

	this.calculateAge = function() {		
	  	let dob = new Date(document.getElementById("dob").value);
	  	let today = new Date();

	  	let age = today.getFullYear() - dob.getFullYear();

	  	// Check if the birthday hasn't occurred yet this year
	  	if (today.getMonth() < dob.getMonth() ||
	    	(today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())
	  	){
	    	age--;
	  	}

	  	//return age;
	  	document.getElementById("age").value = age;
	};

	this.calculateServicePeriod = function() {
		let doj = new Date(document.getElementById("joiningdate").value);
		let today = new Date();

		// Calculate the difference in years and months
		let sp1 = today.getFullYear() - doj.getFullYear();
		let sp2 = ((sp1)*12 + (today.getMonth() - doj.getMonth()))%12;
		let service_period = sp1+'.'+sp2;

		// Check if the sp hasn't occurred yet this year
		if (today.getMonth() < doj.getMonth() ||
			(today.getMonth() === doj.getMonth() && today.getDate() < doj.getDate())
		){
			service_period--;
		}

		//return service_period;
		document.getElementById("service_years").value = service_period;
	};

	
	this.loadEmployeeStatus = function(employee_id)
	{		
		let employee_status_data = document.querySelector('#emp_stat_val_'+employee_id).value;
		let stat_data = (employee_status_data && ''!=employee_status_data)?JSON.parse(employee_status_data):null;			

		document.querySelector('#employee_id').value = employee_id;
		if(null!=stat_data){
			document.querySelector('#current_status').value = stat_data.current_status;
			document.querySelector('#inactive_status').value = stat_data.inactive_status;			
			document.querySelector('#inactive_date').value = stat_data.inactive_date;
			document.querySelector('#inactive_reason').value = stat_data.inactive_reason;						
		}else{
			document.querySelector('#current_status').value = 1;
			document.querySelector('#inactive_status').value = 0;
			document.querySelector('#inactive_date').value = null;
			document.querySelector('#inactive_reason').value = '';
		}
	};

	this.updateEmployeeStatus = function()
	{
		let err = 0;
		let msg = '';
		let emp_stat_form = document.getElementById("employee_status_form");

		//Extract Each Element Value
	    for (var i = 0; i < emp_stat_form.elements.length; i++) {    	
	    	if(1==emp_stat_form.elements[1].value){
	    		document.querySelector('#inactive_status').value = 0;
				document.querySelector('#inactive_date').value = null;
				document.querySelector('#inactive_reason').value = '';
	    		err = 0;
	    		break;
	    	}else{
	    		if(0 == emp_stat_form.elements[2].value || '' == emp_stat_form.elements[2].value){
	    			err = 1;
	    			msg = Messages.getText('EMPLOYEE_STATUS.INACTIVE_TYPE_REQD');
	    			break;
	    		}else if('' == emp_stat_form.elements[3].value){
	    			err = 1;
	    			msg = Messages.getText('EMPLOYEE_STATUS.INACTIVE_DATE_REQD');
	    			break;
	    		}else if('' == emp_stat_form.elements[4].value){
	    			err = 1;
	    			msg = Messages.getText('EMPLOYEE_STATUS.INACTIVE_CMT_REQD');
	    			break;
	    		}else{
	    			err = 0;
	    		}
	    	}	    	
	    }

	    if(1 == err){
		    Swal.fire(
				Messages.getText('LABELTEXT.ERROR_TITLE'),
				msg,
				'error'
			)
			return false;
		}else{
			emp_stat_form.submit();
		}
		
	};

	this.deleteFile = function(id, fileitem)
	{
		url = APP_URL+'/deleteFile';

	    Swal.fire({
	      title: Messages.getText('ALL.DELETE_SURE_MSG'),
	      text: Messages.getText('ALL.DLT_SURE_TXT'),
	      icon: 'warning',
	      showCancelButton: true,
	      confirmButtonText: Messages.getText('ALL.DLT_YES_IT'),
	      cancelButtonText: Messages.getText('ALL.DLT_NO_IT'),
	      reverseButtons: true
	    }).then((result) => {
	        if (result.isConfirmed) {		        
			    fetch(url, {
		            method: 'POST',
		            body: JSON.stringify({'file_id' : id, 'file_item' : fileitem, 'url' : APP_URL}),
		            headers: {
		            	    'Content-Type': 'application/json',
				        	'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
				    }
		        })
			    .then(response => {
			      if (response.ok) {
			        Swal.fire(
				        Messages.getText('ALL.DLT_DONE'),
				        'success'
				    );
					document.getElementById('div_'+id).remove();
				    //location.reload();
			      } else {
			        Swal.fire(
				        Messages.getText('ALL.DLT_DONE_FAIL_TXT'),
				        'error'
				    );
			      }
			    })
			    .catch(error => {
			        Swal.fire(
				        Messages.getText('ALL.DLT_DONE_FAIL_TXT'),
				        'error'
				    );
			    });
	        } else if (result.dismiss === Swal.DismissReason.cancel) {
		        //
	        }
	    });
		
	};

	this.showFiles = function(userid)
	{
		if(0 >= userid)
			return false;

		url = APP_URL+'/showFiles/'+userid;

		fetch(url)
		  .then(response => response.text())
		  .then(data => {
		    // Set the content of the modal
		    document.getElementById('m-title').innerHTML = Messages.getText('ALL.UPLD_FL_TTL');
            document.getElementById('modalContent').innerHTML = data;

            // Show the modal
            $('#showModal').modal('show');
		  })
		  .catch(error => {
		    // Handle any errors that occur during the request
		    console.error('Error:', error);
		  });	    
	};


	/**Firebase web app notification related works starts here */

	this.addAlertsToNotifications = function()
	{
		url = APP_URL+'/alerts-to-notify';

		fetch(url)
		  .then(response => response.text())
		  .then(data => {
		    // Set the result
		    //console.log(data);            
		  })
		  .catch(error => {
		    // Handle any errors that occur during the request
		    console.error('Error:', error);
		  });
	};

	this.initFirebaseMessagingRegistration = function() {
        /*messaging
        .requestPermission()*/
        Notification
        .requestPermission()
        .then(() => {
            //return messaging.getToken({vapidKey: 'BCIdscX1l8-cqNDS7d_jB3fL87SPgGiJIpNxaC14ESeT33k5dUXSMVFNO4'});

			/*return messaging.getToken({vapidKey: 'BCIdscX1l8-cqNDS7d_jB3fL87SPgGiJIpNxaC14ESeT33k5dUXSMVFNO4'}).then((currentToken) => {
				if (currentToken) {
				  sendTokenToServer(currentToken);
				  updateUIForPushEnabled(currentToken);
				} else {
				  // Show permission request.
				  console.log('No registration token available. Request permission to generate one.');
				  // Show permission UI.
				  updateUIForPushPermissionRequired();
				  setTokenSentToServer(false);
				}
			  }).catch((err) => {
				console.log('An error occurred while retrieving token. ', err);
				setTokenSentToServer(false);
			  });*/
			    
			const currentToken = messaging.getToken();
			console.log('Token saved successfully');
			/*console.log('Your token is:', currentToken);*/
			
			return currentToken;
        })
        .then(function(currentToken) {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: APP_URL+'/save-token',
                type: 'POST',
                data: {
                    device_token: currentToken,
                    device_type: 'Web'
                },
                dataType: 'JSON',
                success: function (response) {
                    /*console.log(response);*/
                },
                error: function (err) {
                    console.log(Messages.getText('FCM.TOKEN_SAVE_SUCC') + err);
                },
            });

        }).catch(function (err) {
            console.log(Messages.getText('FCM.TOKEN_SAVE_SUCC') + err);
        });
    };

	this.sendCancelRequest = function(th){
		let employee_id = th.getAttribute('data-eid');
		let leave_id = th.getAttribute('data-id');
		let reason = document.getElementById('canel-reason-'+leave_id).value;
		const url = APP_URL+'/sendretractrequest';
		
		if(''==reason || 0 >= reason.length){
			Swal.fire(
				Messages.getText('LABELTEXT.ERROR_TITLE'),
				Messages.getText('COMMON.CANCEL_REASON_REQUIRED'),
				'warning'
			)
			return false;
		}

		const postData = {
			leave_id: leave_id,
			employee_id: employee_id,
			reason: reason,
			request_from: 'H'
		};

		const options = {
			method: 'POST',
			headers: {
			  'Content-Type': 'application/json',
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			body: JSON.stringify(postData)
		};

		Swal.fire({
			title: Messages.getText('ALL.DELETE_SURE_MSG'),
			text: '',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: "Ok",
			cancelButtonText: "Cancel",
			reverseButtons: true
		}).then((result) => {
			if (result.isConfirmed) {

				document.querySelector('#loader').classList.remove('hidden');
				fetch(url, options)
					.then(response => response.json())
					.then(data => {
						//console.log('POST request successful:', data);
						if(data.success){
							Swal.fire(
								Messages.getText('LABELTEXT.SUCCESS_MSG'),
								Messages.getText('ALL.SUCCESS_UPD'),
								'success'
							)
						}
						document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
						location.reload();
				})
				.catch(error => {
					//console.error('Error making POST request:', error);
					Swal.fire(
						Messages.getText('LABELTEXT.ERROR_TITLE'),
						Messages.getText('ALL.ERROR'),
						'error'
					)
					document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
				});

			} else if (result.dismiss === Swal.DismissReason.cancel) {
				//
			}
		});

	};

	this.retractLeave = function(th){
		let req_id = th.getAttribute('data-id');
		let req_type = th.getAttribute('id');
		let leave_id = th.getAttribute('data-lid');
		const url = APP_URL+'/approveretract';

		const postData = {
			id: req_id,
			leave_id: leave_id,
			status: req_type
		};

		const options = {
			method: 'POST',
			headers: {
			  'Content-Type': 'application/json',
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			body: JSON.stringify(postData)
		};

		Swal.fire({
			title: Messages.getText('ALL.DELETE_SURE_MSG'),
			text: '',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: "Ok",
			cancelButtonText: "Cancel",
			reverseButtons: true
		}).then((result) => {
			if (result.isConfirmed) {

				document.querySelector('#loader').classList.remove('hidden');

				fetch(url, options)
					.then(response => response.json())
					.then(data => {
						//console.log('POST request successful:', data);
						if(1==data){
							Swal.fire(
								Messages.getText('LABELTEXT.SUCCESS_MSG'),
								Messages.getText('ALL.SUCCESS_UPD'),
								'success'
							)
						}
						document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
						location.reload(); 
				})
				.catch(error => {
					//console.error('Error making POST request:', error);
					Swal.fire(
						Messages.getText('LABELTEXT.ERROR_TITLE'),
						Messages.getText('ALL.ERROR'),
						'error'
					)
					document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
				});
				
			} else if (result.dismiss === Swal.DismissReason.cancel) {
				//
			}
		});
	};

	this.deleteLeave = function(id)
	{
		url = APP_URL+'/deleteLeave';

	    Swal.fire({
	      title: Messages.getText('ALL.DELETE_SURE_MSG'),
	      text: Messages.getText('ALL.DLT_SURE_TXT'),
	      icon: 'warning',
	      showCancelButton: true,
	      confirmButtonText: Messages.getText('ALL.DLT_YES_IT'),
	      cancelButtonText: Messages.getText('ALL.DLT_NO_IT'),
	      reverseButtons: true
	    }).then((result) => {
	        if (result.isConfirmed) {
			    fetch(url, {
		            method: 'POST',
		            body: JSON.stringify({'id' : id, 'url' : APP_URL}),
		            headers: {
		            	    'Content-Type': 'application/json',
				        	'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
				    }
		        })
			    .then(response => {
			      if (response.ok) {
			        Swal.fire(
				        Messages.getText('ALL.DLT_DONE'),
				        'success'
				    );					
				    location.reload();
			      } else {
			        Swal.fire(
				        Messages.getText('ALL.DLT_DONE_FAIL_TXT'),
				        'error'
				    );
			      }
			    })
			    .catch(error => {
			        Swal.fire(
				        Messages.getText('ALL.DLT_DONE_FAIL_TXT'),
				        'error'
				    );
			    });
	        } else if (result.dismiss === Swal.DismissReason.cancel) {
		        //
	        }
	    });
		
	};
	

}

/*function showToken(currentToken) {
    // Show token in console and UI.
    const tokenElement = document.querySelector('#token');
    tokenElement.textContent = currentToken;
}

  // Send the registration token your application server, so that it can:
  // - send messages back to this app
  // - subscribe/unsubscribe the token from topics
function sendTokenToServer(currentToken) {
    if (!isTokenSentToServer()) {
      console.log('Sending token to server...');
      // TODO(developer): Send the current token to your server.
      setTokenSentToServer(true);
    } else {
      console.log('Token already sent to server so won\'t send it again ' +
          'unless it changes');
    }
}

function isTokenSentToServer() {
    return window.localStorage.getItem('sentToServer') === '1';
}

function setTokenSentToServer(sent) {
    window.localStorage.setItem('sentToServer', sent ? '1' : '0');
}*/


/**Firebase web app notification related works Ends here */






const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth" // Use "auto" for instant scrolling without animation
  });
};


/* Validating & submission of gratuity: action */
if(document.getElementById("add-grat-btn")){
	document.getElementById("add-grat-btn").addEventListener("click", function(e){
		e.preventDefault();
		let addGratuityForm = document.getElementById("add-grat-form");	
	  	cust.validateGratuity(addGratuityForm);
	});
}

if(document.getElementById("update-grat-stat-btn")){
	document.getElementById("update-grat-stat-btn").addEventListener("click", function(e){
		e.preventDefault();	
	  	cust.updateGratuityStatus();
	});
}

/*if(document.querySelectorAll(".emp_stat_update")){
	let clicklink = document.querySelectorAll(".emp_stat_update");
	[...clicklink].forEach((button) => {
	  button.addEventListener('click', (e) => {
	  	e.preventDefault(); 
	  	let employee_id = e.target.getAttribute('data-id'); 		
  		e.stopPropagation();	    
	    cust.updateEmployeeStatus(employee_id);
	  });
	});
}*/