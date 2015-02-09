<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class NTX_plugin {

    // the instance of our plugin
    private static $_instance = null;

    // token to use to make everything unique
    public $token;

    // domain of current plugin
    public $domain;


    // local variables for plugin
    public $version;

    // current file to load
    public $file;

    //current dir of plugin
    public $dir;

    //current url of asset folder
    public $url;


    public function __construct($file = '', $version = '1.0', $token = "ntx_plugin")
    {
        $this->version = $version;
        $this->file = $file;
        
        $this->token = $token;
        $this->domain = $token;

        $this->dir = dirname($this->file);

        $this->url = esc_url( trailingslashit( plugins_url( '/resources/', $this->file ) ) );

        register_activation_hook( $this->file, array( $this, 'install' ) );
        register_deactivation_hook( $this->file, array( $this, 'uninstall' ) );

        // Load frontend JS & CSS
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );

        // Load admin JS & CSS
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10, 1 );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ), 10, 1 );

        // Handle localisation
        $this->load_plugin_textdomain();
        add_action( 'init', array( $this, 'load_localisation' ), 0 );
    }

    public function enqueue_styles ()
    {
        wp_register_style( $this->token . '-frontend', esc_url( $this->url ) . 'css/style.css', array(), $this->version );
        wp_enqueue_style( $this->token . '-frontend' );
    }

    public function enqueue_scripts ()
    {
        wp_register_script( $this->token . '-frontend', esc_url( $this->url ) . 'js/plugin.js', array( 'jquery' ), $this->version );
        wp_enqueue_script( $this->token . '-frontend' );
    }

    public function admin_enqueue_styles ( $hook = '' )
    {
        wp_register_style( $this->token . '-admin', esc_url( $this->url ) . 'css/admin.style.css', array(), $this->version );
        wp_enqueue_style( $this->token . '-admin' );
    }

    public function admin_enqueue_scripts ( $hook = '' )
    {
        wp_register_script( $this->token . '-admin', esc_url( $this->url ) . 'js/admin.plugin.js', array( 'jquery' ), $this->version );
        wp_enqueue_script( $this->token . '-admin' );
    }

    public function load_localisation ()
    {
        load_plugin_textdomain( $this->domain, false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
    }

    public function load_plugin_textdomain ()
    {
        $domain = $this->domain;

        $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

        load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
        load_plugin_textdomain( $domain, false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
    }

    /*
    *   Activation Hook for your plugin
    */
    public function install ()
    {
        global $wpdb;

        foreach ($quran_db as $value) {
            # code...
        }
        $quran['en'] = $wpdb->prefix . $this->token . "_quran_en";
        $quran['en_sql'] = "DROP TABLE IF EXISTS `". $quran['en'] ."`;
                            CREATE TABLE IF NOT EXISTS `". $quran['en'] ."` (
                              `ID` int(11) NOT NULL AUTO_INCREMENT,
                              `sura` int(3) NOT NULL DEFAULT '0',
                              `aya` int(3) NOT NULL DEFAULT '0',
                              `text` text NOT NULL,
                              PRIMARY KEY (`index`)
                            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
        
        $quran['ar'] = $wpdb->prefix . $this->token . "_quran_ar";
        $quran['ar_sql'] = "DROP TABLE IF EXISTS `". $quran['ar'] ."`;
                            CREATE TABLE IF NOT EXISTS `". $quran['ar'] ."` (
                              `ID` int(11) NOT NULL AUTO_INCREMENT,
                              `sura` int(3) NOT NULL DEFAULT '0',
                              `aya` int(3) NOT NULL DEFAULT '0',
                              `text` text NOT NULL,
                              PRIMARY KEY (`index`)
                            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

        // error_log($english);
    }

    /*
    *   Deactivation Hook for your plugin
    */
    public function uninstall ()
    {
        error_log("Uninstalled the Plugin");
        // file_put_contents("c:\\wamp\\www\\data.txt", "Uninstalled the Plugin", FILE_APPEND);
    }

    // Do not edit these
    public static function instance ( $file = '', $version = '1.0.0', $token = "" )
    {
        if ( is_null( self::$_instance ) )
        {
            self::$_instance = new self( $file, $version );
        }
        return self::$_instance;
    }

    public function __clone ()
    {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->version );
    }

    public function __wakeup ()
    {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->version );
    }

}
?>