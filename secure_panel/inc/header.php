  <?php ob_start();
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
  include_once 'com/sqlConnection.php';
  include_once 'com/functions.php';
  $db=new sqlConnection();
  $_SESSION['admin-type'];
  ?><!DOCTYPE html>
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
        <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title></title>
      <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
    <!-- BOOTSTRAP STYLES-->
      <link href="assets/css/bootstrap.css" rel="stylesheet" />
      <!-- FONTAWESOME STYLES-->
      <link href="assets/css/font-awesome.css" rel="stylesheet" />
      <!-- MORRIS CHART STYLES-->
      <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
          <!-- CUSTOM STYLES-->
      <link href="assets/css/custom.css" rel="stylesheet" />
      <!-- GOOGLE FONTS-->
      <script type="text/javascript" src="js/jquery.form.js"></script>
  <script type="text/javascript" src="js/livevalidation.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script language=JavaScript>

  var datePickerDivID = "datepicker";
  var iFrameDivID = "datepickeriframe";

  var dayArrayShort = new Array('Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa');
  var dayArrayMed = new Array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
  var dayArrayLong = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
  var monthArrayShort = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
  var monthArrayMed = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');
  var monthArrayLong = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
  
  // these variables define the date formatting we're expecting and outputting.
  // If you want to use a different format by default, change the defaultDateSeparator
  // and defaultDateFormat variables either here or on your HTML page.
  var defaultDateSeparator = "-";        // common values would be "/" or "."
  var defaultDateFormat = "ymd"    // valid values are "mdy", "dmy", and "ymd"
  var dateSeparator = defaultDateSeparator;
  var dateFormat = defaultDateFormat;

  function displayDatePicker(dateFieldName, displayBelowThisObject, dtFormat, dtSep)
  {
    var targetDateField = document.getElementsByName (dateFieldName).item(0);
  
    // if we weren't told what node to display the datepicker beneath, just display it
    // beneath the date field we're updating
    if (!displayBelowThisObject)
      displayBelowThisObject = targetDateField;
  
    // if a date separator character was given, update the dateSeparator variable
    if (dtSep)
      dateSeparator = dtSep;
    else
      dateSeparator = defaultDateSeparator;
  
    // if a date format was given, update the dateFormat variable
    if (dtFormat)
      dateFormat = dtFormat;
    else
      dateFormat = defaultDateFormat;
  
    var x = displayBelowThisObject.offsetLeft;
    var y = displayBelowThisObject.offsetTop + displayBelowThisObject.offsetHeight ;
  
    // deal with elements inside tables and such
    var parent = displayBelowThisObject;
    while (parent.offsetParent) {
      parent = parent.offsetParent;
      x += parent.offsetLeft;
      y += parent.offsetTop ;
    }
  
    drawDatePicker(targetDateField, x, y);
  }

  function drawDatePicker(targetDateField, x, y)
  {
    var dt = getFieldDate(targetDateField.value );

    if (!document.getElementById(datePickerDivID)) {

      var newNode = document.createElement("div");
      newNode.setAttribute("id", datePickerDivID);
      newNode.setAttribute("class", "dpDiv");
      newNode.setAttribute("style", "visibility: hidden;");
      document.body.appendChild(newNode);
    }
  
    var pickerDiv = document.getElementById(datePickerDivID);
    pickerDiv.style.position = "absolute";
    pickerDiv.style.left = x + "px";
    pickerDiv.style.top = y + "px";
    pickerDiv.style.visibility = (pickerDiv.style.visibility == "visible" ? "hidden" : "visible");
    pickerDiv.style.display = (pickerDiv.style.display == "block" ? "none" : "block");
    pickerDiv.style.zIndex = 10000;
  
    // draw the datepicker table
    refreshDatePicker(targetDateField.name, dt.getFullYear(), dt.getMonth(), dt.getDate());
  }

  function refreshDatePicker(dateFieldName, year, month, day)
  {

    var thisDay = new Date();
  
    if ((month >= 0) && (year > 0)) {
      thisDay = new Date(year, month, 1);
    } else {
      day = thisDay.getDate();
      thisDay.setDate(1);
    }
  
    var crlf = "\r\n";
    var TABLE = "<table cols=7 class='dpTable'>" + crlf;
    var xTABLE = "</table>" + crlf;
    var TR = "<tr class='dpTR'>";
    var TR_title = "<tr class='dpTitleTR'>";
    var TR_days = "<tr class='dpDayTR'>";
    var TR_todaybutton = "<tr class='dpTodayButtonTR'>";
    var xTR = "</tr>" + crlf;
    var TD = "<td class='dpTD' onMouseOut='this.className=\"dpTD\";' onMouseOver=' this.className=\"dpTDHover\";' ";    // leave this tag open, because we'll be adding an onClick event
    var TD_title = "<td colspan=5 class='dpTitleTD'>";
    var TD_buttons = "<td class='dpButtonTD'>";
    var TD_todaybutton = "<td colspan=7 class='dpTodayButtonTD'>";
    var TD_days = "<td class='dpDayTD'>";
    var TD_selected = "<td class='dpDayHighlightTD' onMouseOut='this.className=\"dpDayHighlightTD\";' onMouseOver='this.className=\"dpTDHover\";' ";    // leave this tag open, because we'll be adding an onClick event
    var xTD = "</td>" + crlf;
    var DIV_title = "<div class='dpTitleText'>";
    var DIV_selected = "<div class='dpDayHighlight'>";
    var xDIV = "</div>";
  
    // start generating the code for the calendar table
    var html = TABLE;
  
    // this is the title bar, which displays the month and the buttons to
    // go back to a previous month or forward to the next month
    html += TR_title;
    html += TD_buttons + getButtonCode(dateFieldName, thisDay, -1, "&lt;") + xTD;
    html += TD_title + DIV_title + monthArrayLong[ thisDay.getMonth()] + " " + thisDay.getFullYear() + xDIV + xTD;
    html += TD_buttons + getButtonCode(dateFieldName, thisDay, 1, "&gt;") + xTD;
    html += xTR;
  
    // this is the row that indicates which day of the week we're on
    html += TR_days;
    for(i = 0; i < dayArrayShort.length; i++)
      html += TD_days + dayArrayShort[i] + xTD;
    html += xTR;
  
    // now we'll start populating the table with days of the month
    html += TR;
  
    // first, the leading blanks
    for (i = 0; i < thisDay.getDay(); i++)
      html += TD + "&nbsp;" + xTD;
  
    // now, the days of the month
    do {
      dayNum = thisDay.getDate();
      TD_onclick = " onclick=\"updateDateField('" + dateFieldName + "', '" + getDateString(thisDay) + "');\">";
      
      if (dayNum == day)
        html += TD_selected + TD_onclick + DIV_selected + dayNum + xDIV + xTD;
      else
        html += TD + TD_onclick + dayNum + xTD;
      
      // if this is a Saturday, start a new row
      if (thisDay.getDay() == 6)
        html += xTR + TR;
      
      // increment the day
      thisDay.setDate(thisDay.getDate() + 1);
    } while (thisDay.getDate() > 1)
  
    // fill in any trailing blanks
    if (thisDay.getDay() > 0) {
      for (i = 6; i > thisDay.getDay(); i--)
        html += TD + "&nbsp;" + xTD;
    }
    html += xTR;
  
    // add a button to allow the user to easily return to today, or close the calendar
    var today = new Date();
    var todayString = "Today is " + dayArrayMed[today.getDay()] + ", " + monthArrayMed[ today.getMonth()] + " " + today.getDate();
    html += TR_todaybutton + TD_todaybutton;
    html += "<button class='dpTodayButton' onClick='refreshDatePicker(\"" + dateFieldName + "\");'>this month</button> ";
    html += "<button class='dpTodayButton' onClick='updateDateField(\"" + dateFieldName + "\");'>close</button>";
    html += xTD + xTR;
  
    // and finally, close the table
    html += xTABLE;
  
    document.getElementById(datePickerDivID).innerHTML = html;
    // add an "iFrame shim" to allow the datepicker to display above selection lists
    adjustiFrame();
  }


  /**
  Convenience function for writing the code for the buttons that bring us back or forward
  a month.
  */
  function getButtonCode(dateFieldName, dateVal, adjust, label)
  {
    var newMonth = (dateVal.getMonth () + adjust) % 12;
    var newYear = dateVal.getFullYear() + parseInt((dateVal.getMonth() + adjust) / 12);
    if (newMonth < 0) {
      newMonth += 12;
      newYear += -1;
    }
  
    return "<button class='dpButton' onClick='refreshDatePicker(\"" + dateFieldName + "\", " + newYear + ", " + newMonth + ");'>" + label + "</button>";
  }


  /**
  Convert a JavaScript Date object to a string, based on the dateFormat and dateSeparator
  variables at the beginning of this script library.
  */
  function getDateString(dateVal)
  {
    var dayString = "00" + dateVal.getDate();
    var monthString = "00" + (dateVal.getMonth()+1);
    dayString = dayString.substring(dayString.length - 2);
    monthString = monthString.substring(monthString.length - 2);
  
    switch (dateFormat) {
      case "dmy" :
        return dayString + dateSeparator + monthString + dateSeparator + dateVal.getFullYear();
      case "ymd" :
        return dateVal.getFullYear() + dateSeparator + monthString + dateSeparator + dayString;
      case "mdy" :
      default :
        return monthString + dateSeparator + dayString + dateSeparator + dateVal.getFullYear();
    }
  }


  /**
  Convert a string to a JavaScript Date object.
  */
  function getFieldDate(dateString)
  {
    var dateVal;
    var dArray;
    var d, m, y;
  
    try {
      dArray = splitDateString(dateString);
      if (dArray) {
        switch (dateFormat) {
          case "dmy" :
            d = parseInt(dArray[0], 10);
            m = parseInt(dArray[1], 10) - 1;
            y = parseInt(dArray[2], 10);
            break;
          case "ymd" :
            d = parseInt(dArray[2], 10);
            m = parseInt(dArray[1], 10) - 1;
            y = parseInt(dArray[0], 10);
            break;
          case "mdy" :
          default :
            d = parseInt(dArray[1], 10);
            m = parseInt(dArray[0], 10) - 1;
            y = parseInt(dArray[2], 10);
            break;
        }
        dateVal = new Date(y, m, d);
      } else if (dateString) {
        dateVal = new Date(dateString);
      } else {
        dateVal = new Date();
      }
    } catch(e) {
      dateVal = new Date();
    }
  
    return dateVal;
  }


  /**
  Try to split a date string into an array of elements, using common date separators.
  If the date is split, an array is returned; otherwise, we just return false.
  */
  function splitDateString(dateString)
  {
    var dArray;
    if (dateString.indexOf("/") >= 0)
      dArray = dateString.split("/");
    else if (dateString.indexOf(".") >= 0)
      dArray = dateString.split(".");
    else if (dateString.indexOf("-") >= 0)
      dArray = dateString.split("-");
    else if (dateString.indexOf("\\") >= 0)
      dArray = dateString.split("\\");
    else
      dArray = false;
  
    return dArray;
  }
  function updateDateField(dateFieldName, dateString)
  {
    var targetDateField = document.getElementsByName (dateFieldName).item(0);
    if (dateString)
      targetDateField.value = dateString;
  
    var pickerDiv = document.getElementById(datePickerDivID);
    pickerDiv.style.visibility = "hidden";
    pickerDiv.style.display = "none";
  
    adjustiFrame();
    targetDateField.focus();
  
    // after the datepicker has closed, optionally run a user-defined function called
    // datePickerClosed, passing the field that was just updated as a parameter
    // (note that this will only run if the user actually selected a date from the datepicker)
    if ((dateString) && (typeof(datePickerClosed) == "function"))
      datePickerClosed(targetDateField);
  }

  function adjustiFrame(pickerDiv, iFrameDiv)
  {

    var is_opera = (navigator.userAgent.toLowerCase().indexOf("opera") != -1);
    if (is_opera)
      return;

    try {
      if (!document.getElementById(iFrameDivID)) {

        var newNode = document.createElement("iFrame");
        newNode.setAttribute("id", iFrameDivID);
        newNode.setAttribute("src", "javascript:false;");
        newNode.setAttribute("scrolling", "no");
        newNode.setAttribute ("frameborder", "0");
        document.body.appendChild(newNode);
      }
      
      if (!pickerDiv)
        pickerDiv = document.getElementById(datePickerDivID);
      if (!iFrameDiv)
        iFrameDiv = document.getElementById(iFrameDivID);
      
      try {
        iFrameDiv.style.position = "absolute";
        iFrameDiv.style.width = pickerDiv.offsetWidth;
        iFrameDiv.style.height = pickerDiv.offsetHeight ;
        iFrameDiv.style.top = pickerDiv.style.top;
        iFrameDiv.style.left = pickerDiv.style.left;
        iFrameDiv.style.zIndex = pickerDiv.style.zIndex - 1;
        iFrameDiv.style.visibility = pickerDiv.style.visibility ;
        iFrameDiv.style.display = pickerDiv.style.display;
      } catch(e) {
      }
  
    } catch (ee) {
    }
  
  }


  </script>

  <style>
  .dpDiv {
    }

  .dpTable {
    font-family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 12px;
    text-align: center;
    color: #505050;
    background-color: #ece9d8;
    border: 1px solid #AAAAAA;
    }


  /* a table row that holds date numbers (either blank or 1-31) */
  .dpTR {
    }


  /* the top table row that holds the month, year, and forward/backward buttons */
  .dpTitleTR {
    }


  /* the second table row, that holds the names of days of the week (Mo, Tu, We, etc.) */
  .dpDayTR {
    }


  /* the bottom table row, that has the "This Month" and "Close" buttons */
  .dpTodayButtonTR {
    }


  /* a table cell that holds a date number (either blank or 1-31) */
  .dpTD {
    border: 1px solid #ece9d8;
    }


  /* a table cell that holds a highlighted day (usually either today's date or the current date field value) */
  .dpDayHighlightTD {
    background-color: #CCCCCC;
    border: 1px solid #AAAAAA;
    }


  /* the date number table cell that the mouse pointer is currently over (you can use contrasting colors to make it apparent which cell is being hovered over) */
  .dpTDHover {
    background-color: #aca998;
    border: 1px solid #888888;
    cursor: pointer;
    color: red;
    }


  /* the table cell that holds the name of the month and the year */
  .dpTitleTD {
    }


  /* a table cell that holds one of the forward/backward buttons */
  .dpButtonTD {
    }


  /* the table cell that holds the "This Month" or "Close" button at the bottom */
  .dpTodayButtonTD {
    }


  /* a table cell that holds the names of days of the week (Mo, Tu, We, etc.) */
  .dpDayTD {
    background-color: #CCCCCC;
    border: 1px solid #AAAAAA;
    color: white;
    }


  /* additional style information for the text that indicates the month and year */
  .dpTitleText {
    font-size: 12px;
    color: gray;
    font-weight: bold;
    }


  /* additional style information for the cell that holds a highlighted day (usually either today's date or the current date field value) */ 
  .dpDayHighlight {
    color: 4060ff;
    font-weight: bold;
    }


  /* the forward/backward buttons at the top */
  .dpButton {
    font-family: Verdana, Tahoma, Arial, Helvetica, sans-serif;
    font-size: 10px;
    color: gray;
    background: #d8e8ff;
    font-weight: bold;
    padding: 0px;
    }


  /* the "This Month" and "Close" buttons at the bottom */
  .dpTodayButton {
    font-family: Verdana, Tahoma, Arial, Helvetica, sans-serif;
    font-size: 10px;
    color: gray;
    background: #d8e8ff;
    font-weight: bold;
    }
  .text{
  font-family:Verdana, Arial, Helvetica, sans-serif;
  font-size:11px;
  color:#333333;
  font-weight:bold;
  }

  </style>
  </head>
  <body>
      <div id="wrapper">
          <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
              <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" style="padding: 5px 15px;" href="welcome.php"><img src="assets/img/logo.png" style="height:65px;"/></a> 
              </div>
    <div style="color: #000;
  padding: 15px 50px 5px 50px;
  float: right;
  font-size: 16px;">Date: <?php echo date('d-m-Y')?> &nbsp; <a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a> </div>
          </nav>   
            <!-- /. NAV TOP  -->
                  <nav class="navbar-default navbar-side" role="navigation">
              <div class="sidebar-collapse">
                  <ul class="nav" id="main-menu">
          <li class="text-center">
                    
            </li>
          
                      <li>
                          <a class="active-menu"  href="welcome.php"><i class="fa fa-dashboard "></i> Dashboard</a>
                      </li>
            <?php if($_SESSION['admin-type'] =='Admin'){?>
                      <li>
                          <a  href="change-password.php"><i class="fa fa-desktop"></i>Change Password</a>
                      </li>
            <li>
                          <a  href="category-mgmt.php"><i class="fa fa-qrcode "></i> Category Management</a>
                          </li> <li>
                          <a  href="subcategory-mgmt.php"><i class="fa fa-qrcode "></i> Subcategory Management</a>
                          </li>
                      <li>
                          <a  href="service-mgmt.php"><i class="fa fa-qrcode"></i> Service Management</a>
                          </li>
                <li>
                          <a  href="caller-mgmt.php"><i class="fa fa-qrcode "></i> Caller Management</a>
                          </li>
              <li>
                          <a  href="user-mgmt.php"><i class="fa fa-qrcode "></i> Register Management</a>
                          </li>	
                          <li>
                          <a href="admin-mgmt.php"><i class="fa fa-user"></i> Admin Management</a>
                        </li>

              <?php } elseif($_SESSION['admin-type'] == 'Editor') { ?>
                <li>
                          <a  href="category-mgmt.php"><i class="fa fa-qrcode "></i> Category Management</a>
                          </li> <li>
                          <a  href="subcategory-mgmt.php"><i class="fa fa-qrcode "></i> Subcategory Management</a>
                          </li>
                      <li>
                          <a  href="service-mgmt.php"><i class="fa fa-qrcode"></i> Service Management</a>
                          </li>
                <li>
                          <a  href="caller-mgmt.php"><i class="fa fa-qrcode "></i> Caller Management</a>
                          </li>
              <li>
                          <a  href="user-mgmt.php"><i class="fa fa-qrcode "></i> Register Management</a>
                          </li>	
              <?php } ?>
              <!-- <li>
                          <a  href="click.php"><i class="fa fa-qrcode "></i> Clicks Management</a>
                          </li>	-->	
                  </ul>
                
              </div>
              
          </nav>  
          <!-- /. NAV SIDE  -->
          <div id="page-wrapper" >
              <div id="page-inner">
                  <div class="row">
                      <div class="col-md-12">
                      <h2> Dashboard</h2>   
                          <h5>Welcome <b><?php echo $_SESSION['username'];?> </b>. </h5>
                      </div>
                  </div>              
                  <!-- /. ROW  -->
                    <hr />
                