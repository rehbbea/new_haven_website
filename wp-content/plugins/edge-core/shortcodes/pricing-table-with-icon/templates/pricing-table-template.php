<div <?php eldritch_edge_class_attribute($classes); ?> <?php eldritch_edge_inline_style($inline_styles); ?> <?php echo eldritch_edge_get_inline_attrs($data_attrs); ?>>
    <div class="edgt-pricing-table-wi-inner">
        <div class="edgt-pt-icon" <?php eldritch_edge_inline_style($icon_inline_styles); ?>>
            <?php echo eldritch_edge_icon_collections()->renderIcon($icon, $icon_pack, $params); ?>
        </div>
        <h2 class="edgt-pt-title">
            <?php echo esc_html($title); ?>
        </h2>
        <h4 class="edgt-pt-subtitle">
            <?php echo esc_html($subtitle); ?>
        </h4>
        <?php if (!empty($price)) : ?>
            <div class="edgt-price-currency-period">
                <?php if (!empty($currency)) : ?>
                    <h2 class="edgt-currency" <?php eldritch_edge_inline_style($price_inline_styles); ?>><?php echo esc_html($currency); ?></h2>
                <?php endif; ?>

                <h2 class="edgt-price" <?php eldritch_edge_inline_style($price_inline_styles); ?>><?php echo esc_html($price); ?></h2>

                <?php if (!empty($price_period)) : ?>
                    <span class="edgt-price-period">/<?php echo esc_html($price_period) ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="edgt-pt-content">
            <ul>
                <li class="edgt-pt-content-inner">
                    <?php echo do_shortcode(preg_replace('#^<\/p>|<p>$#', '', $content)); ?>
                </li>
            </ul>
        </div>
        <?php if (is_array($button_params) && count($button_params)) : ?>
            <div class="edgt-price-button">
                <?php echo eldritch_edge_get_button_html($button_params); ?>
            </div>
        <?php endif; ?>
    </div>
</div>