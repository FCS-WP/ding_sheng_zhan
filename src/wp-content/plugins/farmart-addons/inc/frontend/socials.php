<?php
/**
 * Hooks for share socials
 *
 * @package Farmart
 */

if ( ! function_exists( 'farmart_addons_share_link_socials' ) ) :
	function farmart_addons_share_link_socials( $socials, $title, $link, $media, $text = false ) {
		$socials_html = '';
		if ( $socials ) {

			if ( in_array( 'facebook', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-facebook farmart-facebook" title="%s" href="http://www.facebook.com/sharer.php?u=%s&t=%s" target="_blank"><span class="farmart-svg-icon"><svg viewBox="0 0 16 28"><path d="M14.984 0.187v4.125h-2.453c-1.922 0-2.281 0.922-2.281 2.25v2.953h4.578l-0.609 4.625h-3.969v11.859h-4.781v-11.859h-3.984v-4.625h3.984v-3.406c0-3.953 2.422-6.109 5.953-6.109 1.687 0 3.141 0.125 3.563 0.187z"></path></svg></span><span class="text">%s</span></a></li>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title ),
					esc_html__('Facebook', 'farmart-addons')
				);
			}

			if ( in_array( 'twitter', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-twitter farmart-twitter" href="http://twitter.com/share?text=%s&url=%s" title="%s" target="_blank"><span class="farmart-svg-icon"><svg viewBox="0 0 26 28"><path d="M25.312 6.375c-0.688 1-1.547 1.891-2.531 2.609 0.016 0.219 0.016 0.438 0.016 0.656 0 6.672-5.078 14.359-14.359 14.359-2.859 0-5.516-0.828-7.75-2.266 0.406 0.047 0.797 0.063 1.219 0.063 2.359 0 4.531-0.797 6.266-2.156-2.219-0.047-4.078-1.5-4.719-3.5 0.313 0.047 0.625 0.078 0.953 0.078 0.453 0 0.906-0.063 1.328-0.172-2.312-0.469-4.047-2.5-4.047-4.953v-0.063c0.672 0.375 1.453 0.609 2.281 0.641-1.359-0.906-2.25-2.453-2.25-4.203 0-0.938 0.25-1.797 0.688-2.547 2.484 3.062 6.219 5.063 10.406 5.281-0.078-0.375-0.125-0.766-0.125-1.156 0-2.781 2.25-5.047 5.047-5.047 1.453 0 2.766 0.609 3.687 1.594 1.141-0.219 2.234-0.641 3.203-1.219-0.375 1.172-1.172 2.156-2.219 2.781 1.016-0.109 2-0.391 2.906-0.781z"></path></svg></span><span class="text">%s</span></a></li>',
					urlencode( $title ),
					urlencode( $link ),
					esc_attr( $title ),
					esc_html__('Twitter', 'farmart-addons')
				);
			}

			if ( in_array( 'pinterest', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-pinterest farmart-pinterest" href="http://pinterest.com/pin/create/button?media=%s&url=%s&description=%s" title="%s" target="_blank"><span class="farmart-svg-icon"><svg viewBox="0 0 20 28"><path d="M0 9.328c0-5.766 5.281-9.328 10.625-9.328 4.906 0 9.375 3.375 9.375 8.547 0 4.859-2.484 10.25-8.016 10.25-1.313 0-2.969-0.656-3.609-1.875-1.188 4.703-1.094 5.406-3.719 9l-0.219 0.078-0.141-0.156c-0.094-0.984-0.234-1.953-0.234-2.938 0-3.187 1.469-7.797 2.188-10.891-0.391-0.797-0.5-1.766-0.5-2.641 0-1.578 1.094-3.578 2.875-3.578 1.313 0 2.016 1 2.016 2.234 0 2.031-1.375 3.938-1.375 5.906 0 1.344 1.109 2.281 2.406 2.281 3.594 0 4.703-5.187 4.703-7.953 0-3.703-2.625-5.719-6.172-5.719-4.125 0-7.313 2.969-7.313 7.156 0 2.016 1.234 3.047 1.234 3.531 0 0.406-0.297 1.844-0.812 1.844-0.078 0-0.187-0.031-0.266-0.047-2.234-0.672-3.047-3.656-3.047-5.703z"></path></svg></span><span class="text">%s</span></a></li>',
					urlencode( $media ),
					urlencode( $link ),
					urlencode( $title ),
					esc_attr( $title ),
					esc_html__('Pinterest', 'farmart-addons')
				);
			}

			if ( in_array( 'google', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-google-plus farmart-google-plus" href="https://plus.google.com/share?url=%s&text=%s" title="%s" target="_blank"><span class="farmart-svg-icon"><svg viewBox="0 0 36 28"><path d="M22.453 14.266c0 6.547-4.391 11.188-11 11.188-6.328 0-11.453-5.125-11.453-11.453s5.125-11.453 11.453-11.453c3.094 0 5.672 1.125 7.672 3l-3.109 2.984c-0.844-0.812-2.328-1.766-4.562-1.766-3.906 0-7.094 3.234-7.094 7.234s3.187 7.234 7.094 7.234c4.531 0 6.234-3.266 6.5-4.937h-6.5v-3.938h10.813c0.109 0.578 0.187 1.156 0.187 1.906zM36 12.359v3.281h-3.266v3.266h-3.281v-3.266h-3.266v-3.281h3.266v-3.266h3.281v3.266h3.266z"></path></svg></span><span class="text">%s</span></a></li>',
					urlencode( $link ),
					urlencode( $title ),
					esc_attr( $title ),
					esc_html__('Google', 'farmart-addons')
				);
			}

			if ( in_array( 'linkedin', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-linkedin farmart-linkedin" href="http://www.linkedin.com/shareArticle?url=%s&title=%s" title="%s" target="_blank"><span class="farmart-svg-icon"><svg viewBox="0 0 24 28"><path d="M5.453 9.766v15.484h-5.156v-15.484h5.156zM5.781 4.984c0.016 1.484-1.109 2.672-2.906 2.672v0h-0.031c-1.734 0-2.844-1.188-2.844-2.672 0-1.516 1.156-2.672 2.906-2.672 1.766 0 2.859 1.156 2.875 2.672zM24 16.375v8.875h-5.141v-8.281c0-2.078-0.75-3.5-2.609-3.5-1.422 0-2.266 0.953-2.641 1.875-0.125 0.344-0.172 0.797-0.172 1.266v8.641h-5.141c0.063-14.031 0-15.484 0-15.484h5.141v2.25h-0.031c0.672-1.062 1.891-2.609 4.672-2.609 3.391 0 5.922 2.219 5.922 6.969z"></path></svg></span><span class="text">%s</span></a></li>',
					urlencode( $link ),
					urlencode( $title ),
					esc_attr( $title ),
					esc_html__('Linkedin', 'farmart-addons')
				);
			}

			if ( in_array( 'tumblr', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-tumblr farmart-tumblr" href="http://www.tumblr.com/share/link?url=%s" title="%s" target="_blank"><span class="farmart-svg-icon"><svg viewBox="0 0 17 28"><path d="M14.75 20.766l1.25 3.703c-0.469 0.703-2.594 1.5-4.5 1.531-5.672 0.094-7.812-4.031-7.812-6.937v-8.5h-2.625v-3.359c3.938-1.422 4.891-4.984 5.109-7.016 0.016-0.125 0.125-0.187 0.187-0.187h3.813v6.625h5.203v3.937h-5.219v8.094c0 1.094 0.406 2.609 2.5 2.562 0.688-0.016 1.609-0.219 2.094-0.453z"></path></svg></span><span class="text">%s</span></a></li>',
					urlencode( $link ),
					esc_attr( $title ),
					esc_html__('Tumblr', 'farmart-addons')
				);
			}

			if ( in_array( 'vkontakte', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-vkontakte farmart-vkontakte" href="http://vk.com/share.php?url=%s&title=%s&image=%s" title="%s" target="_blank"><span class="farmart-svg-icon"><svg viewBox="0 0 31 28"><path d="M29.953 8.125c0.234 0.641-0.5 2.141-2.344 4.594-3.031 4.031-3.359 3.656-0.859 5.984 2.406 2.234 2.906 3.313 2.984 3.453 0 0 1 1.75-1.109 1.766l-4 0.063c-0.859 0.172-2-0.609-2-0.609-1.5-1.031-2.906-3.703-4-3.359 0 0-1.125 0.359-1.094 2.766 0.016 0.516-0.234 0.797-0.234 0.797s-0.281 0.297-0.828 0.344h-1.797c-3.953 0.25-7.438-3.391-7.438-3.391s-3.813-3.938-7.156-11.797c-0.219-0.516 0.016-0.766 0.016-0.766s0.234-0.297 0.891-0.297l4.281-0.031c0.406 0.063 0.688 0.281 0.688 0.281s0.25 0.172 0.375 0.5c0.703 1.75 1.609 3.344 1.609 3.344 1.563 3.219 2.625 3.766 3.234 3.437 0 0 0.797-0.484 0.625-4.375-0.063-1.406-0.453-2.047-0.453-2.047-0.359-0.484-1.031-0.625-1.328-0.672-0.234-0.031 0.156-0.594 0.672-0.844 0.766-0.375 2.125-0.391 3.734-0.375 1.266 0.016 1.625 0.094 2.109 0.203 1.484 0.359 0.984 1.734 0.984 5.047 0 1.062-0.203 2.547 0.562 3.031 0.328 0.219 1.141 0.031 3.141-3.375 0 0 0.938-1.625 1.672-3.516 0.125-0.344 0.391-0.484 0.391-0.484s0.25-0.141 0.594-0.094l4.5-0.031c1.359-0.172 1.578 0.453 1.578 0.453z"></path></svg></span><span class="text">%s</span></a></li>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $media ),
					urlencode( $title ),
					esc_html__('Vkontakte', 'farmart-addons')
				);
			}

			if ( in_array( 'whatsapp', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-whatsapp farmart-whatsapp" href="https://api.whatsapp.com/send?text=%s" title="%s" target="_blank"><span class="farmart-svg-icon"><svg viewBox="0 0 24 28"><path d="M15.391 15.219c0.266 0 2.812 1.328 2.922 1.516 0.031 0.078 0.031 0.172 0.031 0.234 0 0.391-0.125 0.828-0.266 1.188-0.359 0.875-1.813 1.437-2.703 1.437-0.75 0-2.297-0.656-2.969-0.969-2.234-1.016-3.625-2.75-4.969-4.734-0.594-0.875-1.125-1.953-1.109-3.031v-0.125c0.031-1.031 0.406-1.766 1.156-2.469 0.234-0.219 0.484-0.344 0.812-0.344 0.187 0 0.375 0.047 0.578 0.047 0.422 0 0.5 0.125 0.656 0.531 0.109 0.266 0.906 2.391 0.906 2.547 0 0.594-1.078 1.266-1.078 1.625 0 0.078 0.031 0.156 0.078 0.234 0.344 0.734 1 1.578 1.594 2.141 0.719 0.688 1.484 1.141 2.359 1.578 0.109 0.063 0.219 0.109 0.344 0.109 0.469 0 1.25-1.516 1.656-1.516zM12.219 23.5c5.406 0 9.812-4.406 9.812-9.812s-4.406-9.812-9.812-9.812-9.812 4.406-9.812 9.812c0 2.063 0.656 4.078 1.875 5.75l-1.234 3.641 3.781-1.203c1.594 1.047 3.484 1.625 5.391 1.625zM12.219 1.906c6.5 0 11.781 5.281 11.781 11.781s-5.281 11.781-11.781 11.781c-1.984 0-3.953-0.5-5.703-1.469l-6.516 2.094 2.125-6.328c-1.109-1.828-1.687-3.938-1.687-6.078 0-6.5 5.281-11.781 11.781-11.781z"></path></svg></span><span class="text">%s</span></a></li>',
					urlencode( $link ),
					esc_attr( $title ),
					esc_html__('Whatsapp', 'farmart-addons')
				);
			}

			if ( in_array( 'email', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-email farmart-email" href="mailto:?subject=%s&body=%s" title="%s" target="_blank"><span class="farmart-svg-icon"><svg viewBox="0 0 28 28"><path d="M26 23.5v-12c-0.328 0.375-0.688 0.719-1.078 1.031-2.234 1.719-4.484 3.469-6.656 5.281-1.172 0.984-2.625 2.188-4.25 2.188h-0.031c-1.625 0-3.078-1.203-4.25-2.188-2.172-1.813-4.422-3.563-6.656-5.281-0.391-0.313-0.75-0.656-1.078-1.031v12c0 0.266 0.234 0.5 0.5 0.5h23c0.266 0 0.5-0.234 0.5-0.5zM26 7.078c0-0.391 0.094-1.078-0.5-1.078h-23c-0.266 0-0.5 0.234-0.5 0.5 0 1.781 0.891 3.328 2.297 4.438 2.094 1.641 4.188 3.297 6.266 4.953 0.828 0.672 2.328 2.109 3.422 2.109h0.031c1.094 0 2.594-1.437 3.422-2.109 2.078-1.656 4.172-3.313 6.266-4.953 1.016-0.797 2.297-2.531 2.297-3.859zM28 6.5v17c0 1.375-1.125 2.5-2.5 2.5h-23c-1.375 0-2.5-1.125-2.5-2.5v-17c0-1.375 1.125-2.5 2.5-2.5h23c1.375 0 2.5 1.125 2.5 2.5z"></path></svg></span><span class="text">%s</span></a></li>',
					esc_html( $title ),
					urlencode( $link ),
					esc_attr( $title ),
					esc_html__('Email', 'farmart-addons')
				);
			}
		}

		$class = $text == true ? 'farmart-social__text' : '';

		if ( $socials_html ) {
			return sprintf( '<ul class="farmart-social-share socials-inline %s">%s</ul>', $class, $socials_html );
		}
		?>
		<?php
	}

endif;
