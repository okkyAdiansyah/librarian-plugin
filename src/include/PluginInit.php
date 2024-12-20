<?php
/**
 * Plugin Init
 * 
 * @uses Librarian\Admin\MainAdmin\MainAdmin Uses for register plugin main admin page
 * 
 * @package Librarian
 */
namespace Librarian;

if( ! defined( 'ABSPATH' ) ){
    exit;
}


use Librarian\View\Admin;
use Librarian\Services\AutoUpdate\PostAutoUpdate;
use Librarian\Admin\MainAdmin\MainAdmin;
use Librarian\CustomPostType\CollectionPostType;
use Librarian\CustomPostType\ChapterPostType;
use Librarian\CustomPostType\BookContentPostType;
use Librarian\Services\RestApi\Route;
use Librarian\Services\RestApi\Setting\ApiSetting;
use Librarian\Services\StarRating\StarRating;


class PluginInit {
    /**
     * @var Librarian\Services\Service[] $services Collection of registered service
     */
    public $services = [];
    
    public $options;

    public function __construct() {
        $this->options = LIBRARIAN_OPTION();
    }

    /**
     * Init plugin functionalities
     */
    public function librarian_init(){
        $this->librarian_register_service();

        add_action( 'init', array( $this, 'librarian_register_default_custom_post_type' ), 10 );

        foreach( $this->services as $service ){
            $service->librarian_init();
        }
    }

    /**
     * Register service
     * 
     * @return void
     */
    public function librarian_register_service(){
        $services_to_register = array(
            Route::class,
            Admin::class,
            PostAutoUpdate::class,
            StarRating::class
        );

        foreach ( $services_to_register as $service ) {
            $this->services[] = $this->librarian_instantiated($service);
        }
    }

    /**
     * Instantiated plugin service
     * 
     * @param Librarian\Services\Service $service Single service
     * 
     * @return Service
     */
    public function librarian_instantiated( $service ){
        if( $service === null ){
            return;
        }

        return new $service();
    }

    /**
     * Plugin activation
     */
    public function librarian_plugin_activate(){
        flush_rewrite_rules(  );
    }

    /**
     * Plugin deactivate
     */
    public function librarian_plugin_deactivate(){
        $this->options->librarian_reset_option();
        flush_rewrite_rules(  );
    }

    /**
     * Register default custom post type
     */
    public function librarian_register_default_custom_post_type(){
        $collection_post_type = new CollectionPostType();
        $collection_post_type->librarian_register_post_type();

        $chapter_post_type = new ChapterPostType();
        $chapter_post_type->librarian_register_post_type();

        $book_content_post_type = new BookContentPostType();
        $book_content_post_type->librarian_register_post_type();
    }
}