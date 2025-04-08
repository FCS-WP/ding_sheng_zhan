<?php
/**
 * Dokan Seller Single product tab Template
 *
 * @since 2.4
 *
 * @package dokan
 */

$store_address            = dokan_get_seller_short_address( $author->ID, false );
$social_fields            = dokan_get_social_profile_fields();
$store_user = dokan_get_vendor($author->ID);
$social_info              = $store_info['social'];

$dokan_store_time_enabled = isset( $store_info['dokan_store_time_enabled'] ) ? $store_info['dokan_store_time_enabled'] : '';
$store_open_notice        = isset( $store_info['dokan_store_open_notice'] ) && ! empty( $store_info['dokan_store_open_notice'] ) ? $store_info['dokan_store_open_notice'] : esc_html__( 'Store Open', 'farmart' );
$store_closed_notice      = isset( $store_info['dokan_store_close_notice'] ) && ! empty( $store_info['dokan_store_close_notice'] ) ? $store_info['dokan_store_close_notice'] : esc_html__( 'Store Closed', 'farmart' );
$show_store_open_close    = dokan_get_option( 'store_open_close', 'dokan_appearance', 'on' );
?>

<div class="dokan-single-store">
    <div class="profile-frame">
        <div class="profile-info-box profile-layout-fm_custom">
            <div class="profile-info-summery-wrapper">
                <div class="profile-info-summery">
                    <?php if ( $store_info['banner'] ) : ?>
                        <div class="profile-info-head">
                            <div class="profile-img">
                                <?php
                                    echo wp_get_attachment_image(  $store_info['banner'], 'farmart-dokan-banner' );
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="profile-info">
                        <div class="profile-avatar">
                            <?php echo get_avatar( $author->ID ); ?>
                        </div>

                        <div class="profile-info-content">

                            <?php if ( ! empty( $store_info['store_name'] ) ) { ?>
                                <h1 class="store-name"><?php echo esc_html( $store_info['store_name'] ); ?></h1>
                            <?php } ?>

                            <div class="dokan-store-information">
                                <ul class="dokan-store-info">
                                    <li class="dokan-store-rating">
                                    <div class="star-rating seller-rating">
                                    <?php
                                        $store_rating = $store_user->get_rating();
                                        echo farmart_star_rating_html( '', $store_rating['rating'], $store_rating['count'] );
                                    ?>

                                    </div>
                                    <?php
                                    echo sprintf(
                                        '<div class="text"><span class="primary-color">%s</span>%s%s%s</div>',
                                        $store_rating['rating'],
                                        esc_html__( ' rating from ', 'farmart' ),
                                        $store_rating['count'],
                                        $store_rating['count'] != 1 ? esc_html__( ' reviews', 'farmart' ) : esc_html__( ' review', 'farmart' )
                                    );
                                     ?>
                                    </li>

                                    <?php if ( isset( $store_address ) && !empty( $store_address ) ) { ?>
                                        <li class="dokan-store-address">
                                            <?php echo ! empty( $store_address ) ? $store_address : ''; ?>
                                        </li>
                                    <?php } ?>

                                    <?php if ( !empty( $store_info['phone'] ) ) { ?>
                                        <li class="dokan-store-phone">
                                            <a href="tel:<?php echo esc_html( $store_info['phone'] ); ?>"><?php echo esc_html( $store_info['phone'] ); ?></a>
                                        </li>
                                    <?php } ?>

                                    <?php if ( $store_info['show_email'] == 'yes' ) { ?>
                                        <li class="dokan-store-email">
                                            <a href="mailto:<?php echo esc_attr( antispambot( $store_info['email'] ) ); ?>"><?php echo esc_html( antispambot( $store_info['email'] ) ); ?></a>
                                        </li>
                                    <?php } ?>

                                    <?php do_action( 'dokan_store_header_info_fields',  $author->ID ); ?>
                                </ul>
                                <ul class="dokan-store-info">
                                    <?php if ( $author->user_registered ) { ?>
                                        <li class="dokan-store-register-date">
                                            <?php
                                                $originalDate = $author->user_registered;
                                                $newDate = date("M d, Y", strtotime($originalDate));
                                                echo sprintf( '<span>%s</span>%s', esc_html__('Started from: ', 'farmart'), $newDate );
                                            ?>
                                        </li>
                                    <?php } ?>

                                    <?php if ( $show_store_open_close == 'on' && $dokan_store_time_enabled == 'yes') : ?>
                                        <li class="dokan-store-open-close">
                                            <?php if ( dokan_is_store_open( $author->ID ) ) {
                                                echo esc_attr( $store_open_notice );
                                            } else {
                                                echo esc_attr( $store_closed_notice );
                                            } ?>
                                        </li>
                                    <?php endif ?>
                                </ul>
                            </div>

                            <?php if ( $social_fields ) {
                                $social_icon = 'social_';
                                $social_html = array();

                                ?>
                                <div class="store-social-wrapper">
                                    <?php foreach ( $social_fields as $key => $field ) { ?>
                                        <?php if ( ! empty( $social_info[ $key ] ) ) {
                                            $icon_html = '';
                                            if ( $key == 'fb' ) {
                                                $icon_html = '<svg viewBox="0 0 32 32"><path d="M19 6h5v-6h-5c-3.86 0-7 3.14-7 7v3h-4v6h4v16h6v-16h5l1-6h-6v-3c0-0.542 0.458-1 1-1z"></path></svg>';
                                            } elseif ( $key == 'twitter' ){
                                                $icon_html = '<svg viewBox="0 0 32 32"><path d="M32 7.075c-1.175 0.525-2.444 0.875-3.769 1.031 1.356-0.813 2.394-2.1 2.887-3.631-1.269 0.75-2.675 1.3-4.169 1.594-1.2-1.275-2.906-2.069-4.794-2.069-3.625 0-6.563 2.938-6.563 6.563 0 0.512 0.056 1.012 0.169 1.494-5.456-0.275-10.294-2.888-13.531-6.862-0.563 0.969-0.887 2.1-0.887 3.3 0 2.275 1.156 4.287 2.919 5.463-1.075-0.031-2.087-0.331-2.975-0.819 0 0.025 0 0.056 0 0.081 0 3.181 2.263 5.838 5.269 6.437-0.55 0.15-1.131 0.231-1.731 0.231-0.425 0-0.831-0.044-1.237-0.119 0.838 2.606 3.263 4.506 6.131 4.563-2.25 1.762-5.075 2.813-8.156 2.813-0.531 0-1.050-0.031-1.569-0.094 2.913 1.869 6.362 2.95 10.069 2.95 12.075 0 18.681-10.006 18.681-18.681 0-0.287-0.006-0.569-0.019-0.85 1.281-0.919 2.394-2.075 3.275-3.394z"></path></svg>';
                                            } elseif ( $key == 'pinterest' ){
                                                $icon_html = '<svg viewBox="0 0 32 32"><path d="M16 0c-8.825 0-16 7.175-16 16s7.175 16 16 16 16-7.175 16-16-7.175-16-16-16zM16 29.863c-1.431 0-2.806-0.219-4.106-0.619 0.563-0.919 1.412-2.431 1.725-3.631 0.169-0.65 0.863-3.294 0.863-3.294 0.45 0.863 1.775 1.594 3.175 1.594 4.181 0 7.194-3.844 7.194-8.625 0-4.581-3.738-8.006-8.544-8.006-5.981 0-9.156 4.019-9.156 8.387 0 2.031 1.081 4.563 2.813 5.369 0.262 0.125 0.4 0.069 0.463-0.188 0.044-0.194 0.281-1.131 0.387-1.575 0.031-0.137 0.019-0.262-0.094-0.4-0.575-0.694-1.031-1.975-1.031-3.162 0-3.056 2.313-6.019 6.256-6.019 3.406 0 5.788 2.319 5.788 5.637 0 3.75-1.894 6.35-4.356 6.35-1.363 0-2.381-1.125-2.050-2.506 0.394-1.65 1.15-3.425 1.15-4.613 0-1.063-0.569-1.95-1.756-1.95-1.394 0-2.506 1.438-2.506 3.369 0 1.225 0.412 2.056 0.412 2.056s-1.375 5.806-1.625 6.887c-0.281 1.2-0.169 2.881-0.050 3.975-5.156-2.012-8.813-7.025-8.813-12.9 0-7.656 6.206-13.863 13.862-13.863s13.863 6.206 13.863 13.863c0 7.656-6.206 13.863-13.863 13.863z"></path></svg>';
                                            } elseif ( $key == 'linkedin' ){
                                                $icon_html = '<svg viewBox="0 0 32 32"><path d="M12 12h5.535v2.837h0.079c0.77-1.381 2.655-2.837 5.464-2.837 5.842 0 6.922 3.637 6.922 8.367v9.633h-5.769v-8.54c0-2.037-0.042-4.657-3.001-4.657-3.005 0-3.463 2.218-3.463 4.509v8.688h-5.767v-18z"></path><path d="M2 12h6v18h-6v-18z"></path><path d="M8 7c0 1.657-1.343 3-3 3s-3-1.343-3-3c0-1.657 1.343-3 3-3s3 1.343 3 3z"></path></svg>';
                                            } elseif ( $key == 'youtube' ){
                                                $icon_html = '<svg viewBox="0 0 32 32"><path d="M31.681 9.6c0 0-0.313-2.206-1.275-3.175-1.219-1.275-2.581-1.281-3.206-1.356-4.475-0.325-11.194-0.325-11.194-0.325h-0.012c0 0-6.719 0-11.194 0.325-0.625 0.075-1.987 0.081-3.206 1.356-0.963 0.969-1.269 3.175-1.269 3.175s-0.319 2.588-0.319 5.181v2.425c0 2.587 0.319 5.181 0.319 5.181s0.313 2.206 1.269 3.175c1.219 1.275 2.819 1.231 3.531 1.369 2.563 0.244 10.881 0.319 10.881 0.319s6.725-0.012 11.2-0.331c0.625-0.075 1.988-0.081 3.206-1.356 0.962-0.969 1.275-3.175 1.275-3.175s0.319-2.587 0.319-5.181v-2.425c-0.006-2.588-0.325-5.181-0.325-5.181zM12.694 20.15v-8.994l8.644 4.513-8.644 4.481z"></path></svg>';
                                            } elseif ( $key == 'instagram' ){
                                                $icon_html = '<svg viewBox="0 0 32 32"><path d="M16 2.881c4.275 0 4.781 0.019 6.462 0.094 1.563 0.069 2.406 0.331 2.969 0.55 0.744 0.288 1.281 0.638 1.837 1.194 0.563 0.563 0.906 1.094 1.2 1.838 0.219 0.563 0.481 1.412 0.55 2.969 0.075 1.688 0.094 2.194 0.094 6.463s-0.019 4.781-0.094 6.463c-0.069 1.563-0.331 2.406-0.55 2.969-0.288 0.744-0.637 1.281-1.194 1.837-0.563 0.563-1.094 0.906-1.837 1.2-0.563 0.219-1.413 0.481-2.969 0.55-1.688 0.075-2.194 0.094-6.463 0.094s-4.781-0.019-6.463-0.094c-1.563-0.069-2.406-0.331-2.969-0.55-0.744-0.288-1.281-0.637-1.838-1.194-0.563-0.563-0.906-1.094-1.2-1.837-0.219-0.563-0.481-1.413-0.55-2.969-0.075-1.688-0.094-2.194-0.094-6.463s0.019-4.781 0.094-6.463c0.069-1.563 0.331-2.406 0.55-2.969 0.288-0.744 0.638-1.281 1.194-1.838 0.563-0.563 1.094-0.906 1.838-1.2 0.563-0.219 1.412-0.481 2.969-0.55 1.681-0.075 2.188-0.094 6.463-0.094zM16 0c-4.344 0-4.887 0.019-6.594 0.094-1.7 0.075-2.869 0.35-3.881 0.744-1.056 0.412-1.95 0.956-2.837 1.85-0.894 0.888-1.438 1.781-1.85 2.831-0.394 1.019-0.669 2.181-0.744 3.881-0.075 1.713-0.094 2.256-0.094 6.6s0.019 4.887 0.094 6.594c0.075 1.7 0.35 2.869 0.744 3.881 0.413 1.056 0.956 1.95 1.85 2.837 0.887 0.887 1.781 1.438 2.831 1.844 1.019 0.394 2.181 0.669 3.881 0.744 1.706 0.075 2.25 0.094 6.594 0.094s4.888-0.019 6.594-0.094c1.7-0.075 2.869-0.35 3.881-0.744 1.050-0.406 1.944-0.956 2.831-1.844s1.438-1.781 1.844-2.831c0.394-1.019 0.669-2.181 0.744-3.881 0.075-1.706 0.094-2.25 0.094-6.594s-0.019-4.887-0.094-6.594c-0.075-1.7-0.35-2.869-0.744-3.881-0.394-1.063-0.938-1.956-1.831-2.844-0.887-0.887-1.781-1.438-2.831-1.844-1.019-0.394-2.181-0.669-3.881-0.744-1.712-0.081-2.256-0.1-6.6-0.1v0z"></path><path d="M16 7.781c-4.537 0-8.219 3.681-8.219 8.219s3.681 8.219 8.219 8.219 8.219-3.681 8.219-8.219c0-4.537-3.681-8.219-8.219-8.219zM16 21.331c-2.944 0-5.331-2.387-5.331-5.331s2.387-5.331 5.331-5.331c2.944 0 5.331 2.387 5.331 5.331s-2.387 5.331-5.331 5.331z"></path><path d="M26.462 7.456c0 1.060-0.859 1.919-1.919 1.919s-1.919-0.859-1.919-1.919c0-1.060 0.859-1.919 1.919-1.919s1.919 0.859 1.919 1.919z"></path></svg>';
                                            } elseif ( $key == 'flickr' ){
                                                $icon_html = '<svg viewBox="0 0 32 32"><path d="M0 17c0-3.866 3.134-7 7-7s7 3.134 7 7c0 3.866-3.134 7-7 7s-7-3.134-7-7zM18 17c0-3.866 3.134-7 7-7s7 3.134 7 7c0 3.866-3.134 7-7 7s-7-3.134-7-7z"></path></svg>';
                                            }

                                            $social_html[] = sprintf(
                                                '<li><a class="social-%s" href="%s" target="_blank"><span class="farmart-svg-icon">%s</span></a></li>',
                                                esc_attr( $key ),
                                                esc_url( $social_info[ $key ] ),
                                                $icon_html
                                            );
                                            ?>

                                        <?php } ?>
                                    <?php } ?>
                                    <ul class="store-social">
                                        <?php echo implode( ' ', $social_html ); ?>
                                    </ul>
                                </div>
                            <?php } ?>
                        </div>
                    </div> <!-- .profile-info -->
                </div>
            </div>
        </div>
    </div>
</div>
