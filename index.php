<!DOCTYPE html>
<!--[if IE 7]> <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
<title>OSSEC Management</title>
<!-- TemplateParam name="theme" type="text" value="cardinal" -->

<!-- Meta -->
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="OSSEC Management" />
<meta name="author" content="Darren Patterson" />

<!-- CSS -->
<link rel="stylesheet" href="assets/cardinal/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="assets/cardinal/css/base.min.css?v=0.1" type="text/css" />
<link rel="stylesheet" href="assets/cardinal/css/custom.css?v=0.1" type="text/css"/>
<!--[if lt IE 9]>
  <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE 8]>
  <link rel="stylesheet" type="text/css" href="assets/cardinal/css/ie/ie8.css" />
<![endif]-->
<!--[if IE 7]>
  <link rel="stylesheet" type="text/css" href="assets/cardinal/css/ie/ie7.css" />
<![endif]-->
<!-- JS and jQuery --> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> 
<script src="assets/cardinal/js/modernizr.custom.17475.js"></script> 
<script src="assets/cardinal/js/bootstrap.min.js"></script> 

<!--[if lt IE 9]>
    <script src="assets/cardinal/js/respond.js"></script>
<![endif]--> 

<!-- custom JS -->
<script src="assets/cardinal/js/base.js?v=1.0"></script>
<script src="assets/cardinal/js/custom.js"></script>
<script src="/ossec/jquery-ui-1.11.1/jquery-ui.min.js" type="text/javascript"></script>
<link href="/ossec/jquery-ui-1.11.1/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="/ossec/jquery-ui-1.11.1/jquery-ui.theme.css" rel="stylesheet" type="text/css" />

<!-- Include one of jTable styles. -->
<link href="/ossec/jtable.2.4.0/themes/metro/lightgray/jtable.min.css" rel="stylesheet" type="text/css" />
<!-- Include jTable script file. -->
<script src="/ossec/jtable.2.4.0/jquery.jtable.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#ossecContainer').jtable({
            sorting: false,
            paging: false,
            title: 'OSSEC Clients',
            selecting: true,
            multiselect: true,
            selectingCheckboxes: true,
            selectOnRowClick: false,
            //paging: true,
            actions: {
                listAction: '/ossec/List.php',
                createAction: '/ossec/Create.php',
                deleteAction: '/ossec/Delete.php'
            },
            fields: {
                SystemId: {
                    title: 'ID',
                    key: true,
                    edit: false,
                    create: false,
                    // comment out below for debug to see ID
                    list: false
                },
                Info: {
                    title: '<span class="ui-icon ui-icon-info"></span>',
                    edit: false,
                    create: false,
                    width: '5%',
                    display: function (infoData) {
                        //Create an image that will be used to open child table
                        var $img = $('<span class="ui-icon ui-icon-info"></span>');
                        //Open child table when user clicks the image
                        $img.click(function () {

                            $('#ossecContainer').jtable('openChildTable',
                                    $img.closest('tr'), //Parent row
                                    {
                                    title:  'Info - ' + infoData.record.Name,
                                    actions: {
                                        listAction: '/ossec/Info.php?SystemId=' + infoData.record.SystemId,
                                    },
                                    fields: {
                                        SystemId: {
                                            type: 'hidden',
                                            key: true,
                                            create: false,
                                            edit: false,
                                            list: false,
                                            defaultValue: infoData.record.SystemId
                                        },
                                        Report: {
                                            create: false,
                                            edit: false,
                                            defaultValue: infoData.record.Report
                                        },
                                    }
                                }, function (data) { //opened handler
                                    data.childTable.jtable('load');
                                });
                        });
                        //Return image to show on the person row
                        return $img;
                    }
                },
                Syscheck: {
                    title: 'Sys',
                    width: '5%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function (reportData) {
                        //Create an image that will be used to open child table
                        var $img = $('<img src="/ossec/list_metro.png" title="View Syscheck Report" name="syscheck" id="syscheck"/>');
                        //Open child table when user clicks the image
                        $img.click(function () {

                        /* todo figure out how to set deleteConfirmation */
                            $('#ossecContainer').jtable('openChildTable',
                                    $img.closest('tr'), //Parent row
                                    {
                                    title:  'Syscheck Report - ' + reportData.record.Name,
                                    actions: {
                                        listAction: '/ossec/SyscheckReport.php?SystemId=' + reportData.record.SystemId,
                                        deleteAction: '/ossec/SyscheckReportClear.php?SystemId=' + reportData.record.SystemId,
                                    },
                                    fields: {
                                        SystemId: {
                                            type: 'hidden',
                                            key: true,
                                            create: false,
                                            edit: false,
                                            list: false,
                                            defaultValue: reportData.record.SystemId
                                        },
                                        Report: {
                                            create: false,
                                            edit: false,
                                            defaultValue: reportData.record.Report
                                        },
                                    }
                                }, function (data) { //opened handler
                                    data.childTable.jtable('load');
                                });
                        });
                        /*var childMessages = {
                            deleteConfirmation: 'Clear syscheck report for ' + reportData.record.Name + '?'
                        };
                                $('#ossecContainer').jtable('openChildTable',
                                    { 
                                    messages: childMessages,
                                    },
                                );*/
                        //Return image to show on the person row
                        return $img;
                    }
                },
                Rootcheck: {
                    title: 'Root',
                    width: '5%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function (rootData) {
                        //Create an image that will be used to open child table
                        var $img = $('<img src="/ossec/list_metro.png" title="View Rootcheck Report" name="rootcheck" id="rootcheck"/>');
                        //Open child table when user clicks the image
                        $img.click(function () {
                        /* todo figure out how to set deleteConfirmation */
                            $('#ossecContainer').jtable('openChildTable',
                                    $img.closest('tr'), //Parent row
                                    {
                                    title: 'Rootcheck Report - ' + rootData.record.Name,
                                    actions: {
                                        listAction: '/ossec/RootReport.php?SystemId=' + rootData.record.SystemId,
                                        deleteAction: '/ossec/RootReportClear.php?SystemId=' + rootData.record.SystemId,
                                    },
                                    fields: {
                                        SystemId: {
                                            type: 'hidden',
                                            key: true,
                                            create: false,
                                            edit: false,
                                            list: false,
                                            defaultValue: rootData.record.SystemId
                                        },
                                        Report: {
                                            create: false,
                                            edit: false,
                                            defaultValue: rootData.record.Report
                                        },
                                    }
                                }, function (data) { //opened handler
                                    data.childTable.jtable('load');
                                });
                        });
                        /*var childMessages = {
                            deleteConfirmation: 'Clear rootcheck report for ' + reportData.record.Name + '?'
                        };
                                $('#ossecContainer').jtable('openChildTable',
                                    { 
                                    messages: childMessages,
                                    },
                                );*/
                        //Return image to show on the person row
                        return $img;
                    }
                },
                Key: {
                    edit: false,
                    width: '5%',
                    create: false,
                    title: 'Key',
                    display: function (keyData) {
                        //Create an image that will be used to open child table
                        var $img = $('<span class="ui-icon ui-icon-key"></span>');
                        //Open child table when user clicks the image
                        $img.click(function () {
                            $('#ossecContainer').jtable('openChildTable',
                                    $img.closest('tr'), //Parent row
                                    {
                                    title: 'System Key - ' + keyData.record.Name,
                                    actions: {
                                        listAction: '/ossec/Key.php?SystemId=' + keyData.record.SystemId,
                                    },
                                    fields: {
                                        SystemId: {
                                            type: 'hidden',
                                            key: true,
                                            create: false,
                                            edit: false,
                                            list: false,
                                            defaultValue: keyData.record.SystemId
                                        },
                                        Report: {
                                            create: false,
                                            edit: false,
                                            defaultValue: keyData.record.Report
                                        },
                                    }
                                }, function (data) { //opened handler
                                    data.childTable.jtable('load');
                                });
                        });
                        //Return image to show on the person row
                        return $img;
                    }
                },
                Name: {
                    edit: false,
                    title: 'Host Name',
                    width: '40%'
                },
                IP: {
                    edit: false,
                    title: 'IP Address',
                    width: '20%',
                    create: false
                },
                Active: {
                    title: 'Status',
                    width: '20%',
                    create: false,
                    edit: false
                }
            }
        });
        //Re-load records when user click 'load records' button.
        $('#LoadRecordsButton').click(function (e) {
            e.preventDefault();
            $('#ossecContainer').jtable('load', {
                Name: $('#name').val()
            });
        });
        //Load all records when page is first shown
        $('#LoadRecordsButton').click();
    
      });

      function ExpandSysButton() {
            var $selectedRows = $('#ossecContainer').jtable('selectedRows');
            $selectedRows.each(function() {
                $(this).find("img").first().trigger('click');
            });
      }
      
      function ExpandRootButton() {
            var $selectedRows = $('#ossecContainer').jtable('selectedRows');
            $selectedRows.each(function() {
                $(this).find("img").last().trigger('click');
            });
      }
      
      function UpdateSysAll() {
       $("#dialog-confirm").html("Are you sure you want to clear/update all syscheck reports? This should only be done after reviewing all reports.");

        // Define the Dialog and its properties.
        $("#dialog-confirm").dialog({
            resizable: false,
            modal: true,
            title: "Confirm you want to clear rootcheck for ALL",
            height: 250,
            width: 400,
            buttons: {
                "No": function () {
                    $(this).dialog('close');
                },
                "Yes": function () {
                    $(this).dialog('close');
                    callback('/ossec/RootReportClear.php?SystemId=all');
                }
            }
        });
      }

      function callback(value) {
         var request = $.ajax({
              type: "GET",
              url: value,
              dataType: "html" 
          });
      } 

      function UpdateRootAll() {
        $("#dialog-confirm").html("Are you sure you want to clear/update all rootcheck reports? This should only be done after reviewing all reports.");

        // Define the Dialog and its properties.
        $("#dialog-confirm").dialog({
            resizable: false,
            modal: true,
            title: "Confirm you want to clear Syscheck for ALL",
            height: 250,
            width: 400,
            buttons: {
                "No": function () {
                    $(this).dialog('close');
                },
                "Yes": function () {
                    $(this).dialog('close');
                    callback('/ossec/SyscheckReportClear.php?SystemId=all');
                }
            }
        });

      }


      
</script>


</head>

<body class="home"> <!-- class="home" underlines the Home link in the top nav -->
    
    <!--=== Top ===-->
    <div id="top">
      <div class="container"> 
        <!--=== Skip links ===-->
        <div id="skip"> <a href="#content" onClick="$('#content').focus()">Skip to content</a> </div>
        <!-- /Skip links --> 
      </div>
    </div>
    <!--/top--> 
    
    <!--=== Header ===-->
    <div id="header" class="clearfix" role="banner">
      <div class="container">
        <div class="row">
          <div class="col-md-8"> 
            <!-- Logo -->
            <div id="logo" class="clearfix"> <a href="http://www.stanford.edu/"><img class="img-responsive" src="assets/cardinal/images/stanford-white@2x.png"  alt="Stanford University" /></a> </div>
            <!-- /logo -->
            <div id="signature">
              <div id="site-name">
                <a href="/">
                  <span id="site-name-1">OSSEC Management</span>
                  <span id="site-name-2">Optional line 2 - add two-line-signature to body class to display</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Menu -->
    <div id="mainmenu" class="clearfix" role="navigation">
      <div class="container">
        <div class="navbar navbar-default"> 
          
          <!-- main navigation -->
          <button type="button" class="navbar-toggle btn-navbar" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="menu-text">Menu</span></button>
          <!-- /nav-collapse -->
          
            <!--
          <div class="navbar-collapse collapse"> 
            <div id="nav-search" role="search">
              <form action="http://www.stanford.edu/search" method="get" id="search-form" accept-charset="UTF-8">
                <h2 class="hidden">Search form</h2>
                <label class="hidden" for="search-field">Search term</label>
                <input name="cx" type="hidden" value="003265255082301896483:sq5n7qoyfh8">
                <input name="cof" type="hidden" value="FORID:9">
                <input name="ie" type="hidden" value="UTF-8">
                <input name="as_sitesearch" type="hidden" value="facts.stanford.edu">
                <input title="Search string" class="input-medium" placeholder="Search this site&hellip;" type="text" id="search-field" name="q" value="" size="15" maxlength="128" />
                <button id="search-btn" type="submit" name="submit"  aria-label="Search" formmethod="get"><i class="fa fa-search"></i></button>
              </form>
            </div>
              -->
            <div  role="navigation">
              <div id="primary-nav">
                <ul class="nav navbar-nav" aria-label="primary navigation">
                  <li id="nav-home"> <a href="./">Home</a></li>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- /nav-collapse --> 
        </div>
        <!-- /navbar --> 
        
      </div>
      <!-- /container --> 
    </div>
    <!-- /mainmenu --> 
    
    <!-- main content -->
    <div id="content" class="container" role="main" tabindex="0">
      <div class="row">
                <!-- Main column -->
        <div id="main-content" class="col-md-9 col-md-push-3" role="main">
            <!-- insert ossec html here -->
           <div class="filtering">
              <p>
                <form>
                    Search host name: <input type="text" name="name" id="name" />
                    <button type="submit" id="LoadRecordsButton">Find Server</button>
                </form>
                <br />
              </p>
              <p>
                <button onclick="ExpandSysButton();">Expand syscheck for selected</button>
                <button onclick="ExpandRootButton();">Expand rootcheck for selected</button>
              </p>
              
          </div>
          <div id="ossecContainer"></div>
          <div>
            <p />
            <p>
            <button onclick="UpdateSysAll();">Update syscheck for ALL</button>
            <button onclick="UpdateRootAll();">Update rootcheck for ALL</button>
            <div id="dialog-confirm"></div>
            </p>
          </div>
        </div>
        <div id="sidebar-second" class="col-md-3 col-md-pull-9">
          <div class="well">
            <h2>About OSSEC Management</h2>
            <p>The following management interface is built on jtable/jquery.</p>
            <p>Use the "Add new record" button (top right in the table) to add a new OSSEC client (add using the FQDN only). Retrieve the agent key by clicking in the "Key" column for the new server. To delete a OSSEC client, click the trash icon in the row listing the server.</p>
            <p>The two left columns for "Sys" and "Root" expand down when you click the icon to show you syscheck and rootcheck reports respectively.  Once these are expanded, you can click the X in the top right of the drop-down table to close the view, or click the trash icon to clear the syscheck or rootcheck report.  Be careful to click the correct trash icon in the report sub-table row instead of the system list.</p>
            <p>Access control is managed via webauth for workgroup crc:crcsg</p>
          </div>
          <div class="well">
          <h2>Related Tools</h2>
          <p>For those who want to use the command line, there are remctl tools available using your root principal.  Specific commands are:
          <ul>
          <li>remctl crclogs syscheck ...</li>
          <li>remctl crclogs rootcheck ...</li>
          <li>remctl crclogs list_agents ...</li>
          <li>remctl crclogs agent_control ...</li>
          <li>remctl crclogs ossecadd ...</li>
          <li>remctl crclogs ossecdel ...</li>
          </ul>
      </div>
    </div>
    <!-- #content--> 
    
  </div>
  <!-- #su-content --> 
</div>
<!-- #su-wrap --> 

<!-- BEGIN footer -->
<div id="footer" class="clearfix footer" role="contentinfo">
  <!-- Fat footer start -->
  <div class="container">
    <div id="footer-content" class="row">
      <div class="col-xs-12 col-sm-6 col-sm-push-3">
        <h3>Feedback...</h3>
        <p>Please let Darren know if you find bugs or issues.  Current open issues are: 
            <ul>
                <li>- Customize confirmation messages for syscheck and rootcheck delete/clear.</li>
            </ul>
        </p>
      </div>
      <div class="col-xs-12 col-sm-3 col-sm-push-3">
        <h3>Related Links</h3>
        <ul>
          <li><a href="https://itarch.stanford.edu/confluence/display/CRCSRVRGRP/OSSEC">OSSEC Confluence Documentation</a></li>
          <li><a href="http://ossec.net/">OSSEC.net</a></li>
        </ul>
      </div>
     </div>
  </div>
  <!-- Fat footer end -->
  
  <!-- Global footer snippet start -->
  <div id="global-footer">
    <div class="container">
      <div class="row">
        <div id="bottom-logo" class="col-xs-6 col-sm-2"> <a href="http://www.stanford.edu"> <img src="assets/cardinal/images/footer-stanford-logo@2x.png" alt="Stanford University" width="105" height="49"/> </a> </div>
        <!-- #bottom-logo end -->
        <div id="bottom-text" class="col-xs-6 col-sm-10">
          <ul>
            <li class="home"><a href="http://www.stanford.edu">SU Home</a></li>
            <li class="maps alt"><a href="http://visit.stanford.edu/plan/maps.html" class="su-link" data-ua-action="visit.stanford.edu/plan/maps" data-ua-label="global-footer">Maps &amp; Directions</a></li>
            <li class="search-stanford"><a href="http://stanford.edu/search/">Search Stanford</a></li>
            <li class="terms alt"><a href="http://www.stanford.edu/site/terms.html">Terms of Use</a></li>
            <li class="emergency-info"><a href="http://emergency.stanford.edu/" class="su-link" data-ua-label="global-footer">Emergency Info</a></li>
          </ul>
        </div>
        <!-- .bottom-text end -->
        <div class="clear"></div>
        <p class="copyright vcard col-sm-10">&copy; <span class="fn org">Stanford University</span>.&nbsp; <span class="adr"> <span class="locality">Stanford</span>, <span class="region">California</span> <span class="postal-code">94305</span></span>. <span id="termsofuse"><a href="http://www.stanford.edu/group/security/dmca.html" class="su-link" data-ua-action="copyright-complaints" data-ua-label="global-footer">Copyright Complaints</a>&nbsp;&nbsp;&nbsp;<a href="https://adminguide.stanford.edu/chapter-1/subchapter-5/policy-1-5-4" class="su-link" data-ua-action="trademark-notice" data-ua-label="global-footer">Trademark Notice</a></span></p>
      </div>
      <!-- .row end --> 
    </div>
    <!-- .container end --> 
  <!-- Global footer snippet end --> 
  
<!-- END footer --> 

</body>
</html>

