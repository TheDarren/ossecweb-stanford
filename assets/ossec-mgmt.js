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
          Name: $('#name').val(),
          Sysadmin: $('#sysadmin').prop('checked')
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
              callback('/ossec/SyscheckReportClear.php?SystemId=all');
              $('#LoadRecordsButton').click();
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
              callback('/ossec/RootReportClear.php?SystemId=all');
              $('#LoadRecordsButton').click();
          }
      }
  });

}

