<?php
/* Template Name:libro-de-visitas-jarim1
 * Description: Template for libro de visitas - guestbook // Show all messages and allow to Insert new ones
 */
get_header();

?>
<style>
/*NO PAGE TITLE FOR THIS PAGE*/
.entry-title{display:none;}
</style>

<div style="display:none;" id="myplugingpath"><?php echo plugins_url();?></div>
<div style="display:none;" id="librodevisitas-hidden-name-validation"><?php echo LIBRO_DE_VISITAS_NAME_VALIDATION;?></div>
<div style="display:none;" id="librodevisitas-hidden-message-validation"><?php echo LIBRO_DE_VISITAS_MESSAGE_VALIDATION;?></div>

<div     class="allContentWrapperGuessBook" style="">


    <!-- <h1><?php echo LIBRO_DE_VISITAS_PAGE_TITLE; ?></h1><br> -->
<!--
    <div class="labelInput" style="font-size:18px !important;" >* <?php echo LIBRO_DE_VISITAS_LABEL_NAME; ?></div>

    <div>
        <input  maxlength="30" style="min-width:200px;" type="text" id="nameguessbook" placeholder="" name="name"  >
    </div> -->

    <br><br>

    <div class="labelInput" style="font-size:18px !important;" >What is your secret?</div>
    <!--*********MAIN TEXT EDITOR (myDiv) *************PaleGoldenRod************************************-->


    <div id="mainTextWrapperVisitas">
        <div style="" id="myEditableDivGuestBook_Message" contenteditable="true" ></div>

        <br><br>
        <div id="mySubmitGuestBook" class="buttonGuestbook" >Tell the Truth
  <div class="btn2"></div>
</div>
        <!-- <button  id="mySubmitGuestBook" class="buttonGuestbook" ><?php echo LIBRO_DE_VISITAS_TEXT_BUTTON; ?></button>
    </div> -->

    <br><br>


    <div style="clear:both;" id = "clearAll"></div>
    <!--*****************************SHOW NEW POSTS ADDED*******************************************************-->
    <div id = "divHttpRequestPostFrontPage"></div>
    <!--*****************************SHOW ALL DATABASE POST***************************************************-->
    <div style="" id="httpShowPostFromStartjsAndmyTextEditorDBShowPostphp"></div>



    <div id="overlayStatus"  >
        <div id="divLoadingStatus" >Loading...<br><img src="<?php echo MY_PLUGIN_URL_LDV_JARIM."images/loader.gif"; ?>" height="30" width="30"><br></div>
    </div>

    <div id="overlayMessages" >
        <div id="divAllMessagesWrapper" >
            <div  id="divAllMessages" ></div>
            <div class ="close_button" id="close_button_Messages" >X</div>
        </div>
    </div>


    <div id="divAllMessages"></div>



<div class="jarimFooterRellenoInvisibleContact">
</div>
</div>
<!--**************END FRONT *******************************************-->

<?php //NO ALLOWED LOADING / ALLOWED IF FILE IN TEMPLATES THEME DIR
get_footer(); ?>
