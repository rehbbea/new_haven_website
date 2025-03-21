<?php
/**
 * Section Title shortcode template
 */
?>

<div <?php eldritch_edge_class_attribute($classes); ?>>

    <?php if($subtitle_text != '') { ?>
        <div class="edgt-st-subtitle-holder">
            <<?php echo esc_attr($subtitle_tag); ?>
                class="edgt-st-subtitle" <?php eldritch_edge_inline_style($subtitle_style) ?>>
                <span><?php echo esc_attr($subtitle_text); ?></span>
            </<?php echo esc_attr($subtitle_tag); ?>>
        </div>
    <?php } ?>

    <?php if($title_text != '') { ?>
    <div class="edgt-st-inner">
        <div class="edgt-st-title-holder">
            <<?php echo esc_attr($title_tag); ?>
            class="edgt-st-title" <?php eldritch_edge_inline_style($title_style) ?>>
            <span><?php echo esc_attr($title_text); ?></span>
            </<?php echo esc_attr($title_tag); ?>>
        </div>
    </div>
    <?php } ?>
    <?php if ($separator_image_src !== '') { ?>
        <div class="edgt-separator-image">
            <img src="<?php echo esc_url($separator_image_src); ?>" alt="<?php esc_attr_e('Separator image', 'edge-core'); ?>"/>
        </div>
    <?php } ?>

    <div class="edgt-st-text-holder">
        <div class="edgt-st-text-text"><?php echo do_shortcode($content); ?></div>
    </div>

</div>