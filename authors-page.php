<?php
/*
Template Name: Authors Page
*/
get_header();
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/authors.css">
<section class="authors">
    <h1>Our Authors</h1>
    <div class="author-list">
        <?php
        $authors = new WP_Query(array(
            'post_type' => 'author',
            'posts_per_page' => -1,
        ));

        if ($authors->have_posts()):
            while ($authors->have_posts()): $authors->the_post();
                $books = get_post_meta(get_the_ID(), '_author_books', true);
                $website = get_post_meta(get_the_ID(), '_author_website', true);
        ?>
                <article class="author">
                    <h2><?php the_title(); ?></h2>
                    <?php if (has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>">
                    <?php endif; ?>
                    <p><?php the_content(); ?></p>
                    <p><strong>Books:</strong> <?php echo esc_html($books); ?></p>
                    <?php if ($website): ?>
                        <p><a href="<?php echo esc_url($website); ?>" target="_blank">Visit Author's Website</a></p>
                    <?php endif; ?>
                </article>
        <?php
            endwhile;
            wp_reset_postdata();
        else:
            echo '<p>No authors found.</p>';
        endif;
        ?>
    </div>
</section>
<?php
get_footer();
?>
