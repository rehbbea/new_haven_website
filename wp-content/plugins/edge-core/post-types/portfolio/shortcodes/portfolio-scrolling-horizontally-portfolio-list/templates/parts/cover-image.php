<?php if ($cover_image): ?>
    <div class="edgt-hspl-cover-image" style="background-image: url(<?php echo wp_get_attachment_url($cover_image); ?>);">
        <div class="edgt-hspl-cover-image-text-holder">
            <div class="edgt-hspl-cover-image-text-holder-inner">
                <?php if ($cover_image_title) : ?>
                    <h1 class="edgt-hspl-cover-image-title"><?php echo esc_attr($cover_image_title); ?></h1>
                <?php endif; ?>
                <?php if ($cover_image_subtitle) : ?>
                    <h2 class="edgt-hspl-cover-image-subtitle"><?php echo esc_attr($cover_image_subtitle); ?></h2>
                <?php endif; ?>

                <div class="edgt-hspl-cover-image-button-holder">
                    <?php if ($cover_image_button_one) : ?>
                        <?php echo eldritch_edge_get_button_html($cover_image_button_one); ?>
                    <?php endif; ?>

                    <?php if ($cover_image_button_two) : ?>
                        <?php echo eldritch_edge_get_button_html($cover_image_button_two); ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
<?php endif; ?>