<?php

/* USES IN PLUGIN TO ADD ALL TEMPLATES
 * //IN PLUGIN ADD THIS LINE
 * add_action( 'plugins_loaded', array( 'Class_Page_Add_Templates_LdvJarim', 'get_instance' ) );
 * 
 * IN THIS CLASS TEMPLATES ARE WROTTEN AT THE _construct class function LIKE THIS
*  $this->templates = array(
                        'goodtobebad-template.php'     => 'It\'s Good to Be Bad',
                    'libro-de-visitas-jarim1.php'     => 'libro-de-visitas-jarim1',
                );
 */

class Class_Page_Add_Templates_LdvJarim {

		/**
        * A Unique Identifier
        */
        protected $plugin_slug;

        /**
         * A reference to an instance of this class.
         */
        private static $instance;

        /**
         * The array of templates that this plugin tracks.
         */
        protected $templates;


        /**
         * Returns an instance of this class. 
         */
        public static function get_instance() {

                if( null == self::$instance ) {
                        self::$instance = new Class_Page_Add_Templates_LdvJarim();
                } 

                return self::$instance;

        } 

        /**
         * Initializes the plugin by setting filters and administration functions.
         */
        private function __construct() {

                $this->templates = array();


                // Add a filter to the attributes metabox to inject template into the cache.
                add_filter(
					'page_attributes_dropdown_pages_args',
					 array( $this, 'register_project_templates' ) 
				);

                // Add a filter to the save post to inject out template into the page cache
                add_filter(
					'wp_insert_post_data', 
					array( $this, 'register_project_templates' ) 
				);


                // Add a filter to the template include to determine if the page has our 
				// template assigned and return it's path
                add_filter(
					'template_include', 
					array( $this, 'view_project_template') 
				);


                // Add your templates to this array.
                $this->templates = array(
                    'libro-de-visitas-jarim1.php'     => 'libro-de-visitas-jarim1'
                );
				
        } 


        /**
         * Adds our template to the pages cache in order to trick WordPress
         * into thinking the template file exists where it doens't really exist.
         *
         */

        public function register_project_templates( $atts ) {

                // Create the key used for the themes cache
                $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

                // Retrieve the cache list. 
				// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
                if ( empty( $templates ) ) {
                        $templates = array();
                } 

                // New cache, therefore remove the old one
                wp_cache_delete( $cache_key , 'themes');

                // Now add our template to the list of templates by merging our templates
                // with the existing templates array from the cache.
                $templates = array_merge( $templates, $this->templates );

                // Add the modified cache to allow WordPress to pick it up for listing
                // available templates
                wp_cache_add( $cache_key, $templates, 'themes', 1800 );

                return $atts;

        } 

        /**
         * Checks if the template is assigned to the page
         */
        public function view_project_template( $template ) {

                global $post;

                if (!isset($this->templates[get_post_meta( 
					$post->ID, '_wp_page_template', true 
				)] ) ) {
			$template = $this->check_If_Template_Exists_In_Child_Theme_Or_Main_Theme($template);		
                        return $template;
						
                } 

                $file = plugin_dir_path(__FILE__)."templates/". get_post_meta( 
					$post->ID, '_wp_page_template', true 
				);
				
                // Just to be safe, we check if the file exist first
                if( file_exists( $file ) ) {
                    
                    
                    
                        $file = $this->check_If_Template_Exists_In_Child_Theme_Or_Main_Theme($file);
                        return $file;
                } 
				else { echo $file; }
                $template = $this->check_If_Template_Exists_In_Child_Theme_Or_Main_Theme($template);
                return $template;

        } 

        
        public function check_If_Template_Exists_In_Child_Theme_Or_Main_Theme($template) {

            $templateName = basename($template);
            // locate_template() returns path to file
            //Searches STYLESHEETPATH before TEMPLATEPATH, so themes which inherit from a parent can overload one file.
            $overridden_template = locate_template($templateName);  
            if ( $overridden_template ) 
            {
                // if either the child theme or the parent theme have overridden the template
                return $overridden_template;
            } else {
              // If neither the child nor parent theme have overridden the template return the plugin template
              return $template;
            } 

        }    
    
}// END Class_Page_Add_Templates_LdvJarim