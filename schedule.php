<?php
/* Template Name: Festival Schedule */
get_header(); ?>

<div class="schedule-container">
    <h1>Schedule</h1>

    <?php
    // Query the 'day' custom post type
    $schedule_query = new WP_Query([
        'post_type' => 'day',
        'posts_per_page' => -1, // Display all posts
        'orderby' => 'meta_value', // Order by a meta field (e.g., date)
        'meta_key' => 'date', // Replace 'date' with your actual ACF field key
        'order' => 'ASC', // Ascending order
    ]);

    if ($schedule_query->have_posts()) :
        while ($schedule_query->have_posts()) : $schedule_query->the_post(); ?>

            <div class="schedule-item">
                <h2><?php the_field('day'); ?></h2>
                <p><strong>Date and Time:</strong> <?php the_field('date'); ?></p>
                <p><strong>Location:</strong> <?php the_field('location'); ?></p>
                <div class="description">
                    <?php the_field('summary'); ?>
                </div>
                <p><strong>First Guest Speaker:</strong> <?php the_field('speaker_1'); ?></p>
                <div class="description">
                    <?php the_field('speaker_1_summary'); ?>
                </div>
                <p><strong>Get your tickets here:</strong> <?php the_field('speaker_1_tickets_link'); ?></p>
                <p><strong>Second Guest Speaker:</strong> <?php the_field('speaker_2'); ?></p>
                <div class="description">
                    <?php the_field('speaker_2_summary'); ?>
                </div>
                <p><strong>Get your tickets here:</strong> <?php the_field('speaker_2_tickets_link'); ?></p>
                
            </div>

        <?php endwhile;
        wp_reset_postdata();
    else : ?>
        <p>No schedule available.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
