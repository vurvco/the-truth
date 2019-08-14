<?php

class Class_Install_LdvJarim 
{

    protected $option_name = 'libro_de_visitas_option';
	
    protected $data = array
    (
        'libro_de_visitas_page_title' => 'Libro de visitas',
        'libro_de_visitas_label_name' => 'Nombre o alias',
        'libro_de_visitas_label_message' => 'Mensaje',
        'libro_de_visitas_text_button' => 'Enviar',
        'libro_de_visitas_message_validation' => 'El mensaje es muy largo o está en blanco',        
        'libro_de_visitas_name_validation' => 'No has puesto el nombre'        
        

    );

    public function __construct() 
    {


        // Admin sub-menu
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_menu', array($this, 'add_page'));
	
     			
        // Listen for the activate event
        register_activation_hook(MY_PLUGIN_FILE_JARIM_LDV_JARIM, array($this, 'activate'));
        
        // Deactivation plugin
        register_deactivation_hook(MY_PLUGIN_FILE_JARIM_LDV_JARIM, array($this, 'deactivate'));
 
        //initialize all constants to options
        $this->initializeConstants();
        




    }//END public function __construct() 


    
    public function initializeOptionsProtected() 
    {
        $options = get_option($this->option_name);

        if ($options)
        {   
            $this->data['libro_de_visitas_page_title'] = $options['libro_de_visitas_page_title'];  
            $this->data['libro_de_visitas_label_name'] = $options['libro_de_visitas_label_name'] ; 
            $this->data['libro_de_visitas_label_message'] = $options['libro_de_visitas_label_message'] ; 
            $this->data['libro_de_visitas_text_button'] = $options['libro_de_visitas_text_button'] ;  
            $this->data['libro_de_visitas_message_validation'] = $options['libro_de_visitas_message_validation'] ; 
            $this->data['libro_de_visitas_name_validation'] = $options['libro_de_visitas_name_validation'] ;            
            

        }
   
    }//END public initializeOptionsProtected()
    
    public function initializeConstants() 
    {
        
        $this->initializeOptionsProtected();
        if ( !defined('LIBRO_DE_VISITAS_PAGE_TITLE') )
        define( 'LIBRO_DE_VISITAS_PAGE_TITLE', $this->data['libro_de_visitas_page_title'] ); 
        if ( !defined('LIBRO_DE_VISITAS_LABEL_NAME') )
        define( 'LIBRO_DE_VISITAS_LABEL_NAME', $this->data['libro_de_visitas_label_name'] ); 
        if ( !defined('LIBRO_DE_VISITAS_LABEL_MESSAGE') )
        define( 'LIBRO_DE_VISITAS_LABEL_MESSAGE', $this->data['libro_de_visitas_label_message'] ); 
        if ( !defined('LIBRO_DE_VISITAS_TEXT_BUTTON') )
        define( 'LIBRO_DE_VISITAS_TEXT_BUTTON', $this->data['libro_de_visitas_text_button'] ); 
        if ( !defined('LIBRO_DE_VISITAS_MESSAGE_VALIDATION') )
        define( 'LIBRO_DE_VISITAS_MESSAGE_VALIDATION', $this->data['libro_de_visitas_message_validation'] ); 
        if ( !defined('LIBRO_DE_VISITAS_NAME_VALIDATION') )
        define( 'LIBRO_DE_VISITAS_NAME_VALIDATION', $this->data['libro_de_visitas_name_validation'] ); 
  
    }//END public initializeConstants()

    public function activate() 
    {

        //UPDATE OPTION
        update_option($this->option_name, $this->data);
        
        //CREATE TABLES STRUCTURE
        $this->libro_de_visitas_install();

        //IF MY POST DOES NOT EXISTS CREATE IT
        //if(($this->my_post_published_by_post_name_exists_jarim(POST_NAME_LDV_JARIM))=== "false")
        $key_ldv_jarim = "ldv_jarim_post";
        $value_ldv_jarim = "ldv_jarim_post_01" ;
        if(($this->exists_post_by_metadata_ldv_jarim($key_ldv_jarim,$value_ldv_jarim))=== false)
        {
            $my_post = array();
            $my_post['post_title']    = POST_TITLE_LDV_JARIM;
            //$my_post['page_template']   = TEMPLATE_NAME_LDV_JARIM;
            //$my_post['post_name']    = POST_NAME_LDV_JARIM;
            $my_post['post_type']  = 'page';
            $my_post['post_status']   = 'publish';
            $my_post['comment_status']   = 'closed';
            $postID = wp_insert_post( $my_post, $wp_error ); 
            update_post_meta($postID, "_wp_page_template", TEMPLATE_NAME_LDV_JARIM);
            
            //add_post_meta($post_id, $meta_key, $meta_value, $unique)
            //On success, returns the ID of the inserted row, which validates to true. If the $unique argument was set to true and a custom field with the given key already exists, false is returned.
            $add_post_metadata_ldv_jarim_post = add_post_meta( $postID, 'ldv_jarim_post', "ldv_jarim_post_01",true );
            //$lastQuery = $postID->request;
    
        }
	
    }// END activate() 

   
    
    
    
    public function deactivate() 
    {
        //$this->my_post_published_by_post_name_delete_jarim(POST_NAME_LDV_JARIM);
        $key_ldv_jarim = "ldv_jarim_post";
        $value_ldv_jarim = "ldv_jarim_post_01" ;
        $this->delete_post_by_metadata_ldv_jarim($key_ldv_jarim,$value_ldv_jarim);
        delete_option($this->option_name);
    }

    public function exists_post_by_metadata_ldv_jarim($key_ldv_jarim,$value_ldv_jarim)
    {
    /*CALL
    $key_ldv_jarim = "ldv_jarim_post";
    $value_ldv_jarim = "ldv_jarim_post_01" ;
    if(($this->exists_post_by_metadata_ldv_jarim($key_ldv_jarim,$value_ldv_jarim))=== false){
    */

        $args = array(
                'post_status' => 'publish',
                'post_type' => 'page',
                'meta_query' => array(
                        array(
                                'key' => $key_ldv_jarim,
                                'value' => $value_ldv_jarim
                        )
                )
         );

        $posts = get_posts($args);  

        if ($posts)
        {
            return true;
        }
        else
        {
            return false;
        }


    }// END exists_post_by_metadata_ldv_jarim($key_ldv_jarim,$value_ldv_jarim)


    public function delete_post_by_metadata_ldv_jarim($key_ldv_jarim,$value_ldv_jarim)
    {
    /*CALL
    $key_ldv_jarim = "ldv_jarim_post";
    $value_ldv_jarim = "ldv_jarim_post_01" ;
    $this->delete_post_by_metadata_ldv_jarim($key_ldv_jarim,$value_ldv_jarim);
    */
        $args = array(
                'post_type' => 'page',
                'meta_query' => array(
                        array(
                                'key' => $key_ldv_jarim,
                                'value' => $value_ldv_jarim
                        )
                )
         );

        $postlist = get_posts($args);  

        $posts = array();
        $force_delete = true;// FOR DELETING DIRECTLY THE POST (NO TRASH)
        foreach ( $postlist as $post ) 
        {
            wp_delete_post( $post->ID, $force_delete );
        }

    }// END delete_post_by_metadata_ldv_jarim($key_ldv_jarim,$value_ldv_jarim)

   

    // White list our options using the Settings API
    public function admin_init() {
        register_setting('libro_de_visitas_list_options', $this->option_name, array($this, 'validate'));
    }

    // Add entry in the settings menu
    public function add_page() {
          //JARIM NOTE: array($this, 'options_do_page')IS THE LAST PARAMETER AND SIMPLY CALL A FUNCTION FROM THE CLASS IN THIS WIERD WAY, JUST TO GET THE OUTPUT IN THE ADMIN SIDE
          add_options_page('libro_de_visitas', 'libro_de_visitas', 'manage_options', 'libro_de_visitas_list_options', array($this, 'options_do_page'));

    }// END  my_post_published_by_post_name_delete_jarim($postName)
	



    // Print the menu page itself
    public function options_do_page() {
        $options = get_option($this->option_name);
        ?>
        <div class="wrap">
            <h2>Libro de visitas Options</h2>
            <form method="post" action="options.php">
                <?php
                //settings fields Output nonce, action, and option_page fields for a settings page. 
                //Please note that this function must be called inside of the form tag 
                //for the options page.
                settings_fields('libro_de_visitas_list_options'); ?>

                <h3>Please, fill these options to complete the installation</h3>

                <table class="form-table">
					
                    <tr valign="top"><th scope="row">Page title</th>
                        <!--
                        NOTE JARIM: REMARK THE INPUT NAME IS name="<php echo $this->option_name?>[libro_de_visitas_page_title]"
                        -->
                        <td><input type="text" name="<?php echo $this->option_name; ?>[libro_de_visitas_page_title]" value="<?php echo $options['libro_de_visitas_page_title']; ?>" /></td>
                    </tr>				
                    <tr valign="top"><th scope="row">Label name text:</th>
                        <td><input type="text" name="<?php echo $this->option_name; ?>[libro_de_visitas_label_name]" value="<?php echo $options['libro_de_visitas_label_name']; ?>" /></td>
                    </tr>	
                    <tr valign="top"><th scope="row">Label name message:</th>
                        <td><input type="text" name="<?php echo $this->option_name; ?>[libro_de_visitas_label_message]" value="<?php echo $options['libro_de_visitas_label_message']; ?>" /></td>
                    </tr>	
                    <tr valign="top"><th scope="row">Button submit text:</th>
                        <td><input type="text" name="<?php echo $this->option_name; ?>[libro_de_visitas_text_button]" value="<?php echo $options['libro_de_visitas_text_button']; ?>" /></td>
                    </tr>	
                    <tr valign="top"><th scope="row">Message to user if send with message empty:</th>
                        <td><input type="text" name="<?php echo $this->option_name; ?>[libro_de_visitas_message_validation]" value="<?php echo $options['libro_de_visitas_message_validation']; ?>" /></td>
                    </tr>	
                    <tr valign="top"><th scope="row">Message to user if send with name empty:</th>
                        <td><input type="text" name="<?php echo $this->option_name; ?>[libro_de_visitas_name_validation]" value="<?php echo $options['libro_de_visitas_name_validation']; ?>" /></td>
                    </tr>	  
                    

	
                </table>
                <p class="submit">
                    <input type="submit" class="" value="<?php _e('Save Changes') ?>" />
                </p>
            </form>
        </div>
        <?php
    }//END options_do_page()

    
    
    public function validate($input) 
    {

        $valid = array();
        $valid['libro_de_visitas_page_title'] = sanitize_text_field($input['libro_de_visitas_page_title']);
        $valid['libro_de_visitas_label_name'] = sanitize_text_field($input['libro_de_visitas_label_name']);
        $valid['libro_de_visitas_label_message'] = sanitize_text_field($input['libro_de_visitas_label_message']);
        $valid['libro_de_visitas_text_button'] = sanitize_text_field($input['libro_de_visitas_text_button']);		
        $valid['libro_de_visitas_message_validation'] = sanitize_text_field($input['libro_de_visitas_message_validation']);
        $valid['libro_de_visitas_name_validation'] = sanitize_text_field($input['libro_de_visitas_name_validation']);		
  

        if (strlen($valid['libro_de_visitas_page_title']) == 0) 
        {
            add_settings_error(
            'libro_de_visitas_page_title',                 // setting title
            'libro_de_visitas_page_title_text_error',	// error ID
            'Sorry, something is wrong. May be you lost connection o the internet',
            'error'					// type of message
            );
			
            # default value IF EMPTY
            $valid['libro_de_visitas_page_title'] = $this->data['libro_de_visitas_page_title'];
        }
        if (strlen($valid['libro_de_visitas_label_name']) == 0) 
        {
            add_settings_error(
            'libro_de_visitas_label_name',
            'libro_de_visitas_label_name_text_error',
            'Sorry, something is wrong. May be you lost connection o the internet',
            'error'
            );
            # default value IF EMPTY			
            $valid['libro_de_visitas_label_name'] = $this->data['libro_de_visitas_label_name'];
        }

		
        if (strlen($valid['libro_de_visitas_label_message']) == 0) 
        {
            add_settings_error(
            'libro_de_visitas_label_message',
            'libro_de_visitas_label_message_text_error',
            'Sorry, something is wrong. May be you lost connection o the internet',
            'error'
            );
            # default value IF EMPTY			
            $valid['libro_de_visitas_label_message'] = $this->data['libro_de_visitas_label_message'];
        }

		
        if (strlen($valid['libro_de_visitas_text_button']) == 0) 
        {
            add_settings_error(
            'libro_de_visitas_text_button',
            'libro_de_visitas_text_button_text_error',
            'Sorry, something is wrong. May be you lost connection o the internet',
            'error'
            );
            # default value IF EMPTY			
            $valid['libro_de_visitas_text_button'] = $this->data['libro_de_visitas_text_button'];
        }
        
        
        if (strlen($valid['libro_de_visitas_message_validation']) == 0) 
        {
            add_settings_error(
            'libro_de_visitas_message_validation',
            'libro_de_visitas_message_validation_text_error',
            'You should write a message for your users when they leave the message field empty',
            'error'
            );
            # default value IF EMPTY			
            $valid['libro_de_visitas_message_validation'] = $this->data['libro_de_visitas_message_validation'];
        }
        
        
        if (strlen($valid['libro_de_visitas_name_validation']) == 0) 
        {
            add_settings_error(
            'libro_de_visitas_name_validation',
            'libro_de_visitas_name_validation_error',
            'You should write a message for your users when they leave the name field empty',
            'error'
            );
            # default value IF EMPTY			
            $valid['libro_de_visitas_name_validation'] = $this->data['libro_de_visitas_name_validation'];
        }

        $this->data['libro_de_visitas_page_title'] = $valid['libro_de_visitas_page_title'];  
        $this->data['libro_de_visitas_label_name'] = $valid['libro_de_visitas_label_name'] ; 
        $this->data['libro_de_visitas_label_message'] = $valid['libro_de_visitas_label_message'] ; 
        $this->data['libro_de_visitas_text_button'] = $valid['libro_de_visitas_text_button'] ; 
        $this->data['libro_de_visitas_message_validation'] = $valid['libro_de_visitas_message_validation'] ; 
        $this->data['libro_de_visitas_name_validation'] = $valid['libro_de_visitas_name_validation'] ; 

    
        
        //initialize all constants to options
        $this->initializeConstants();
        
        return $valid;
    }//END validate($input) 
	

    public function libro_de_visitas_install()
    {

        global $wpdb;  
        //$charset_collate = $wpdb->get_charset_collate();
        $structure1 = "CREATE TABLE IF NOT EXISTS `libro_de_visitas_guestbook_table` (
        `guestbooid` bigint(20) NOT NULL AUTO_INCREMENT,
        `guestbookpost` varchar(3000) NOT NULL,
        `guestbookuser` varchar(30) NOT NULL,
        `guestbooktimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`guestbooid`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

        $wpdb->query($structure1);

    }// END libro_de_visitas_install()

    
    
    
    
    
}//END Class_Install_LdvJarim
