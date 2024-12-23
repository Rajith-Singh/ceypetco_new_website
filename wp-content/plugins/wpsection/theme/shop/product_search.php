<?php
//call this function to core file

if (!function_exists('make_year_func')) {
// Register Custom Taxonomy
	function make_year_func() {
		$labels = array(
			'name'              => _x( 'Years', 'wpsection' ),
			'singular_name'     => _x( 'Year', 'wpsection' ),
			'search_items'      => __( 'Search Year' ),
			'all_items'         => __( 'All Year' ),
			'parent_item'       => __( 'Parent Year' ),
			'parent_item_colon' => __( 'Parent Year:' ),
			'edit_item'         => __( 'Edit Year' ),
			'update_item'       => __( 'Update Year' ),
			'add_new_item'      => __( 'Add New Year' ),
			'new_item_name'     => __( 'New Year' ),
			'menu_name'         => __( 'Years' ),
		);
		$args   = array(
			'hierarchical'          => false,
			'public'                => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => false,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'product-year' ),
		);
		register_taxonomy( 'make_year', array( 'product' ), $args );
	}
	
add_action( 'init', 'make_year_func', 0 );	
}


if (!function_exists('make_brand_func')) {
 function make_brand_func() {
		$labels = array(
			'name'              => _x( 'Brands', 'wpsection' ),
			'singular_name'     => _x( 'Brand', 'wpsection' ),
			'search_items'      => __( 'Search Brand', 'wpsection' ),
			'all_items'         => __( 'All Brand', 'wpsection' ),
			'parent_item'       => __( 'Parent Brand', 'wpsection' ),
			'parent_item_colon' => __( 'Parent Brand:', 'wpsection' ),
			'edit_item'         => __( 'Edit Brand', 'wpsection' ),
			'update_item'       => __( 'Update Brand', 'wpsection' ),
			'add_new_item'      => __( 'Add New Brand', 'wpsection' ),
			'new_item_name'     => __( 'New Brand', 'wpsection' ),
			'menu_name'         => __( 'Brands', 'wpsection' ),
		);
		$args   = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => false,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'product-brand' ),
		);

		register_taxonomy( 'make_brand', array( 'product' ), $args );
	}
add_action( 'init', 'make_brand_func', 0 );	

	}

if (!function_exists('make_model_func')) {
	function make_model_func() {
		$labels = array(
			'name'              => _x( 'Models', 'wpsection' ),
			'singular_name'     => _x( 'Model', 'wpsection' ),
			'search_items'      => __( 'Search Model', 'wpsection' ),
			'all_items'         => __( 'All Model', 'wpsection' ),
			'parent_item'       => __( 'Parent Model', 'wpsection' ),
			'parent_item_colon' => __( 'Parent Model:', 'wpsection' ),
			'edit_item'         => __( 'Edit Model', 'wpsection' ),
			'update_item'       => __( 'Update Model', 'wpsection' ),
			'add_new_item'      => __( 'Add New Model', 'wpsection' ),
			'new_item_name'     => __( 'New Model', 'wpsection' ),
			'menu_name'         => __( 'Models', 'wpsection' ),
		);
		$args   = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => false,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'product-model' ),
		);

		register_taxonomy( 'make_model', array( 'product' ), $args );
	}
add_action( 'init', 'make_model_func', 0 );	
}
	
if (!function_exists('make_engine_func')) {	
	
	function make_engine_func() {
		$labels = array(
			'name'              => _x( 'Features', 'wpsection' ),
			'singular_name'     => _x( 'Features', 'wpsection' ),
			'search_items'      => __( 'Search Features' ),
			'all_items'         => __( 'All Features' ),
			'parent_item'       => __( 'Parent Features' ),
			'parent_item_colon' => __( 'Parent Features:' ),
			'edit_item'         => __( 'Edit Features' ),
			'update_item'       => __( 'Update Features' ),
			'add_new_item'      => __( 'Add New Features' ),
			'new_item_name'     => __( 'New Features' ),
			'menu_name'         => __( 'Features' ),
		);
		$args   = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => false,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'product-engine' ),
		);

		register_taxonomy( 'make_engine', array( 'product' ), $args );
	}
add_action( 'init', 'make_engine_func', 0 );	

}
	
	

//Query Short-codes [wpsection_auto_parts_search]

add_shortcode( 'wpsection_auto_parts_search', 'wpsection_auto_parts_search_func' );
function wpsection_auto_parts_search_func() {
	$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
	?>
	<form method="get" id="advanced-searchform" class="wpsection-parts-search-box-form" role="search" action="<?php echo $shop_page_url; ?>">
		  <input type="hidden" name="search" value="advanced">
		<select class="select-year-parts ignore wpsection-select-active" id="makeyear" name="makeyear">
			<option value=""><?php esc_html_e( 'Year', 'wpsection' ); ?></option>
			<?php
			$make_year = get_terms(
				array(
					'taxonomy'   => 'make_year',
					'hide_empty' => false,
				)
			);
			if ( ! empty( $make_year ) ) {
				foreach ( $make_year as $single ) {
					echo '<option value="' . $single->slug . '">' . $single->name . '</option>';
				}
			}
			?>
		</select>
		<select class="select-make-parts ignore wpsection-select-active" id="makebrand" name="brand" disabled>
			  <option value=""><?php esc_html_e( 'Make', 'wpsection' ); ?></option>
			<?php
			$make_brand = get_terms(
				array(
					'taxonomy'   => 'make_brand',
					'hide_empty' => false,
				)
			);
			if ( ! empty( $make_brand ) ) {
				foreach ( $make_brand as $single ) {
					echo '<option value="' . $single->slug . '">' . $single->name . '</option>';
				}
			}
			?>
		</select>
		<select class="select-model-parts ignore wpsection-select-active" id="makemodel" name="model" disabled>
			<option value=""><?php esc_html_e( 'Model', 'wpsection' ); ?></option>
			<?php
			$make_model = get_terms(
				array(
					'taxonomy'   => 'make_model',
					'hide_empty' => false,
				)
			);
			if ( ! empty( $make_model ) ) {
				foreach ( $make_model as $single ) {
					echo '<option value="' . $single->slug . '">' . $single->name . '</option>';
				}
			}
			?>
		</select>
		<select class="select-engine-parts ignore wpsection-select-active" id="makeengine" name="engine" disabled>
			<option value=""><?php esc_html_e( 'Features', 'wpsection' ); ?></option>
			<?php
			$make_engine = get_terms(
				array(
					'taxonomy'   => 'make_engine',
					'hide_empty' => false,
				)
			);
			if ( ! empty( $make_engine ) ) {
				foreach ( $make_engine as $single ) {
					echo '<option value="' . $single->slug . '">' . $single->name . '</option>';
				}
			}
			?>
		</select>
		<button class="wps_search_button"  type="submit"><?php esc_html_e( 'Search', 'wpsection' ); ?></button>
	  </form>
		<?php
}


add_filter( 'woocommerce_product_query', 'wpsection_advanced_search_query' );
function wpsection_advanced_search_query( $query ) {

	$makeyear   = '';
	$makebrand  = '';
	$makemodel  = '';
	$makeengine = '';

	// if ( isset( $_REQUEST['search'] ) && $_REQUEST['search'] == 'advanced' && ! is_admin() && $query->is_search && $query->is_main_query() ) {
	if ( isset( $_REQUEST['search'] ) == 'advanced' && ! is_admin() ) {
		if ( $query->query_vars['post_type'] == 'product' ) {
			$query->set( 'post_type', 'product' );

			if ( isset( $_GET['makeyear'] ) && ! empty( $_GET['makeyear'] ) ) {
				$makeyear = array(
					'taxonomy' => 'make_year',
					'terms'    => $_GET['makeyear'],
					'field'    => 'slug',
				);
			}

			if ( isset( $_GET['brand'] ) && ! empty( $_GET['brand'] ) ) {
				$makebrand = array(
					'taxonomy' => 'make_brand',
					'terms'    => $_GET['brand'],
					'field'    => 'slug',
				);
			}

			if ( isset( $_GET['model'] ) && ! empty( $_GET['model'] ) ) {
				$makemodel = array(
					'taxonomy' => 'make_model',
					'terms'    => $_GET['model'],
					'field'    => 'slug',
				);
			}

			if ( isset( $_GET['engine'] ) && ! empty( $_GET['engine'] ) ) {
				$makeengine = array(
					'taxonomy' => 'make_engine',
					'terms'    => $_GET['engine'],
					'field'    => 'slug',
				);
			}

			if ( ! empty( $makeyear ) && ! empty( $makebrand ) && ! empty( $makemodel ) && ! empty( $makeengine ) ) {

				$tax_query = array(
					'relation' => 'AND',
					$makeyear,
					$makebrand,
					$makemodel,
					$makeengine,
				);
			} elseif ( ! empty( $makeyear ) && ! empty( $makebrand ) && ! empty( $makemodel ) ) {
				$tax_query = array(
					'relation' => 'AND',
					$makeyear,
					$makebrand,
					$makemodel,
				);
			} elseif ( ! empty( $makeyear ) && ! empty( $makebrand ) ) {
				$tax_query = array(
					'relation' => 'AND',
					$makeyear,
					$makebrand,
				);
			} else {
				$tax_query = array(
					'relation' => 'AND',
					$makeyear,
				);
			}
			$query->set( 'tax_query', $tax_query );
		}
	}
	remove_filter( 'woocommerce_product_query', 'wpsection_advanced_search_query' );

}
