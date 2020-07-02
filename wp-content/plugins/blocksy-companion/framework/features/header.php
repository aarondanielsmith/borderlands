<?php

namespace Blocksy;

class HeaderAdditions
{
    public function __construct()
    {
        add_action( 'admin_enqueue_scripts', function () {
            if ( !function_exists( 'get_plugin_data' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }
            global  $wp_customize ;
            $data = get_plugin_data( BLOCKSY__FILE__ );
            $deps = [ 'ct-options-scripts' ];
            $current_screen = get_current_screen();
            if ( $current_screen && $current_screen->id === 'customize' ) {
                $deps = [ 'ct-customizer-controls' ];
            }
            wp_enqueue_script(
                'blocksy-admin-scripts',
                BLOCKSY_URL . 'static/bundle/options.js',
                $deps,
                $data['Version'],
                true
            );
            $conditions_manager = new ConditionsManager();
            $localize = array_merge( [
                'all_condition_rules' => $conditions_manager->get_all_rules(),
                'ajax_url'            => admin_url( 'admin-ajax.php' ),
                'rest_url'            => get_rest_url(),
            ] );
            wp_localize_script( 'blocksy-admin-scripts', 'blocksy_admin', $localize );
            wp_enqueue_style(
                'blocksy-styles',
                BLOCKSY_URL . 'static/bundle/options.css',
                [],
                $data['Version']
            );
        }, 50 );
        add_filter(
            'blocksy:header:current_section_id',
            function ( $section_id, $all_sections ) {
            $maybe_header = $this->maybe_get_header_that_matches( $all_sections );
            if ( $maybe_header ) {
                return $maybe_header;
            }
            return $section_id;
        },
            10,
            2
        );
        add_filter(
            'blocksy:header:default_value',
            function ( $value, $header_builder ) {
            $value['sections'][] = $header_builder->get_structure_for( [
                'id'       => 'ct-custom-transparent',
                'name'     => __( 'Transparent', 'blocksy' ),
                'mode'     => 'placements',
                'settings' => [
                'is_absolute' => 'yes',
            ],
                'items'    => [
                'desktop' => [
                'middle-row' => [
                'start' => [ 'logo' ],
                'end'   => [ 'menu', 'search' ],
            ],
            ],
                'mobile'  => [
                'middle-row' => [
                'start' => [ 'logo' ],
                'end'   => [ 'trigger' ],
            ],
                'offcanvas'  => [
                'start' => [ 'mobile-menu' ],
            ],
            ],
            ],
            ] );
            return $value;
        },
            10,
            2
        );
        add_action( 'wp_ajax_blocksy_header_get_all_conditions', function () {
            if ( !current_user_can( 'manage_options' ) ) {
                wp_send_json_error();
            }
            wp_send_json_success( [
                'conditions' => $this->get_conditions(),
            ] );
        } );
        add_action( 'wp_ajax_blocksy_header_update_all_conditions', function () {
            if ( !current_user_can( 'manage_options' ) ) {
                wp_send_json_error();
            }
            $data = json_decode( file_get_contents( 'php://input' ), true );
            $this->set_conditions( $data );
            wp_send_json_success();
        } );
        add_filter( 'blocksy:header:items-paths', function ( $paths ) {
            $paths[] = dirname( __FILE__ ) . '/header/items';
            return $paths;
        } );
        add_action( 'wp_footer', function () {
            $render = new \Blocksy_Header_Builder_Render();
            if ( !$render->contains_item( 'account' ) ) {
                return;
            }
            echo  blocksy_render_view( dirname( __FILE__ ) . '/header/account-modal.php' ) ;
        } );
    }
    
    public function get_conditions()
    {
        $option = get_theme_mod( 'blocksy_premium_header_conditions', [ [
            'id'         => 'type-1',
            'conditions' => [ [
            'type' => 'include',
            'rule' => 'everywhere',
        ] ],
        ] ] );
        if ( empty($option) ) {
            $option = [];
        }
        return $option;
    }
    
    public function set_conditions( $conditions )
    {
        set_theme_mod( 'blocksy_premium_header_conditions', $conditions );
    }
    
    private function maybe_get_header_that_matches( $all_sections )
    {
        $all_conditions = $this->get_conditions();
        foreach ( array_reverse( $all_sections['sections'] ) as $single_section ) {
            $conditions = [];
            if ( strpos( $single_section['id'], 'ct-custom' ) === false ) {
                continue;
            }
            foreach ( $all_conditions as $single_condition ) {
                if ( $single_condition['id'] === $single_section['id'] ) {
                    $conditions = $single_condition['conditions'];
                }
            }
            $conditions_manager = new \Blocksy\ConditionsManager();
            if ( $conditions_manager->condition_matches( $conditions ) ) {
                return $single_section['id'];
            }
        }
        return null;
    }

}