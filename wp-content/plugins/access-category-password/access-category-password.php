<?php
/*
Plugin Name: Access Category Password
Text Domain: access-category-password
Plugin URI: https://wordpress.org/plugins/access-category-password/
Description: Protects posts in categories by setting a unique Password for all restricted categories.
Author: Jojaba
Version: 1.4.1
Author URI: http://perso.jojaba.fr/
*/

/**
 * Language init
 */
function acpwd_lang_init() {
 load_plugin_textdomain( 'access-category-password', false, basename(dirname(__FILE__)) );
}
add_action('plugins_loaded', 'acpwd_lang_init');

/* ******************************* */
/* Backend of the plugin (options) */
/* ******************************* */

add_action( 'admin_menu', 'acpwd_options_add_page' );
/**
 * Load up the options page
 */
if( !function_exists('acpwd_options_add_page'))  {
	function acpwd_options_add_page() {
		add_options_page(
			__( 'Access Category Password', 'access-category-password' ), // Title for the page
			__( 'Access Category Password', 'access-category-password' ), //  Page name in admin menu
			'manage_options', //  Minimum role required to see the page
			'acpwd_options_page', // unique identifier
			'acpwd_options_do_page'  // name of function to display the page
		);
		add_action( 'admin_init', 'acpwd_options_settings' );
	}
}
/**
 * Create the options page
 */

if( !function_exists('acpwd_options_do_page'))  {
	function acpwd_options_do_page() { ?>

<div class="wrap">

        <h2><?php _e( 'Access Category Password Options', 'access-category-password' ) ?></h2>

        <?php
        /*** To debug, here we can print the plugin options **/
        /*
        echo '<pre>';
        $options = get_option( 'acpwd_settings_options' );
        print_r($options);
        echo '</pre>';
        */
         ?>

        <form method="post" action="options.php">
            <?php settings_fields( 'acpwd_settings_options' ); ?>
		  	<?php do_settings_sections('acpwd_setting_section'); ?>
		  	<p><input class="button-primary"  name="Submit" type="submit" value="<?php esc_attr_e(__('Save Changes', 'access-category-password')); ?>" /></p>
        </form>

</div>

<?php
	} // end acpwd_options_do_page
}

/**
 * Init plugin options to white list our options
 */
if( !function_exists('acpwd_options_settings'))  {
	function acpwd_options_settings(){
		/* Register acpwd settings. */
		register_setting(
			'acpwd_settings_options',  //$option_group , A settings group name. Must exist prior to the register_setting call. This must match what's called in settings_fields()
			'acpwd_settings_options', // $option_name The name of an option to sanitize and save.
			'acpwd_options_validate' // $sanitize_callback  A callback function that sanitizes the option's value.
        );

		/** Add a section **/
		add_settings_section(
			'acpwd_option_main', //  section name unique ID
			'&nbsp;', // Title or name of the section (to be output on the page), you can leave nbsp here if not wished to display
			'acpwd_option_section_text',  // callback to display the content of the section itself
			'acpwd_setting_section' // The page name. This needs to match the text we gave to the do_settings_sections function call
        );

		/** Register each option **/
		add_settings_field(
			'password',  //$id a unique id for the field
			__( 'The password', 'access-category-password' ), // the title for the field
			'acpwd_func_password',  // the function callback, to display the input box
			'acpwd_setting_section',  // the page name that this is attached to (same as the do_settings_sections function call).
			'acpwd_option_main' // the id of the settings section that this goes into (same as the first argument to add_settings_section).
        );

		add_settings_field(
			'impacted_categories',
			__( 'Impacted categories', 'access-category-password' ),
			'acpwd_func_impacted_categories',
			'acpwd_setting_section',
			'acpwd_option_main'
        );

        add_settings_field(
			'allowed_users',
			__( 'Granting users', 'access-category-password' ),
			'acpwd_func_allowed_users',
			'acpwd_setting_section',
			'acpwd_option_main'
        );

        add_settings_field(
			'only_single',
			__( 'Only single post', 'access-category-password' ),
			'acpwd_func_only_single',
			'acpwd_setting_section',
			'acpwd_option_main'
        );


        add_settings_field(
			'info_message',
			__( 'Info message', 'access-category-password' ),
			'acpwd_func_info_message',
			'acpwd_setting_section',
			'acpwd_option_main'
        );

        add_settings_field(
			'input_placeholder',
			__( 'Input placeholder', 'access-category-password' ),
			'acpwd_func_input_placeholder',
			'acpwd_setting_section',
			'acpwd_option_main'
        );

        add_settings_field(
			'error_message',
			__( 'Error message', 'access-category-password' ),
			'acpwd_func_error_message',
			'acpwd_setting_section',
			'acpwd_option_main'
        );

        add_settings_field(
			'valid_button_text',
			__( 'The validation button text', 'access-category-password' ),
			'acpwd_func_valid_button_text',
			'acpwd_setting_section',
			'acpwd_option_main'
        );

        add_settings_field(
			'output_styling',
			__( 'Styling the form', 'access-category-password' ),
			'acpwd_func_output_styling',
			'acpwd_setting_section',
			'acpwd_option_main'
        );

        add_settings_field(
			'feed_desc_text',
			__( 'The feed item description text', 'access-category-password' ),
			'acpwd_func_feed_desc_text',
			'acpwd_setting_section',
			'acpwd_option_main'
        );
    }
}

/** the theme section output**/
if( !function_exists('acpwd_option_section_text'))  {
	function acpwd_option_section_text(){
	echo '<p>'.__( 'Here you can set the options of Access Category Password plugin. Set a password, check the categories with restricted access (the posts in these categories will require a password authentication), check the users roles that don\'t need authentification to access these categories  and define some strings used to inform the user on frontend page.', 'access-category-password' ).'</p>';
	}
}

/** The password field **/
if( !function_exists('acpwd_func_password'))  {
	function acpwd_func_password() {
		 /* Get the option value from the database. */
		$options = get_option( 'acpwd_settings_options' );
		$password = (isset($options['password']) && $options['password'] != '') ? '' : 'acpwdpass' ;
		/* Echo the field. */ ?>
		<label for="paswword" > <?php _e( 'Password', 'access-category-password' ); ?></label>
		<input type="password" id="limit_true" name="acpwd_settings_options[password]" value="<?php echo $password ?>" />
		<p class="description">
		    <?php _e( 'You can type a string or a sentence, or whatever you want. If not set, the default password is <strong>acpwdpass</strong>.', 'access-category-password' ); ?>
        </p>
    <?php }
}


/** The Impacted categories Checkboxes **/
if( !function_exists('acpwd_func_impacted_categories'))  {
	function acpwd_func_impacted_categories(){
	/* Get the option value from the database. */
		$options = get_option( 'acpwd_settings_options' );
		$impacted_categories = (isset($options['impacted_categories'])) ? $options['impacted_categories'] : array();
		/* Echo the field. */ ?>
		<div id="impacted_categories">
		<?php
		$cats = get_categories(array('hide_empty' => 0));
        foreach( $cats as $cat ) { ?>
            <input type="checkbox" name="acpwd_settings_options[impacted_categories][]" value="<?php echo $cat->cat_ID ?>"<?php if (in_array($cat->cat_ID, $impacted_categories)) echo ' checked'; ?> /> <?php echo $cat->cat_name ?><br>
        <?php } ?>
		<p class="description">
		    <?php _e( 'Check the categories that you want to have password restricted post access.', 'access-category-password' ); ?>
        </p>
        </div>
	<?php }
}

/** The users that don't have to enter the Password  **/
if( !function_exists('acpwd_func_allowed_users'))  {
	function acpwd_func_allowed_users(){
	/* Get the option value from the database. */
		$options = get_option( 'acpwd_settings_options' );
		$allowed_users =  (isset($options['allowed_users'])) ? $options['allowed_users'] : array();
        /* Function to translate the user role */
        $role_label = array('administrator'=>__('Administrator', 'access-category-password'), 'editor'=>__('Editor', 'access-category-password'), 'author'=>__('Author', 'access-category-password'), 'contributor'=>__('Contributor', 'access-category-password'), 'subscriber'=>__('Subscriber', 'access-category-password'));
		/* Echo the field. */ ?>
		<div id="allowed_users">
		<?php
		$roles = get_editable_roles();
        foreach( $roles as $role => $role_info ) { ?>
            <input type="checkbox" name="acpwd_settings_options[allowed_users][]" value="<?php echo $role ?>"<?php if (in_array($role, $allowed_users)) echo ' checked'; ?> /> <?php echo $role_label[$role] ?><br>
        <?php } ?>
		<p class="description">
		    <?php _e( 'Check the users roles granted to access the protected categories ressources without having to provide the password.', 'access-category-password' ); ?>
        </p>
        </div>
	<?php }
}

/** Only hide the single pos content **/
if( !function_exists('acpwd_func_only_single'))  {
	function acpwd_func_only_single(){
	/* Get the option value from the database. */
		$options = get_option( 'acpwd_settings_options' );
		$only_single = (isset($options['only_single'])) ? $options['only_single'] : 0;
		/* Echo the field. */ ?>
		<div id="allowed_users">
            <input type="checkbox" name="acpwd_settings_options[only_single]" value="1"<?php if (isset($only_single) && $only_single == 1) echo ' checked'; ?> /> <?php _e( 'Only hide the content of the single posts', 'access-category-password' ); ?>
		<p class="description">
		    <?php _e( 'Check this if you only want to hide the content of the single post view. This will allow to display excerpt and content of protected posts on other pages like category, homepage, search, and so on&hellip;', 'access-category-password' ); ?>
        </p>
        </div>
	<?php }}

/** The info field */
if( !function_exists('acpwd_func_info_message'))  {
	function acpwd_func_info_message(){
	/* Get the option value from the database. */
		$options = get_option( 'acpwd_settings_options' );
		$info_option = (isset($options['info_message']) && $options['info_message'] != '') ? $options['info_message'] : __('This content has restricted access, please type the password below and get access.', 'access-category-password');
		/* Echo the field. */ ?>
		<textarea style="width: 50%; height: 100px;" id="info_message" name="acpwd_settings_options[info_message]"><?php echo stripslashes($info_option); ?></textarea>
		<p class="description">
		    <?php _e( 'The message displayed before the password form of the protected resource (HTML formating with allowed tags).', 'access-category-password' ); ?><br>
		    <?php echo '<strong>'.__('Allowed tags:', 'access-category-password').'</strong> '. allowed_tags() ?>
        </p>
	<?php }
}

/** The Input placeholder **/
if( !function_exists('acpwd_func_input_placeholder'))  {
	function acpwd_func_input_placeholder(){
	/* Get the option value from the database. */
		$options = get_option( 'acpwd_settings_options' );
		$input_placeholder = (isset($options['input_placeholder'])) ? $options['input_placeholder'] : '';
    /* Echo the field. */ ?>
		<input type="text" style="width: 95%;" id="input_placeholder" name="acpwd_settings_options[input_placeholder]" value="<?php echo stripslashes($input_placeholder); ?>" />
		<p class="description">
		    <?php _e( 'The placeholder displayed in the Password field on page load (HTML formating not allowed).', 'access-category-password' ) ?>
    </p>
	<?php }
}

/** The error message **/
if( !function_exists('acpwd_func_error_message'))  {
	function acpwd_func_error_message(){
	/* Get the option value from the database. */
		$options = get_option( 'acpwd_settings_options' );
		$error_message = (isset($options['error_message']) && $options['error_message'] != '') ? $options['error_message'] : __('Sorry, but this is the wrong password.', 'access-category-password');
		/* Echo the field. */ ?>
		<input style="width: 95%;" type="text" id="message_error_option" name="acpwd_settings_options[error_message]" value="<?php echo stripslashes($error_message); ?>" />
		<p class="description">
		    <?php _e( 'The message that will display if the user typed the wrong password (HTML formating with allowed tags).', 'access-category-password' ) ?><br>
		    <?php echo '<strong>'.__('Allowed tags:', 'access-category-password').'</strong> '. allowed_tags() ?>
        </p>
    <?php }
}

/** The validation button text **/
if( !function_exists('acpwd_func_valid_button_text'))  {
	function acpwd_func_valid_button_text(){
	/* Get the option value from the database. */
		$options = get_option( 'acpwd_settings_options' );
		$valid_button_text_option = (isset($options['valid_button_text']) && $options['valid_button_text'] != '') ? $options['valid_button_text'] : __('Get access', 'access-category-password');
		/* Echo the field. */ ?>
		<input type="text" style="width: 95%;" id="feed_desc_text" name="acpwd_settings_options[valid_button_text]" value="<?php echo stripslashes($valid_button_text_option); ?>" />
		<p class="description">
		    <?php _e( 'The validation button text to submit the entered password (HTML formating not allowed).', 'access-category-password' ) ?>
        </p>
    <?php }
}

/** The output styling **/
if( !function_exists('acpwd_func_output_styling'))  {
	function acpwd_func_output_styling(){
?>
<p><?php _e( 'You can style the form that replace the content of a protected article by using the <strong style="color: #0073AA">classes</strong> you can see in the code below in your current theme stylesheet:', 'access-category-password' ) ?><br><code>
<?php echo get_template_directory_uri(); ?>/style.css</code>.</p>
<pre style="width: 90%; overflow: auto; padding: 1% 2%; margin: 1% 0; background: #FFF; border: #ddd 1px solid;">&lt;div class&equals;&quot;<span style="color: #0073AA">acpwd-container</span>&quot;&gt;&NewLine;    &lt;p class&equals;&quot;<span style="color: #0073AA">acpwd-info-message</span>&quot;&gt;This content has restricted access&comma; please type the password below and get access&period;&lt;&sol;p&gt;&NewLine;    &lt;form class&equals;&quot;<span style="color: #0073AA">acpwd-form</span>&quot; action&equals;&quot;&quot; method&equals;&quot;post&quot;&gt;&NewLine;        &lt;input class&equals;&quot;<span style="color: #0073AA">acpwd-pass</span>&quot; type&equals;&quot;password&quot; name&equals;&quot;acpwd-pass&quot;&gt;&NewLine;        &lt;input class&equals;&quot;<span style="color: #0073AA">acpwd-submit</span>&quot; type&equals;&quot;submit&quot; value&equals;&quot;Get access&quot;&gt;&NewLine;    &lt;&sol;form&gt;&NewLine;    &lt;p class&equals;&quot;<span style="color: #0073AA">acpwd-error-message</span>&quot; style&equals;&quot;color&colon; darkred&semi;&quot;&gt;Sorry&comma; but this is the wrong password&period;&lt;&sol;p&gt;&NewLine;&lt;&sol;div&gt;</pre>
    <?php }
}


/** The feed item description text **/
if( !function_exists('acpwd_func_feed_desc_text'))  {
	function acpwd_func_feed_desc_text(){
	/* Get the option value from the database. */
		$options = get_option( 'acpwd_settings_options' );
		$feed_desc_text_option = (isset($options['feed_desc_text']) && $options['feed_desc_text'] != '') ? $options['feed_desc_text'] : __('Access to this post restricted, please go to the website to read it.', 'access-category-password');
		/* Echo the field. */ ?>
		<input type="text" style="width: 95%;" id="feed_desc_text" name="acpwd_settings_options[feed_desc_text]" value="<?php echo stripslashes($feed_desc_text_option); ?>" />
		<p class="description">
		    <?php _e( 'The feed item descriptions that belong to access restricted posts will be replaced by this sentence (HTML formating not allowed).', 'access-category-password' ) ?>
        </p>
    <?php }
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
if( !function_exists('acpwd_options_validate'))  {
	function acpwd_options_validate( $input ) {
	$options = get_option( 'acpwd_settings_options' );

    /** Password crypting */
    if ($input['password'] != '')
	    $options['password'] = crypt($input['password'], $input['password']);

	/** Impacted Categories	validation **/
  if ( ! isset( $input['impacted_categories'] ) )
      $input['impacted_categories'] = array();
  $options['impacted_categories'] = $input['impacted_categories'];

  /** Allowed users validation **/
   if ( ! isset( $input['allowed_users'] ) )
       $input['allowed_users'] = array();
   $options['allowed_users'] = $input['allowed_users'];

  /** Show the excerpt validation **/
  if ( ! isset( $input['only_single'] ) )
      $input['only_single'] = 0;
  $options['only_single'] = $input['only_single'];

	/** clean info field, HTML allowed for the format */
	$options['info_message'] = wp_filter_kses( $input['info_message'] );

  /** clean input placeholder text HTML not allowed */
	$options['input_placeholder'] = wp_filter_nohtml_kses( esc_attr($input['input_placeholder']) );

	/** clean error message field, HTML allowed for the format */
	$options['error_message'] = wp_filter_kses( $input['error_message'] );

    /** validation button text */
	$options['valid_button_text'] = wp_filter_nohtml_kses( esc_attr($input['valid_button_text']) );

	/** clean feed desc text HTML not allowed */
	$options['feed_desc_text'] = wp_filter_nohtml_kses( esc_attr($input['feed_desc_text']) );

	return $options;
	}
}

/* ******************************* */
/* Frontend of the plugin          */
/* ******************************* */

/* Start and destroy sessions */
add_action('init', 'acpwdStartSession', 1);
add_action('wp_logout', 'acpwdEndSession');
add_action('wp_login', 'acpwdEndSession');

function acpwdStartSession() {
    if (!session_id()) {
        session_start();
    }
}

function acpwdEndSession() {
    unset($_SESSION['acpwd_session']);
    session_destroy ();
}

/* Validation of the password */
function acpwd_session_check() {
    // The form has been submited
    if(isset($_POST['acpwd-pass'])) {
        // Checking password
	    $acpwd_options = get_option('acpwd_settings_options');
        if(crypt($_POST['acpwd-pass'], $_POST['acpwd-pass']) == $acpwd_options['password']) {
            $_SESSION['acpwd_session'] = 1;
        }
        elseif (crypt($_POST['acpwd-pass'], $_POST['acpwd-pass']) != $acpwd_options['password']) {
        	$_POST['acpwd-msg'] = ($acpwd_options['error_message'] != '') ? '<p class="acpwd-error-message" style="color: darkred;">'.stripslashes($acpwd_options['error_message']).'</p>' : '<p class="acpwd-error-message" style="color: darkred;">'.__('Sorry, but this is the wrong password.', 'access-category-password').'</p>';
        	$_SESSION['acpwd_session'] = 0;
        }
    }
}
add_action('init', 'acpwd_session_check', 2);

/* Displaying the password form or the feed replacement sentence */
function acpwd_frontend_changes($content) {
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        $u_roles = $user->roles;
        $u_role = $u_roles[0];
    } else {
        $u_role = 'not logged in';
    }
    $acpwd_options = get_option('acpwd_settings_options');
    $impacted_categories = (isset($acpwd_options['impacted_categories'])) ? $acpwd_options['impacted_categories'] : array();
    $allowed_users = (isset($acpwd_options['allowed_users'])) ? $acpwd_options['allowed_users'] : array();
	if ( in_category($impacted_categories) ) {
        if ((isset($_SESSION['acpwd_session']) && $_SESSION['acpwd_session'] == 1) || (isset($acpwd_options['only_single']) && $acpwd_options['only_single'] == 1 && !is_single()) || in_array($u_role, $allowed_users)) {
            $content = $content;
        } else {
            if (is_feed()) {
                // Feed content replacement
                $content = stripslashes($acpwd_options['feed_desc_text']) ;
            } else {
                // Post or excerpt content replacement
                $content = '<div class="acpwd-container" id="acpwd-'.get_the_ID().'">';
                $content .= (isset($acpwd_options['info_message']) && $acpwd_options['info_message'] != '') ? '<p class="acpwd-info-message">'.stripslashes($acpwd_options['info_message']).'</p>' : '<p class="acpwd-info-message">'.__('This content has restricted access, please type the password below and get access.', 'access-category-password').'</p>';
                $content .= '<form class="acpwd-form" action="'.$_SERVER['REQUEST_URI'].'#acpwd-'.get_the_ID().'" method="post">';
                $content .= '<input class="acpwd-pass" type="password" name="acpwd-pass" placeholder="'.stripslashes($acpwd_options['input_placeholder']).'">';
                $content .= (isset($acpwd_options['valid_button_text']) && $acpwd_options['valid_button_text'] != '') ? '<input class="acpwd-submit" type="submit" value="'.$acpwd_options['valid_button_text'].'">' : '<input class="acpwd-submit" type="submit" value="'.__('Get access', 'access-category-password').'">';
                $content .= '</form>';
                if (isset ($_POST['acpwd-msg']))
                    $content .= $_POST['acpwd-msg'];
                $content .= '</div>';
            }
        }
    }
	return $content;
}
add_filter( 'the_content', 'acpwd_frontend_changes' );
add_filter( 'get_the_excerpt', 'acpwd_frontend_changes' );
?>
