<?php

use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Repeater;



class wpsection_wps_search_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'wpsection_wps_search';
	}

	public function get_title() {
		return __( 'Search', 'wpsection' );
	}

	public function get_icon() {
		 return ' eicon-search';
	}

	public function get_keywords() {
		return [ 'wpsection', 'search' ];
	}

	  public function get_categories() {
         return ['wpsection_category'];
    }


	

	protected function register_controls() {
		$this->start_controls_section(
			'search_settings',
			[
				'label' => __( 'Search General', 'wpsection' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);




        $this->end_controls_section();	


	}

	protected function render() {
		global $plugin_root;
		$settings = $this->get_settings_for_display();

?>


    <div class="mr_nav-right">
        <div class="mr_search-box-outer mr_search-toggler">
            <i class="far fa-search"></i>
        </div>
    </div>
    <div id="mr_search-popup" class="mr_search-popup">
            <div class="mr_popup-inner">
                <div class="mr_overlay-layer"></div>
                <div class="auto-container">
                    <div class="mr_search-form">
                       <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">	
                            <div class="mr_form-group">
                               <fieldset>    
									<input type="search" name="s" class="form-control" placeholder="search_button" required="">
									<button  class="search_button"  type="submit"><i class="far fa-search"></i></button>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>



        <?php

	}
}

// Register widget
Plugin::instance()->widgets_manager->register( new \wpsection_wps_search_Widget() );