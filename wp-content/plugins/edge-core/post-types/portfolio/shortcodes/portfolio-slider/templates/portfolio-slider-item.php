<?php // This line is needed for mixItUp gutter ?>
    <article>
        <div class="edgt-portfolio-gallery-item">
            <div class="edgt-ptf-wrapper">
                <a class="edgt-portfolio-link" href="<?php echo esc_url(the_permalink()); ?>"></a>

                <div class="edgt-ptf-item-image-holder">
                    <?php if ($use_custom_image_size && (is_array($custom_image_sizes) && count($custom_image_sizes))) : ?>
                        <?php echo eldritch_edge_generate_thumbnail(get_post_thumbnail_id(get_the_ID()), null, $custom_image_sizes[0], $custom_image_sizes[1]); ?>
                    <?php else: ?>
                        <?php the_post_thumbnail($thumb_size); ?>
                    <?php endif; ?>
                </div>
                <div class="edgt-ptf-item-text-overlay" <?php eldritch_edge_inline_style($shader_styles); ?>>
                    <div class="edgt-ptf-item-text-overlay-inner">
                        <div class="edgt-ptf-item-text-holder">
                            <<?php echo esc_attr($title_tag); ?> class="edgt-ptf-item-title">
                            <a href="<?php echo esc_url(the_permalink()); ?>">
                                <?php echo esc_attr(get_the_title()); ?>
                            </a>
                        </<?php echo esc_attr($title_tag); ?>>
                        <?php if ($show_categories === 'yes') : ?>
                            <?php


                            $categories = wp_get_post_terms(get_the_ID(), 'portfolio-category');
                            $category_html = '<div class="edgt-ptf-category-holder">';
                            $k = 1;
                            foreach ($categories as $cat) {
                                $category_html .= '<span>' . $cat->name . '</span>';
                                if (count($categories) != $k) {
                                    $category_html .= ', ';
                                }
                                $k++;
                            }
                            $category_html .= '</div>';
                            ?>
                            <?php if (!empty($category_html)) : ?>
                                <?php echo eldritch_edge_get_module_part($category_html); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </article>
<?php // This line is needed for mixItUp gutter ?>