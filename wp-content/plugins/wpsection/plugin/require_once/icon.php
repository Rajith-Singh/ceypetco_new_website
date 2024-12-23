<?php



if (!class_exists('Icon')) {
    class Icon
    {
        public function __construct()
        {
            add_filter('elementor/icons_manager/additional_tabs', array($this, 'custom_icon'));
        }

        public function custom_icon($array)
        {
            $theme_assets_dir = get_template_directory() . '/assets/';

            return array(
                'custom-icon' => array(
                    'name'          => 'custom-icon',
                    'label'         => 'Theme Icon',
                    'url'           => '',
                    'enqueue'       => array(
                        $theme_assets_dir . 'customicon/flaticon.css',
                    ),

                    'prefix'        => '',
                    'displayPrefix' => '',
                    'labelIcon'     => 'custom-icon',
                    'ver'           => '',
                    'fetchJson'     => $theme_assets_dir . 'customicon/icons.json',
                    'native'        => 1,
                ),
            );
        }
    }

    new Icon();
}



