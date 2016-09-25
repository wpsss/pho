jQuery(document).ready(function($)
{
  "use strict";
  
  $(".nav-tab").click(function()
  {
    var tabID = this.dataset.tabId;
    $(".nav-tab").removeClass("tab-active");
    $(this).addClass("tab-active");
    $(".settings-table").hide();
    $(tabID).show();
  });

  var selectBox = $("#paginav-select-box"),
      paginavMidSize = $("#paginav-mid-size");

  selectBox.change(function()
  {
    if (selectBox.val() === "1") {
      paginavMidSize.show();
    } else {
      paginavMidSize.hide()
    }
  });
});
