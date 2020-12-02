
<!-- Container карточек постов -->
<div class="container posts-container">

    <?php while ( have_posts() ) : the_post();

        get_template_part('template-parts/posts/content', 'card');

    endwhile; ?>

</div>