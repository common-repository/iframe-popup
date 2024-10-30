<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class iframepopup_cls_registerhook
{
	public static function iframepopup_activation()
	{
		global $wpdb, $iframepopup_db_version;
		$prefix = $wpdb->prefix;
		
		add_option('iframe_popup_db', "1.0");
		add_option('iframepopup_session', "NO");
		
		// Plugin tables
		$array_tables_to_plugin = array('iframepopup');
		$errors = array();
		
		// loading the sql file, load it and separate the queries
		$sql_file = IFRAMEPOP_DIR.'sql'.DS.'createDB.sql';
		$prefix = $wpdb->prefix;
        $handle = fopen($sql_file, 'r');
        $query = fread($handle, filesize($sql_file));
        fclose($handle);
        $query=str_replace('CREATE TABLE IF NOT EXISTS `','CREATE TABLE IF NOT EXISTS `'.$prefix, $query);
        $queries=explode('-- SQLQUERY ---', $query);

        // run the queries one by one
        $has_errors = false;
        foreach($queries as $qry)
		{
            $wpdb->query($qry);
        }
		
		// list the tables that haven't been created
        $missingtables=array();
        foreach($array_tables_to_plugin as $table_name)
		{
			if(strtoupper($wpdb->get_var("SHOW TABLES like  '". $prefix.$table_name . "'")) != strtoupper($prefix.$table_name))  
			{
                $missingtables[] = $prefix.$table_name;
            }
        }
		
		// add error in to array variable
        if($missingtables) 
		{
			$errors[] = __('These tables could not be created on installation ' . implode(', ',$missingtables), 'iframe-popup');
            $has_errors=true;
        }
		
		// if error call wp_die()
        if($has_errors) 
		{
			wp_die( __( $errors[0] , 'iframe-popup' ) );
			return false;
		}
		else
		{
			iframepopup_cls_dbquery::popup_default();
		}

        return true;
	}
	
	public static function iframepopup_deactivation()
	{
		// do not generate any output here
	}
	
	public static function iframepopup_adminmenu()
	{
		if (is_admin()) 
		{
			add_options_page( __('IFrame popup', 'iframe-popup'), 
				__('IFrame popup', 'iframe-popup'), 'manage_options', IFRAMEPOP_PLUGIN_NAME, array( 'iframepopup_cls_intermediate', 'iframepopup_admin' ) );
		}		
	}
	
	public static function iframepopup_widget_loading()
	{
		register_widget( 'iframepopup_widget_register' );
	}
	
	public static function iframepopup_load_adminscripts() 
	{
		if( !empty( $_GET['page'] ) ) 
		{
			switch ( $_GET['page'] ) 
			{
				case 'iframe-popup':
					wp_register_script( 'iframepopup-adminscripts', IFRAMEPOP_URL . 'page/setting.js', '', '', true );
					wp_enqueue_script( 'iframepopup-adminscripts' );
					$iframepopup_select_params = array(
						'iframepopup_url'  		=> __( 'Enter URL to display in Iframe popup window. URL must start with either http or https.', 'iframepopup-select', 'iframe-popup' ),
						'iframepopup_title'   	=> __( 'Enter your title for popup window.', 'iframepopup-select', 'iframe-popup' ),
						'iframepopup_session'   => __( 'Select session option for popup window.', 'iframepopup-select', 'iframe-popup' ),
						'iframepopup_delete'   	=> __( 'Do you want to delete this record?', 'iframepopup-select', 'iframe-popup' ),
					);
					wp_localize_script( 'iframepopup-adminscripts', 'iframepopup_adminscripts', $iframepopup_select_params );
					break;
			}
		}
	}
}

function iframepopup_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script('jquery');
		wp_enqueue_style( 'jquery.fancybox.min', IFRAMEPOP_URL.'inc/jquery.fancybox.min.css');
		wp_enqueue_script('jquery.fancybox.min', IFRAMEPOP_URL.'inc/jquery.fancybox.min.js');
	}
}

class iframepopup_widget_register extends WP_Widget 
{
	function __construct() 
	{
		$widget_ops = array('classname' => 'widget_text elp-widget', 'description' => __(IFRAMEPOP_PLUGIN_DISPLAY, 'iframe-popup'), IFRAMEPOP_PLUGIN_NAME);
		parent::__construct(IFRAMEPOP_PLUGIN_NAME, __(IFRAMEPOP_PLUGIN_DISPLAY, 'iframe-popup'), $widget_ops);
	}
	
	function widget( $args, $instance ) 
	{
		extract( $args, EXTR_SKIP );
		
		$iframepopup_title 	= apply_filters( 'widget_title', empty( $instance['iframepopup_title'] ) ? '' : $instance['iframepopup_title'], $instance, $this->id_base );
		$iframepopup_id	= $instance['iframepopup_id'];

		//echo $args['before_widget'];
		if ( ! empty( $iframepopup_title ) )
		{
			//echo $args['before_title'] . $iframepopup_title . $args['after_title'];
		}
		// Call widget method
		$arr = array();
		$arr["id"] 	= $iframepopup_id;
		$arr["cat"] = "";
		echo iframepopup_cls_widget::iframepopup_widget_int($arr);
		// Call widget method
		
		//echo $args['after_widget'];
	}
	
	function update( $new_instance, $old_instance ) 
	{
		$instance 						= $old_instance;
		$instance['iframepopup_title'] 	= ( ! empty( $new_instance['iframepopup_title'] ) ) ? strip_tags( $new_instance['iframepopup_title'] ) : '';
		$instance['iframepopup_id'] 	= ( ! empty( $new_instance['iframepopup_id'] ) ) ? strip_tags( $new_instance['iframepopup_id'] ) : '';
		return $instance;
	}
	
	function form( $instance ) 
	{
		$defaults = array(
			'iframepopup_title' => '',
            'iframepopup_id' 	=> ''
        );
		$instance 		= wp_parse_args( (array) $instance, $defaults);
		$iframepopup_title 		= $instance['iframepopup_title'];
        $iframepopup_id 		= $instance['iframepopup_id'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id('iframepopup_title'); ?>"><?php _e('Widget Title', 'iframe-popup'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('iframepopup_title'); ?>" name="<?php echo $this->get_field_name('iframepopup_title'); ?>" type="text" value="<?php echo $iframepopup_title; ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('iframepopup_id'); ?>"><?php _e('Popup Id', 'iframe-popup'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('iframepopup_id'); ?>" name="<?php echo $this->get_field_name('iframepopup_id'); ?>" type="text" value="<?php echo $iframepopup_id; ?>" />
        </p>
		<?php
	}
}
?>