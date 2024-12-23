<?php
/**
 * Mrshop Settings
 *
 */



    

//*******======Shop Related Code =====**/

// This code show the mumber of post on shop page coming from theme option 
function mahtim_related_products_limit() {
    global $product;
    $args['posts_per_page'] = 6;
    return $args;
}

// This code show the mumber of post on shop page coming from theme option 
function mahtim_loop_shop_per_page($cols) {
    $options = mahtim_WSH()->option();
    $shop_product = esc_attr($options->get('shop_product'));
    $cols = $shop_product;
    return $cols;
}


/**
 * Display the total review count for a product in a WooCommerce template.
 */
function display_review_count() {
    global $product;

    // Check if the product has an average rating (meaning there are reviews).
    if ( $product->get_average_rating() ) {
        $product_id = $product->get_id(); // Get the product ID
        $review_count_var = get_wc_total_review_count($product_id); // Call the function to get the review count

        // Output the review count in a span element.
        echo '<span class="mr_review_number">' . esc_html($review_count_var) . '</span>';
    }
}

function get_wc_total_review_count($product_id) {
    global $wpdb;

    // WooCommerce product reviews are stored in the 'wp_comments' table.
    $query = "SELECT COUNT(comment_ID)
              FROM {$wpdb->comments}
              WHERE comment_post_ID = %d
              AND comment_approved = 1
              AND comment_type = 'review'";
    $review_count = $wpdb->get_var($wpdb->prepare($query, $product_id));

    return (int) $review_count;
}

/*===============================
    Quick View
==============================*/
 
function wpsection_quick_view_scripts() {
    wp_enqueue_script('wc-add-to-cart-variation');
  
        wp_enqueue_style( 'quick-view', get_template_directory_uri() . '/assets/css/quick-view.css' );
        wp_enqueue_style( 'popupcss', get_template_directory_uri() . '/assets/css/popupcss.css' );
        wp_enqueue_script( 'magnific-popup', get_template_directory_uri().'/assets/js/jquery.magnific-popup.js', array( 'jquery' ), '1.1.0', true );
        wp_enqueue_script( 'wpsection-quick-ajax', get_template_directory_uri().'/assets/js/quick.js', array( 'jquery' ), '1.0.0', true );

         // Generate a nonce token
         $wpsection_nonce = wp_create_nonce('wpsection_nonce'); 
         // Add the nonce to the localized script
         wp_localize_script('wpsection-quick-ajax', 'WpsectionAjax', array(
             'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
             'nonce' => $wpsection_nonce, // Add the nonce to the array
         ));

}
add_action( 'wp_enqueue_scripts', 'wpsection_quick_view_scripts' );
 
/*
**================================== 
**  quick view output
**==================================
*/
add_action( 'wp_ajax_nopriv_quick_view', 'wpsection_get_quick_view' );
add_action( 'wp_ajax_quick_view', 'wpsection_get_quick_view' );
function wpsection_get_quick_view(){
    $id = intval( $_POST['id'] );
    $query_args = array(
        'p' => $id,
        'post_type' => 'product',
    );
    $post_query = new WP_Query($query_args);
    if ($post_query->have_posts()) : 
     while($post_query->have_posts()) : $post_query->the_post(); 
        do_action('get_wpsection_quick_view_get');
     endwhile; 
    wp_reset_postdata();
    endif;

}

add_action('get_wpsection_quick_view_get', 'wpsection_quick_view_get');
function wpsection_quick_view_get()
{
    global $product, $woocommerce;
    $product_type = get_post_meta(get_the_ID(), 'product_type', true);
    $product_mfg = get_post_meta(get_the_ID(), 'product_mfg', true);
    $product_life = get_post_meta(get_the_ID(), 'product_life', true);
    ?>
 
        <div class="wps_quick_view position_four"> 
                <div id="product-<?php the_ID(); ?>" <?php post_class($classes); ?>>
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <?php woocommerce_show_product_images(); ?> 
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="summary entry-summary scrollbarcolor"> 
                                <div class="top_content_single">
                                    <?php do_action('get_wpsection_current_product_category'); ?>
                                    <div class="title"><?php do_action('wpsection_single_title'); ?></div>
                                    <div class="divborder"></div>
                                    <?php do_action('wpsection_single_rating'); ?>
                                    <?php do_action('wpsection_single_meta'); ?> 
                                
                                </div>
                                <div class="top_min_single"> 
								
                                <?php
                                /** 
                                 * Hook: woocommerce_single_product_summary.
                                 *
                                 * @hooked woocommerce_template_single_title - 5
                                 * @hooked woocommerce_template_single_rating - 10
                                 * @hooked woocommerce_template_single_price - 10
                                 * @hooked woocommerce_template_single_excerpt - 20
                                 * @hooked woocommerce_template_single_add_to_cart - 30
                                 * @hooked woocommerce_template_single_meta - 40
                                 * @hooked woocommerce_template_single_sharing - 50
                                 * @hooked WC_Structured_Data::generate_product_data() - 60
                                 */
                                do_action( 'woocommerce_single_product_summary' );
                                ?>
								<button class="wps_quick_view_cart"><a href="<?php echo site_url(); ?>/cart ">View Cart</a></button>	
                                </div>
                                <div class="top_bottom_single">
                                <?php do_action('wpsection_single_excerpt'); ?> 
                                <?php do_action('wpsection_single_sharing'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
      
        </div>       
   
    <?php
}


if ( ! function_exists( 'mr_all_cat_list' ) ) {
    function mr_all_cat_list( ) {
        $elements = get_terms( 'product_cat', array('hide_empty' => false) );
        $product_cat_array = array();

        if ( !empty($elements) ) {
            foreach ( $elements as $element ) {
                $info = get_term($element, 'product_cat');
                $product_cat_array[ $info->term_id ] = $info->name;
            }
        }
    
        return $product_cat_array;
    }

}



if ( ! function_exists( 'mr_shop_product_cat_list' ) ) {
    function mr_shop_product_cat_list( ) {
        $elements = get_terms( 'product_cat', array('hide_empty' => false) );
        $product_cat_array = array();

        if ( !empty($elements) ) {
            foreach ( $elements as $element ) {
                $info = get_term($element, 'product_cat');
                $product_cat_array[ $info->term_id ] = $info->name;
            }
        }
    
        return $product_cat_array;
    }

    function mr_shop_product_tag_list( ) {
        $elements = get_terms( 'product_tag', array('hide_empty' => false) );
        $product_cat_array = array();

        if ( !empty($elements) ) {
            foreach ( $elements as $element ) {
                $info = get_term($element, 'product_tag');
                $product_cat_array[ $info->term_id ] = $info->name;
            }
        }
    
        return $product_cat_array;
    }

}
if ( ! function_exists( 'mr_product_rating' ) ) {

    function mr_product_rating() {
        global $product;
        $rating = intval( $product->get_average_rating() );

        // If there's a rating, display the full stars and the remaining empty stars.
        // If no rating, display all 5 empty stars.
        $full_stars = $rating > 0 ? $rating : 0;
        $empty_stars = 5 - $full_stars;

        ?>
        <ul class="mr_star_rating">
            <?php
            for ( $rs = 1; $rs <= $full_stars; $rs++ ) {
                echo '<li class="mr_star_full"><i class="eicon-star"></i></li>';
            }
            for ( $rns = 1; $rns <= $empty_stars; $rns++ ) {
                echo '<li class="mr_star_empty"><i class="eicon-star-o"></i></li>';
            }
            ?>
        </ul>
        <?php
    }
}


//function for Hot Sale

if ( ! function_exists( 'mr_product_cat_list' ) ) {
function mr_product_cat_list( ) {
 
    $term_id = 'product_cat';
    $categories = get_terms( $term_id );
 
    $cat_array['all'] = "Categories";

    if ( !empty($categories) ) {
        foreach ( $categories as $cat ) {
            $cat_info = get_term($cat, $term_id);
            $cat_array[ $cat_info->slug ] = $cat_info->name;
        }
    }
 
    return $cat_array;
}

}

if ( ! function_exists( 'mr_product_tag_list' ) ) {
function mr_product_tag_list( ) {
 
    $term_id = 'product_tag';
    $tag = get_terms( $term_id );
 
    $tag_array['all'] = "Tags";

    if ( !empty($tag) ) {
        foreach ( $tag as $tag ) {
            $tag_info = get_term($tag, $term_id);
            $tag_array[ $tag_info->slug ] = $tag_info->name;
        }
    }
 
    return $tag_array;
}
}
if ( ! function_exists( 'mr_get_product_prices' ) ) {
function mr_get_product_prices( $product ) {

    $saleargs = array(
        'qty'   => '1',
        'price' => $product->get_sale_price(),
    );
    $args     = array(
        'qty'   => '1',
        'price' => $product->get_regular_price(),
    );

    $tax_display_mode      = get_option( 'woocommerce_tax_display_shop' );
    $display_price         = $tax_display_mode == 'incl' ? wc_get_price_including_tax( $product ) : wc_get_price_excluding_tax( $product );
    $display_regular_price = $tax_display_mode == 'incl' ? wc_get_price_including_tax( $product, $args ) : wc_get_price_excluding_tax( $product, $args );
    $display_sale_price    = $tax_display_mode == 'incl' ? wc_get_price_including_tax( $product, $saleargs ) : wc_get_price_excluding_tax( $product, $saleargs );
    switch ( $product->get_type() ) {
        case 'variable':
            $price = $product->get_variation_regular_price( 'min', true );
            $sale  = $display_price;
            break;
        case 'simple':
            $price = $display_regular_price;
            $sale  = $display_sale_price;
            break;
    }
    if ( isset( $sale ) && ! empty( $sale ) && isset( $price ) && ! empty( $price ) ) {
        return array(
            'sale'  => $sale,
            'price' => $price,
        );
    }
    return false;
}
}


if ( ! function_exists( 'mr_product_special_price_calc' ) ) {
function mr_product_special_price_calc( $data ) {
    // sale and price
    if ( ! empty( $data ) ) {
        extract( $data );
    }
    $prefix = '';
    if ( isset( $sale ) && ! empty( $sale ) && isset( $price ) && ! empty( $price ) ) {
        if ( $price > $sale ) {
            $prefix  = '-';
            $dval    = $price - $sale;
            $percent = ( $dval / $price ) * 100;
        }
    }

    if ( isset( $percent ) && ! empty( $percent ) ) {
        return array(
            'prefix'  => $prefix,
            'percent' => round( $percent ),
        );
    }
    return false;
}

}
