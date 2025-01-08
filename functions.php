<?php
function bookfestival_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    register_nav_menus( array(
        'main-menu' => __( 'Main Menu', 'bookfestival' ),
    ));
}
add_action( 'after_setup_theme', 'bookfestival_setup' );

function bookfestival_enqueue_styles() {
    wp_enqueue_style( 'bookfestival-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'bookfestival_enqueue_styles' );

function bookfestival_register_author_post_type() {
    $labels = array(
        'name'               => 'Authors',
        'singular_name'      => 'Author',
        'menu_name'          => 'Authors',
        'name_admin_bar'     => 'Author',
        'add_new'            => 'Add New Author',
        'add_new_item'       => 'Add New Author',
        'new_item'           => 'New Author',
        'edit_item'          => 'Edit Author',
        'view_item'          => 'View Author',
        'all_items'          => 'All Authors',
        'search_items'       => 'Search Authors',
        'not_found'          => 'No authors found.',
        'not_found_in_trash' => 'No authors found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'authors'),
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
    );

    register_post_type('author', $args);
}
add_action('init', 'bookfestival_register_author_post_type');

function bookfestival_add_author_meta_boxes() {
    add_meta_box(
        'author_details',
        'Author Details',
        'bookfestival_author_meta_box_callback',
        'author',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'bookfestival_add_author_meta_boxes');

function bookfestival_author_meta_box_callback($post) {
    // Retrieve existing meta data
    $books = get_post_meta($post->ID, '_author_books', true);
    $website = get_post_meta($post->ID, '_author_website', true);

    wp_nonce_field('bookfestival_save_author_meta', 'bookfestival_author_meta_nonce');
    ?>
    <p>
        <label for="author_books">Books:</label><br>
        <textarea id="author_books" name="author_books" rows="3" style="width:100%;"><?php echo esc_textarea($books); ?></textarea>
        <small>Enter a list of books (comma-separated).</small>
    </p>
    <p>
        <label for="author_website">Website:</label><br>
        <input type="url" id="author_website" name="author_website" value="<?php echo esc_url($website); ?>" style="width:100%;">
    </p>
    <?php
}

function bookfestival_save_author_meta($post_id) {
    if (!isset($_POST['bookfestival_author_meta_nonce']) || !wp_verify_nonce($_POST['bookfestival_author_meta_nonce'], 'bookfestival_save_author_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['author_books'])) {
        update_post_meta($post_id, '_author_books', sanitize_text_field($_POST['author_books']));
    }
    if (isset($_POST['author_website'])) {
        update_post_meta($post_id, '_author_website', esc_url_raw($_POST['author_website']));
    }
}
add_action('save_post', 'bookfestival_save_author_meta');

function bookfestival_enqueue_ticket_css() {
    if (is_page('ticket-booking')) {
        wp_enqueue_style('ticket-booking-css', get_template_directory_uri() . '/css/ticket-booking.css', array(), '1.0.0', 'all');
    }
}
add_action('wp_enqueue_scripts', 'bookfestival_enqueue_ticket_css');

function bookfestival_enqueue_woocommerce_styles() {
    // Shop Page
    if (is_shop()) {
        wp_enqueue_style('shop-css', get_template_directory_uri() . '/css/shop.css', array(), '1.0.0', 'all');
    }
    // Cart Page
    if (is_cart()) {
        wp_enqueue_style('cart-css', get_template_directory_uri() . '/css/cart.css', array(), '1.0.0', 'all');
    }
    // Checkout Page
    if (is_checkout()) {
        wp_enqueue_style('checkout-css', get_template_directory_uri() . '/css/checkout.css', array(), '1.0.0', 'all');
    }
    // My Account Page
    if (is_account_page()) {
        wp_enqueue_style('account-css', get_template_directory_uri() . '/css/account.css', array(), '1.0.0', 'all');
    }
}
add_action('wp_enqueue_scripts', 'bookfestival_enqueue_woocommerce_styles');

function enqueue_custom_single_product_styles() {
    if ( is_product() ) {
        wp_enqueue_style( 'custom-single-product', get_stylesheet_directory_uri() . '/css/custom-single-product.css' );
    }
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_single_product_styles' );

