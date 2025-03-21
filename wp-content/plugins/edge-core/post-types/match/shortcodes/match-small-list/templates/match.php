<article <?php echo edgt_core_get_class_attribute($item_classes); ?>>
    <div class="edgt-match-item-holder">
        <a class="edgt-match-link" <?php echo eldritch_edge_get_inline_attrs($link_atts); ?>></a>
        <div class="edgt-match-single-team">
            <div class="edgt-match-item-image-holder">
                <img src="<?php echo esc_url($team_one_image); ?>" alt="<?php echo esc_attr($team_one_name); ?>" />
                <?php echo wp_get_attachment_image($team_one_image, array( 42, 42 )); ?>
            </div>
        </div>
        <div class="edgt-match-vs-image">
            <img src="<?php echo esc_url($vs_image); ?>" alt="<?php esc_attr_e('Match image', 'edge-core'); ?>" />
        </div>
        <div class="edgt-match-single-team">
            <div class="edgt-match-item-image-holder">
                <img src="<?php echo esc_url($team_two_image); ?>" alt="<?php echo esc_attr($team_two_name); ?>" />
            </div>
        </div>
        <div class="edgt-match-info">
            <<?php echo esc_attr($team_title_tag); ?> class="edgt-match-team-title">
                <?php echo esc_attr($team_one_name); ?>
            </<?php echo esc_attr($team_title_tag); ?>>
            <span><?php echo esc_html('VS', 'eldrith') ?></span>
            <<?php echo esc_attr($team_title_tag); ?> class="edgt-match-team-title">
                <?php echo esc_attr($team_two_name); ?>
            </<?php echo esc_attr($team_title_tag); ?>>
            <div class="edgt-match-meta">
                <?php if($category != ''){ ?>
                    <?php echo eldritch_edge_get_module_part($category); ?>
                <?php } ?>
                <?php if($date != ''){ ?>
                    <?php echo eldritch_edge_get_module_part($date); ?>
                <?php } ?>
            </div>

        </div>
        <?php if($result != ''){ ?>
            <div class="edgt-match-result-holder">
                <span class="edgt-match-info-status"><?php echo esc_attr($result); ?></span>
            </div>
        <?php } ?>
    </div>
</article>