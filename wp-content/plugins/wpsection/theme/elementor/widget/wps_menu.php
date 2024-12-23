<?php

use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Repeater;



class wpsection_wps_menu_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'wpsection_wps_menu';
	}

	public function get_title() {
		return __( 'Menu', 'wpsection' );
	}

	public function get_icon() {
		 return ' eicon-nav-menu';
	}

	public function get_keywords() {
		return [ 'wpsection', 'menu' ];
	}

	  public function get_categories() {
          return ['wpsection_category'];
    }


	

	protected function register_controls() {
		$this->start_controls_section(
			'menu_settings',
			[
				'label' => __( 'Menu General', 'wpsection' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);




        $this->end_controls_section();	


	}

	protected function render() {
		global $plugin_root;
		$settings = $this->get_settings_for_display();

?>

<?php
 echo '
 <style>
 
 //CSS code Will be here 
 
 
 
 //CSS code End Here
 
</style>';		
		

	
      echo '
     <script>
 jQuery(document).ready(function($)
 {

//put the js code under this line 


function headerStyle() {
	if ($(".main-header").length) {
		var windowpos = $(window).scrollTop();
		var siteHeader = $(".main-header");
		var scrollLink = $(".scroll-top");
		if (windowpos >= 110) {
			siteHeader.addClass("fixed-header");
			scrollLink.addClass("open");
		} else {
			siteHeader.removeClass("fixed-header");
			scrollLink.removeClass("open");
		}
	}
}

headerStyle();

//Submenu Dropdown Toggle
if ($(".main-header li.dropdown ul").length) {
	

	$(".main-header .navigation li.dropdown").append("<div class=\"dropdown-btn\"><span class=\"fas fa-angle-down\"></span></div>");


}


if ($(".mobile-menu").length) {
	$(".mobile-menu .menu-box").mCustomScrollbar();

	var mobileMenuContent = $(".main-header .menu-area .main-menu").html();
	$(".mobile-menu .menu-box .menu-outer").append(mobileMenuContent);
	$(".mr_menu_sticky .main-menu").append(mobileMenuContent);

	//Dropdown Button
	$(".mobile-menu li.dropdown .dropdown-btn").on("click", function() {
		$(this).toggleClass("open");
		$(this).prev("ul").slideToggle(500);
	});

	//Dropdown Button
	$(".mobile-menu li.dropdown .dropdown-btn").on("click", function() {
		$(this).prev(".megamenu").slideToggle(900);
	});

	//Menu Toggle Btn
	$(".mobile-nav-toggler").on("click", function() {
		$("body").addClass("mobile-menu-visible");
	});

	//Menu Toggle Btn
	$(".mobile-menu .menu-backdrop, .mobile-menu .close-btn").on("click", function() {
		$("body").removeClass("mobile-menu-visible");
	});
}


	$(window).on("scroll", function() {
		headerStyle();

	});



//put the code above the line 

  });
</script>';		
		
		
		
?>

<!-- main header -->
<header class="defult_seven mr_main-header mr_header-style-two">
	<!-- header-top -->
	<!-- header-lower -->
	<div class="mr_header-lower">
		<div class="mr_outer-box">
			<div class="mr_menu-area clearfix">
				<!--Mobile Navigation Toggler-->
				<div class="mr_mobile-nav-toggler">
					<i class="mr_icon-bar"></i>
					<i class="mr_icon-bar"></i>
					<i class="mr_icon-bar"></i>
				</div>
				<nav class="mr_main-menu navbar-expand-md navbar-light">
					<div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
						<ul class="mr_navigation clearfix">
							<?php wp_nav_menu( array( 'theme_location' => 'main_menu', 'container_id' => 'navbarSupportedContent',
							'container_class'=>'collapse navbar-collapse sub-menu-bar',
							'menu_class'=>'nav navbar-nav',
							'fallback_cb'=>false, 
							'add_li_class'  => 'nav-item',
							'items_wrap' => '%3$s', 
							'container'=>false,
							'depth'=>'3',
							'walker'=> new Bootstrap_walker()  
							) ); ?>
						</ul>
					</div>
				</nav>
			</div>
			<ul class="mr_nav-right">
			</ul>
		</div>
	</div>

	<!--sticky Header-->
	<div class="mr_menu_sticky ">
		<div class="mr_outer-container">
			<div class="mr_outer-box">
			
				<div class="mr_menu-area clearfix">
					<nav class="mr_main-menu clearfix">
						<!--Keep This Empty / Menu will come through Javascript-->
					</nav>
				
				</div>
			</div>
		</div>
	</div>
</header>
<!-- main-header end -->

<!-- Mobile Menu  -->
<div class="mr_mobile-menu">
	<div class="mr_menu-backdrop"></div>
	<div class="mr_close-btn"><i class="fas fa-times"></i></div>
	
	<nav class="mr_menu-box">
		
		<div class="mr_menu-outer"><!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
		
	</nav>
</div><!-- End Mobile Menu -->




        <?php

	}
}

// Register widget
Plugin::instance()->widgets_manager->register( new \wpsection_wps_menu_Widget() );