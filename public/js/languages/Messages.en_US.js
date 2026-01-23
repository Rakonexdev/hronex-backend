/* 
// [INSASOFT][14-May-2023][BEGIN]
// Enhancement  : Globalization & Localization.
// @File        : Messages.en_US.js
// @Date        : 14-May-2023
// @Description : Defines the messages used in the application locale is English-UnitedStates 
*/

/* 
* Core side Message constants used in the application... 
*/
Messages.en_US = {
    getText: function (id) {
        return Messages.getLocale(this, id);
    },

    /* 
    * Common Messages related to js...
    */

    LABELTEXT: {        
        REASON                  : "Comment (if any)",
        REJ_BTN                 : "Reject",
        ADD_BTN                 : "Add",
        SUCCESS_MSG             : "Successful",
        ERROR_TITLE             : "Error",
        SORRY_TITLE             : "Sorry !!"
    },                  

    ALL: {
        DELETE_SURE_MSG         : "Are you sure ? ",
        DLT_SURE_TXT            : "You won't be able to revert this!",
        DLT_YES_IT              : "Yes, delete it!",
        DLT_NO_IT               : "No, cancel!",
        DLT_DONE                : "Deleted!",
        DLT_DONE_TXT            : "Your file has been deleted.",
        DLT_DONE_FAIL           : "Not Deleted",
        DLT_DONE_FAIL_TXT       : "Sorry, unable to delete.",
        FILL_FIELDS             : "Please fill the mandatory fields", 
        SELECT_ITEM             : "Please select an item",
        NO_MATCH                : "No matching found!!!",	
        EXIST                   : "Already Exist",
        NOT_EXIST               : "Available, Continue..",
        INST_SUCCESS            : "Created successfully.",
	    SUCCESS_UPD             : "Updated Succesfully",
	    SUCCESS                 : "Successful",
        ERROR                   : "Error Found, Try again later.",
        CHOOSE_ANY_ONE          : "Please choose atleast one item",
        MAIL_OK                 : "Mail sent successfully",
        MAIL_ERROR              : "Emailing Failed!!!",
        FILE_TYPE_ERR           : "Invalid file type !",
        UPLD_FL_TTL             : "Uploaded Files"
    },
    USER: {
        LOGIN_NAME_REQUIRED     : "Please enter User Name",
        LOGIN_EMAIL_REQUIRED   	: "Please enter Email",
        LOGIN_PASSWORD_REQUIRED : "Please enter a Password"	
    },
	COMMON : {
	    NAME_REQUIRED           : "Please enter Name",
        FNAME_REQUIRED          : "Please enter Full Name",
        USER_NAME_REQUIRED      : "Please enter User name",
        USER_TYPE_REQUIRED      : "Please select User type",
        CITY_REQUIRED           : "Please enter City",
        STATE_REQUIRED          : "Please enter State",
        CNTRY_REQUIRED          : "Please Select Country",
        PHONE_REQUIRED          : "Please enter Phone",
        PHONE_NO_ONLY           : "Only Digits are Allowed",
        PHONE_NO_SIZE           : "8 Digits Mandatory",
        EMAIL_REQUIRED          : "Please enter Email",
        ADRS_REQUIRED           : "Please enter Address",
        DOB_REQUIRED            : "Please enter DOB",
        UNIQUE_REQUIRED         : "Please enter Unique Code",
        NO_REQUIRED             : "Please enter no",
        FROM_REQUIRED           : "Please fill From column",
        TO_REQUIRED             : "Please enter To column",
        PAN_REQUIRED            : "Please enter Pan",
        TAN_REQUIRED            : "Please enter Tan",
        CUSTADDRESS_REQUIRED    : "Please enter Customer Address",
        CANCEL_REASON_REQUIRED  : "Please enter Cancel Reason"
	},
    
    PROFILE: {
        CUR_PASSWORD_REQUIRED  : "Please enter Current Password",
        NEW_PASSWORD_REQUIRED  : "Please enter New Password", 
        CONF_PASSWORD_REQUIRED : "Please enter Confirm Password",
        PASSWORD_NOT_EQUAL     : "Passwords are not match"  
    },

    GRATUITY: {
        TOTAL_DAYS_LASTMONTH_REQUIRED         : "Please fill the Total Days Last Month column"
    },

    EMPLOYEE_STATUS: {
        INACTIVE_TYPE_REQD       : "Please select Inactive Status",
        INACTIVE_DATE_REQD       : "Please select Inactive Date",
        INACTIVE_CMT_REQD        : "Please enter the Reason for Inactive"
    },

    FCM: {
        TOKEN_SAVE_SUCC          : "FCM Token Saved Successfully",
        TOKEN_SAVE_ERR           : "FCM Token Error"
    }


    
    
};
