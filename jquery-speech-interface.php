<?php
/*
Plugin Name: jQuery Speech Interface
Plugin URI: https://github.com/victorjonsson/jQuery-Speech-Interface/
Description: With this plugin you make it possible for your visitors to control and navigate your website by talking to the browser. This plugin is mostlIt only works in browsers that supports -webkit-speech
Version: 0.1
Author: Victor Jonsson
Author URI: http://victorjonsson.se
*/


class jQuerySpeechSettings {

    /**
     * Name of the wp option that this object is saved as
     */
    const OPT_NAME = 'jqspeech';

    /**
     * @static
     * @return jQuerySpeechSettings
     */
    public static function instance() {
        $instance = get_option(self::OPT_NAME, false);
        if(!$instance)
            $instance = new self();

        return $instance;
    }

    /**
     * @var string
     */
    private $not_supported_message;

    /**
     * @var bool
     */
    private $is_active;

    /**
     * @var int
     */
    private $debug_mode;

    /**
     * Default settings added on construct
     */
    protected function __construct() {
        $this->not_supported_message = 'Your browser does not support -webkit-speech';
        $this->is_active = true;
        $this->debug_mode = 2;
    }

    /**
     * Save this object to database
     * @return void
     */
    public function save() {
        update_option(self::OPT_NAME, $this);
    }

    /**
     * @param bool $active
     */
    public function setIsActive($active) {
        $this->is_active = (bool)$active;
    }

    /**
     * @return bool
     */
    public function isActive() {
        return $this->is_active;
    }

    /**
     * @param string $not_supported_message
     */
    public function setNotSupportedMessage($not_supported_message) {
        $this->not_supported_message = $not_supported_message;
    }

    /**
     * @return string
     */
    public function getNotSupportedMessage() {
        return $this->not_supported_message;
    }

    /**
     * @param int $debug_mode
     */
    public function setDebugMode($debug_mode) {
        $this->debug_mode = (int)$debug_mode;
    }

    /**
     * @return int
     */
    public function getDebugMode() {
        return $this->debug_mode;
    }
}

if(is_admin()) {

    // Remove saved options on deactivation
    register_deactivation_hook(__FILE__, 'jqspeech_deactivate');
    function jqspeech_deactivate() {
        delete_option(jQuerySpeechSettings::OPT_NAME);
    }

    // Add options page
    add_action('admin_init', 'jqspeech_admin_init');
    add_action('admin_menu', 'jqspeech_admin_menu');
    function jqspeech_admin_init() {
        wp_enqueue_style("jqspeech_admin", plugin_dir_url(__FILE__).'admin-page.css');
    }
    function jqspeech_admin_menu() {
        add_options_page(
                'jQuery Speech',
                'jQuery Speech',
                'manage_options',
                'jquery-speech-interface',
                'jqspeech_admin_page'
            );
        function jqspeech_admin_page() {
            require_once 'admin-page.php';
        }
    }
}
else {

    add_action('wp_head', 'jqspeech_init');
    function jqspeech_init() {

        $settings = jQuerySpeechSettings::instance();
        if($settings->isActive()) {

            wp_enqueue_script('jquery');

            ?>
            <script src="<?php echo plugin_dir_url(__FILE__) ?>jquery.speechinterface.js?<?=time()?>" type="text/javascript"></script>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    jQuery('body').speechInterface({
                        <?php if(is_user_logged_in()): ?>
                            posY : 40,
                        <? endif; ?>
                        debugMode : <?=$settings->getDebugMode()?>,
                        scrollHeight : jQuery(window).height() * 0.4,
                        notSupportedMessage: <?php echo $settings->getNotSupportedMessage() == '' ? 'false':'\''.$settings->getNotSupportedMessage().'\'' ?>
                    });
                });
            </script>
            <?php
        }
    }
}