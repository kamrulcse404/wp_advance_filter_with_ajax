<div class="column column-4">
    <?php if (has_post_thumbnail()) : ?>
        <picture>
            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
        </picture>
    <?php endif; ?>

    <h4><?php the_title(); ?></h4>

    <?php
    $cats   = get_the_terms(get_the_ID(), 'movie_type');
    $rating = get_field('rating');

    if (!empty($cats) || !empty($rating)) :
    ?>
        <ul>
            <?php if (!empty($cats)) : ?>
                <li>
                    <strong>Category: </strong>

                    <?php
                    foreach ($cats as $cat) {
                        echo '<span>' . $cat->name . '</span>';
                    }
                    ?>
                </li>
            <?php endif;

            if (!empty($rating)) : ?>
                <li>
                    <strong>Rating:</strong>
                    <?php echo $rating; ?>
                </li>
            <?php endif; ?>
        </ul>
    <?php
    endif;
    ?>
</div>
