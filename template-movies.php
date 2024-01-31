<?php
/*Template Name: Template Movies*/

get_header();




$args = [
    'post_type' => 'movie',
    'posts_per_page' => -1,
];

$movies = new WP_Query($args);  ?>


<main>




    <div class="movie-container" style="width: 80%; margin: 0 auto;">

        <br><br>

        <div class="js-filter">
            <?php $terms = get_terms(['taxonomoy' => 'movie_type']);

            if ($terms) : ?>

                <select name="cat" id="cat">
                    <option value="">Select Option</option>
                    <?php foreach ($terms as $term) : ?>

                        <option value="<?php echo $term->slug ?>"><?php echo $term->name ?></option>

                    <?php endforeach; ?>
                </select>

            <?php endif; ?>


            <select name="popularity" id="popularity">
                <option value="">Select Popularity</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>






        <?php if ($movies->have_posts()) : ?>


            <div class="js-movies row">
                <?php while ($movies->have_posts()) : $movies->the_post();

                    get_template_part('template_parts/loop', 'movie');


                endwhile;

                ?>
            </div>


        <?php endif; ?>
    </div>

</main>


<?php

get_footer();
?>