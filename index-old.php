<html>
<head>

<script src="/ossec/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="/ossec/jquery-ui-1.11.1/jquery-ui.min.js" type="text/javascript"></script>
<link href="/ossec/jquery-ui-1.11.1/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="/ossec/jquery-ui-1.11.1/jquery-ui.theme.css" rel="stylesheet" type="text/css" />

<!-- Include one of jTable styles. -->
<link href="/ossec/jtable.2.4.0/themes/metro/blue/jtable.min.css" rel="stylesheet" type="text/css" />
<!-- Include jTable script file. -->
<script src="/ossec/jtable.2.4.0/jquery.jtable.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#ossecContainer').jtable({
            sorting: false,
            paging: false,
            title: 'OSSEC Clients',
            actions: {
                listAction: '/ossec/List.php',
                createAction: '/ossec/Create.php',
                //updateAction: '/ossec/Update.php',
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
                Report: {
                    title: 'Sys',
                    width: '5%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function (reportData) {
                        //Create an image that will be used to open child table
                        var $img = $('<img src="/ossec/list_metro.png" title="View Syscheck Report" />');
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
                        var $img = $('<img src="/ossec/list_metro.png" title="View Rootcheck Report" />');
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
                    title: 'Active/Non-Active',
                    width: '30%',
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
        //$('#ossecContainer').jtable('load');
    });
</script>

</head>
<body>
<div class="filtering">
    <form>
        Host Name: <input type="text" name="name" id="name" />
        <button type="submit" id="LoadRecordsButton">Find Server</button>
    </form>
</div>
<div id="ossecContainer"></div>
</body>
</html>
