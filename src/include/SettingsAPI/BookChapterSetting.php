<?php
/**
 * Book Chapter Setting API
 * 
 * @package Librarian
 */
namespace Librarian\SettingsAPI;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use Librarian\Utils\SettingUtils;

class BookChapterSetting {
    /**
     * @var Librarian\Utils\SettingUtils $setting_utils Setting utils instance
     */
    public $setting_utils;


    public function __construct() {
      $this->setting_utils = new SettingUtils();

      add_action( 'admin_menu', array( $this, 'librarian_custom_post_editor' ), 10 );
    }

    /**
     * Add custom post editor form for Book Chapter CPT
     */
    public function librarian_custom_post_editor(){
        /**
         * @see SettingUtils librarian_add_custom_post_editor_utils()
         */
        $this->setting_utils->librarian_add_custom_post_editor_utils( 'book_chapter', 'Add New Chapter', 'Add New Chapter', 'manage_options', 'custom_add_new_chaper', array( $this, 'test' ) );
    }

    /**
     *
     */

    public function test(){
        echo "
        <div>
            <h1>Test</h1>
        </div>
        ";
    }
}