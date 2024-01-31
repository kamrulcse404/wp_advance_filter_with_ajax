<?php
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles()
{
    $parenthandle = 'parent-style';
    $theme = wp_get_theme();
    wp_enqueue_style(
        $parenthandle,
        get_template_directory_uri() . '/style.css',
        array(),
        $theme->parent()->get('Version')
    );
    wp_enqueue_style(
        'child-style',
        get_stylesheet_uri(),
        array($parenthandle),
        $theme->get('Version')
    );

    wp_enqueue_script(
        'scripts-js',
        get_stylesheet_directory_uri() . '/assets/js/scripts.js',
        array('jquery'),
        $theme->get('Version'),
        true
    );

    wp_localize_script('scripts-js', 'variables', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
}

add_action('init', 'register_custom_post_type');

function register_custom_post_type()
{
    register_post_type('movie', [
        'labels' => [
            'name' => 'Movie',
            'singular_name' => 'Movie',
            'menu_name' => 'Movie',
        ],
        'public' => true,
        'publicly_queryable' => true,
        'menu_icon' => 'dashicons-format-video',
        'has_archive' => true,
        'rewrite' => ['slug' => 'movie'],
        'supports' => [
            'title',
            'editor',
            // 'author',
            'thumbnail',
        ],
    ]);
}

add_action('init', 'register_taxonomies');

function register_taxonomies()
{

    register_taxonomy(
        'movie_type',
        ['movie'],
        [
            'hierarchical' => true,
            'labels' => [
                'name' => __('Categories'),
                'singular_name' => __('Category'),
                'menu_name' => __('Categories'),
            ],
            'show_ui' => true,
            'show_admin_column' => true,
            'rewrite' => ['slug' => __('type')],
        ]

    );
}



add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');

function filter_posts()
{
    $args = [
        'post_type'      => 'movie',
        'posts_per_page' => -1,
    ];

    $type = isset($_REQUEST['cat']) ? $_REQUEST['cat'] : '';
    $rating = isset($_REQUEST['rating']) ? $_REQUEST['rating'] : '';



    if (!empty($type)) {
        $args['tax_query'][] = [
            'taxonomy' => 'movie_type',
            'field'    => 'slug',
            'terms'    => $type,
        ];
    }

    if(!empty($rating)){
        $args['meta_query'][] = [
            'key' => 'rating',
            'value' => $rating,
            'compare' => '=',
        ];
    }

    $movies = new WP_Query($args);


    if ($movies->have_posts()) {
        while ($movies->have_posts()) {
            $movies->the_post();

            get_template_part('template_parts/loop', 'movie');
        }
        wp_reset_postdata();
    }else{
        echo "Post Not Found";
    }


    wp_die();
}
