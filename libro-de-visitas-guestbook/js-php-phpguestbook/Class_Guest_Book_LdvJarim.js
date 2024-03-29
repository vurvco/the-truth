jQuery(document).ready(function($) {
  //INITIALIZE VARIABLES
  //PATHS - NOT USED IN WP AJAX ENVIRONMENT
  //var myplugingpath = $("#myplugingpath").text();
  //localStorage["libro_de_visita.my_pluging_path"] = myplugingpath ;
  //alert("myplugingpath" +myplugingpath);

  //CLOSE MESSAGES BUTTON
  $("body").on("click", "#close_button_Messages", function() {
    $("#overlayMessages").css("display", "none");
  }); //END ONCLICK

  //WRITE MESSAGE FUNCTION 1 OF 2
  function messagesWriteNewMessage(myMessage, divAllMessages, myTimeout) {
    /* CALL
    var myTimeout=8000;
    var myMessage='El mensaje enviado es muy largo o muy corto';
    var divAllMessages='divAllMessages';
    messagesWriteNewMessage(myMessage,divAllMessages);
    */
    //alert(myMessage);
    $("#overlayMessages").css("display", "block");
    $("#" + divAllMessages).html(myMessage);
    $("#" + divAllMessages).css("display", "block");

    setTimeout(function() {
      $("#" + divAllMessages).css("display", "none");
      $("#overlayMessages").css("display", "none");
    }, myTimeout); // <-- time in milliseconds
  }

  //WRITE MESSAGE FUNCTION 2 OF 2
  /*!!!!SET TO ENGLISH BY DEFAULT!!!!!!!*/
  function multilanguageMessage(
    myMessageSpanish,
    myMessageEnglish,
    timeToShowSeconds
  ) {
    /*!!!!SET TO ENGLISH BY DEFAULT!!!!!!!*/
    var myuserlanguage = "English"; //localStorage["poorbuk.myuserlanguage"];
    //alert(myuserlanguage);
    if (!myuserlanguage) {
      myuserlanguage = "Spanish";
    }

    if (myuserlanguage == "") {
      myuserlanguage = "Spanish";
    }

    if (myuserlanguage == "Spanish") {
      var myMessage = myMessageSpanish;
    }
    if (myuserlanguage == "English") {
      var myMessage = myMessageEnglish;
    }
    //alert(myMessage);
    var divAllMessages = "divAllMessages";
    var myTimeout = timeToShowSeconds * 1000;
    messagesWriteNewMessage(myMessage, divAllMessages, myTimeout);
  } //END multilanguageMessage

  /******END MESSAGES MODUL********/

  /******STATUS MODUL********/
  function setStatus(theStatus, myDivId) {
    /*CALL
     * setStatus("Loading...", "divLoadingStatus");
     * setStatus("Finished", "divLoadingStatus");
     */

    //    alert(myDivId);
    //    alert(theStatus);
    if (theStatus == "Loading...") {
      $("#overlayStatus").css("display", "block");
      $("#" + myDivId).css("display", "block");
    }
    if (theStatus == "Finished") {
      //        setTimeout(function()
      //        {
      $("#" + myDivId).css("display", "none");
      $("#overlayStatus").css("display", "none");
      //        }, 1000);
    }
  }

  /******END STATUS MODUL********/

  /******SUBMIT MESSAGE TO DATABASE AJAX MODUL********/

  $("body").on("click", "#mySubmitGuestBook", function() {
    var myDivTextHtml = $("#myEditableDivGuestBook_Message").text();
    var myusername = "trash";
    //alert("myDivTextHtml= "+myDivTextHtml +" myusername= "+ myusername);

    if (myDivTextHtml != "") {
      setStatus("Loading...", "divLoadingStatus");

      /*START AJAX POST DATA*/
      //alert ("ajax_object.ajax_url = "+ajax_object.ajax_url+"ajax_object.we_value = "+ ajax_object.we_value);
      var data = {
        action: "insertPost_Guest_book_JarimAjaxJS",
        postcontentPosted: myDivTextHtml,
        myusername: myusername
        //,'whatever': ajax_object.we_value      // We pass php values differently!
      };
      // We can also pass the url value separately from ajaxurl for front end AJAX implementations
      $.post(ajax_object.ajax_url, data, function(response) {
        //alert(response);
        var mytime = "";
        setStatus("Finished", "divLoadingStatus");
        phpfrontShowPostDB(mytime);
        //RESET MAIN DIV TO WRITE POST
        $("#myEditableDivGuestBook_Message").html("");
        //$('#nameguessbook').val("");
      });
      /*END AJAX POST DATA*/
    } else {
      if (myusername == "") {
        //MULTILANGUAGE MESSAGE
        var myMessageSpanish = "No has puesto el nombre";
        var myMessageEnglish = $(
          "#librodevisitas-hidden-name-validation"
        ).text();
        //var myMessageEnglish="You don't wrote your name";
        timeToShowSeconds = 5;
        multilanguageMessage(
          myMessageSpanish,
          myMessageEnglish,
          timeToShowSeconds
        );
        //END MULTILANGUAGE MESSAGE
      }
      if (myDivTextHtml == "") {
        //MULTILANGUAGE MESSAGE
        var myMessageSpanish = "El mensaje es muy largo o está en blanco";
        var myMessageEnglish = $(
          "#librodevisitas-hidden-message-validation"
        ).text();
        //var myMessageEnglish="The message is too short or too long";
        timeToShowSeconds = 5;
        multilanguageMessage(
          myMessageSpanish,
          myMessageEnglish,
          timeToShowSeconds
        );
        //END MULTILANGUAGE MESSAGE
      }
    }
  });

  /******END SUBMIT MESSAGE TO DATABASE AJAX MODUL********/

  /******SHOW ALL MESSAGES FROM DATABASE AT START AJAX MODUL********/
  function phpfrontShowPostDB(mytime) {
    setStatus("Loading...", "divLoadingStatus");
    //var myuserid = localStorage["poorbuk.myuserid"];

    /*START AJAX POST DATA*/
    //alert ("ajax_object.ajax_url = "+ajax_object.ajax_url+"ajax_object.we_value = "+ ajax_object.we_value);
    var data = {
      action: "showAllPosts_Guest_book_JarimAjaxJS"
      //,'whatever': ajax_object.we_value      // We pass php values differently!
    };
    // We can also pass the url value separately from ajaxurl for front end AJAX implementations
    $.post(ajax_object.ajax_url, data, function(response) {
      //alert(response);
      $("#httpShowPostFromStartjsAndmyTextEditorDBShowPostphp").html(response);
      //STOP STATUS
      setStatus("Finished", "divLoadingStatus");
    });
    /*END AJAX POST DATA*/
  }
  /******SHOW ALL MESSAGES FROM DATABASE AT START AJAX MODUL********/

  //INITIALIZE
  $("#myEditableDivGuestBook_Message").html("");
  $("#nameguessbook").val("");
  var mytime = "";
  phpfrontShowPostDB(mytime);
  //ENSURE THAT STATUS OVERLAY STOP NO MATTER WHAT
  setTimeout(function() {
    setStatus("Finished", "divLoadingStatus");
  }, 3000);
});
