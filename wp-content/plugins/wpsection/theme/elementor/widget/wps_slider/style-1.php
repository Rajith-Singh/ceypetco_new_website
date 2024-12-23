<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;



$style    = $settings['style'] ;
$repeat    = $settings['repeat'] ;
$slider_path_background_size    = $settings['slider_path_background_size'] ;
$slider_path_background_position    = $settings['slider_path_background_position'] ;

$unique_id = 'wps_slider_path_' . uniqid();
?>



 <?php
      echo '
     <script>
 jQuery(document).ready(function($)
 {

//put the js code under this line 

if ($(".wpsection_banner-carousel-one").length) {
    $(".wpsection_banner-carousel-one").owlCarousel({

		   animateOut: "fadeOut",
            animateIn: "fadeIn",
            loop:true,
            margin:0,
            dots: true,
            nav:true,
            singleItem:true,
            smartSpeed: 500,
            autoplay: true,
            autoplayTimeout:6000,
           responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            800:{
                items:1
            },
            1024:{
                items:1
            }
        }
    });
}

//put the code above the line 

  });
</script>';


echo '
 <style>
 
 /* CSS code Will be here */
.wps_slider_style_one .slider_path_slide{
	position:relative;
	z-index:1;
	padding-top:150px;
}

.wps_slider_style_one .slider_path_slide:before{
  position: absolute;
  content: \'\';
  width: 100%;
  height: 100%;
  top: 0px;
  right: 0px;
  mix-blend-mode: multiply;
  z-index: -1;
  background:red;
}

.wps_slider_style_one .slider_path_slide:after{
  position: absolute;
  content: \'\';
  width: 100%;
  height: 100%;
  top: 0px;
  right: 0px;
  opacity: 0.6; 
  background:#222;
  
  z-index: -1;
	
	
}

.slider_path_button_box {
    padding: 5px 30px;
    background: #f7f7f7e0;
}

.slider_path_button_box_2 {
    padding: 5px 30px;
    background: #f7f7f7e0;
	margin-left:10px;
} 
 
 /* CSS code End Here */
 
</style>';


?>

<!-- This is the Main Area Astart=================== --> 
<div id="<?php echo esc_attr( $unique_id ); ?>" class="wps_slider_style_one slider_path wps_slider_path  slider_path_style-<?php echo esc_attr( $style ); ?> <?php echo esc_attr( $unique_id ); ?>">       

<!-- Slider Mask=================== -->
<div class="defult_slider_1">

		

				<!-- Slider for Plugin plugin_slides =================== --> 	
				<div class="wpsection_banner-carousel-one owl-theme owl-carousel owl_dots_one " >

						<!-- Slider For Each Area =================== --> 	
							<?php foreach ( $repeat as $item ) : ?>   

									<!-- Slider Elembnetor Template =================== --> 	
									<?php  if ( 'template' === $item['slider_type'] ) : ?>
									<div class="slider_path_elemntor">
										<?php 
											$post_id = slider_path_elemntor_content($item['slider_path_elemntor_template']);
											echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($post_id); ?>
									</div>
									<?php endif;?>
									<!-- Slider Elembnetor Template =================== --> 

									<!-- Slider Defult area =================== -->
									<?php  if ( 'content' === $item['slider_type'] ) :  ?>

									 <?php $slider_path_image = wpsection()->get_settings_atts( 'url', '', wpsection()->get_settings_atts( 'slider_path_image', '', $item ) );
									 ?>
										<div class="slider_path_slide"  style=" 
										background-image:url(<?php echo esc_url( $slider_path_image ); ?>);  
										background-size: <?php echo esc_attr($slider_path_background_size);?>;  
										background-position: <?php echo esc_attr($slider_path_background_position);?>; 
										
											">	
											<div class="slider_path_container slider_path_container_flex" >
												
											
												
												<div class="slider_path_left">  
															<?php if ( ! empty($item['slider_path_subtitle']) ) : ?>
															<h5 class="slider_path_subtitle"><?php echo esc_html($item['slider_path_subtitle']);?></h5>
															<?php endif; ?>

															<?php if ( ! empty($item['slider_path_title']) ) : ?>
															<h2 class="slider_path_title wow slideIn"><?php echo esc_html($item['slider_path_title']);?></h2>
															<?php endif; ?>


															<?php if ( ! empty($item['slider_path_text']) ) : ?>
															<p class="slider_path_text"><?php echo esc_html($item['slider_path_text']);?></p>
															<?php endif; ?>

														<div class=" slider_path_button_container">
															<?php if ( ! empty($item['slider_path_button']) ) : ?>
															<div class=" slider_path_button_box" style="max-width: 200px;">
																
																<a href=" <?php echo esc_url($item['slider_path_link']['url']);?>" class="slider_path_button"> <?php echo esc_html($item['slider_path_button']);?></a>
															</div>
															<?php endif; ?>
															<?php if ( ! empty($item['slider_path_button_2']) ) : ?>
															<div class=" slider_path_button_box_2" style="max-width: 200px;">
																<a href=" <?php echo esc_url($item['slider_path_link_2']['url']);?>" class="slider_path_button_2"> <?php echo esc_html($item['slider_path_button_2']);?></a>
															</div>
															<?php endif; ?>
														</div> 
													



													
													
												</div> 
										
										 </div> 
											</div>
										  
                			<!-- Slider Defult area =================== -->
                			<?php endif;?> 
					<!-- Slider For Each Area =================== --> 
   					<?php endforeach?>
				<!-- End  Plugin plugin_slides =================== --> 		
         		</div>    

		
<!-- End Slider Mask=================== -->
</div>   
	
<!-- End of Main Area =================== -->	
</div>