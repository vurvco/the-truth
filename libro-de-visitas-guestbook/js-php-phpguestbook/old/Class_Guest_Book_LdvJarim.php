<?php
		

class Class_Guest_Book_LdvJarim extends Class_Base_Abstract_Guest_Book_LdvJarim 
{
    // Next comes the variable list as defined above
    // Note the key word 'var' and then a comma-separated list

    public $ip,$mail,$pass,$passoriginal,
	$passCoded,$userid,$username,
	$userphoto,$userbirthday,$userlanguage,$usercssbackgroundpicture,
	$usercssbackgroundcolor,$usercssbackgroundpicturesize,$userfolder,$last_id;

    // Next come all our methods with their argument lists
   public function __construct() 
   {
	//ADD ACTION SHOW ALL POSTS
        // handler function...FOR LOGGED IN USERS
        add_action( 'wp_ajax_showAllPosts_Guest_book_JarimAjaxJS',array($this, 'showAllPosts') );
        // handler function...FOR NON LOGGED IN USERS
        add_action( 'wp_ajax_nopriv_showAllPosts_Guest_book_JarimAjaxJS', array($this, 'showAllPosts') );
		
	//ADD ACTION INSERT POST       
        // handler function...FOR LOGGED IN USERS
        add_action( 'wp_ajax_insertPost_Guest_book_JarimAjaxJS',array($this, 'insertPost') );
        // handler function...FOR NON LOGGED IN USERS
        add_action( 'wp_ajax_nopriv_insertPost_Guest_book_JarimAjaxJS', array($this, 'insertPost') );         
        
    }//END public function __construct() 
    
    
    


 /*		
 
SHOW ALL PROPERTIES CONSTANTS AND METHODS
 
	
	$FileUploadClass = new FileUploadClass;
	echo "<br><br><br>PROPERTIES CLASS<br><br>";
	$FileUploadClass->listMyProperties();
	echo "<br><br><br>PROPERTIES CONSTANTS<br><br>";
	$FileUploadClass->listMyConstants();
	echo "<br><br><br>LIST MY METHODS<br><br>";
	$FileUploadClass->listMyMethods();

MAKING NEW OBJECTS
	$newPost = new Post;
	$notificationPostShowAll = $newPost->notificationPostShowAll($userid,$myuserlanguage);

	echo $notificationPostShowAll;
	echo '
	notificationPostShowAll'.$notificationPostShowAll;

INITIALIZING VARIABLES
			$this->ip = $ip;
			$this->mail = $mail;
	*/	
    
    
    
    function showAllPosts() 
    {
                //CLEAN FOR WP-ERRORS OR BLANK SPACES
                ob_clean();

                $sql="SELECT *
                FROM libro_de_visitas_guestbook_table 
                ORDER BY guestbooid DESC";
                global $wpdb;
                //OPTION 1 - SELECT WP NO PREPARE IF NO PARAMETERS 
                $results = $wpdb->get_results( "SELECT * FROM libro_de_visitas_guestbook_table ORDER BY guestbooid DESC"  );

                //OPTION 2 - SELECT WP WITH PREPARE IF PARAMETERS PASSED
                //$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %s", $metakey, $metavalue ) );

                $results = $wpdb->get_results($sql);
                foreach ( $results as $row ) 
                {

                    echo '<div class="nicefont myPostGuestBook"  id="myPostGuestBook">';
                        echo '<div class="dateGuestbook">'.$row->guestbooktimestamp.'</div >';
                        echo '<div class ="myGuessBookNamesDiv" ><img src="'. MY_PLUGIN_URL_LDV_JARIM.'images/icon-45x45.png"><br>'.$row->guestbookuser.'</div><br>';
                        echo $row->guestbookpost;
                    echo '</div ><br>';
                }
                //END WITH DIE
                wp_die();

    }//END showAllPosts()
 
  

    function insertPost() 
    {	
                //CLEAN FOR WP-ERRORS OR BLANK SPACES
                ob_clean();
                //GET POST VARIABLES
                if (!(isset( $_POST['myusername'] )) || $_POST['myusername']==""){exit;}
                if (!(isset( $_POST['postcontentPosted'] )) || $_POST['postcontentPosted']==""){exit;}

                //CHECK FOR TYPE,LENGHT AND EMPTY STRINGS
                $myusername = sanitize_text_field($_POST['myusername']);
                $mypostnow= sanitize_text_field( $_POST['postcontentPosted']);

                //TEST 1 HERE
                //echo  "mypostnow = ".$mypostnow." myusername = ".$myusername;

                //SANITY CHECK
                if(!( $this->sanityCheckMysqlScapeByReference($myusername, 'string', 30) && $this->sanityCheckMysqlScapeByReference($mypostnow, 'string', 3000)))
                {
                        //echo 'Username is not set';
                        exit();
                }


                //TEST 2 HERE
                //echo  "mypostnow = ".$mypostnow." myusername = ".$myusername;
                //DO ANYTHING
                //ACCESS TO THE DATABASE
                global $wpdb; 

                //OPTION 3 - QUERY WP preapared AVOID INJECTION
                //Escaping queries for avoid injection' WHERE The %s (string), %d (integer) and %f (float) formats are supported.
                $result = $wpdb->query( $wpdb->prepare( 
                "
                        INSERT INTO libro_de_visitas_guestbook_table
                        ( guestbookpost, guestbookuser )
                        VALUES ( %s, %s )
                ", 
                $mypostnow, 
                $myusername

        ) );

                //TEST 3
                //echo "insert result = ".$result;      
                //END WITH DIE
                wp_die();

    }// END FUNCTION insertPost()


} // End CLASS Class_Guest_Book_LdvJarim