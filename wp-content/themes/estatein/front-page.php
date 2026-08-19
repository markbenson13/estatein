<?php

/**
 * The homepage template.
 */

get_header();

$hero_image_override = get_theme_mod('estatein_hero_image');
$hero_image           = $hero_image_override ? $hero_image_override : ESTATEIN_URI . '/assets/images/hero-img.png';

$feature_items = array(
	array(
		'icon'  => 'dreamhome-icon.png',
		'label' => __('Find Your Dream Home', 'estatein'),
		'link'  => get_post_type_archive_link('property'),
	),
	array(
		'icon'  => 'property-value-icon.png',
		'label' => __('Unlock Property Value', 'estatein'),
		'link'  => home_url('/services/'),
	),
	array(
		'icon'  => 'property-mngmt-icon.png',
		'label' => __('Effortless Property Management', 'estatein'),
		'link'  => home_url('/services/'),
	),
	array(
		'icon'  => 'investment-icon.png',
		'label' => __('Smart Investments, Informed Decisions', 'estatein'),
		'link'  => home_url('/services/'),
	),
);
?>

<section class="hero" id="hero">
	<div class="hero-media">
		<div class="hero-badge" aria-hidden="true">
			<svg viewBox="0 0 180 180" width="180" height="180">
				<circle cx="90" cy="90" r="87.5" fill="var(--color-surface)" stroke="rgba(255,255,255,0.15)" />
				<g class="hero-badge-spin">
					<defs>
						<path id="heroBadgePath" d="M 90,90 m -60,0 a 60,60 0 1,1 120,0 a 60,60 0 1,1 -120,0" />
					</defs>
					<text font-size="15.1" letter-spacing="3" fill="#ffffff" text-anchor="middle">
						<textPath href="#heroBadgePath" startOffset="50%">&#10024; Discover Your Dream Property</textPath>
					</text>
				</g>
				<g transform="translate(90,90)">
					<circle r="40" fill="#191919" stroke="rgba(255,255,255,0.18)" />
					<path d="M-12,12 L12,-12 M-4,-12 H12 V4" stroke="#ffffff" stroke-width="3.2" fill="none" stroke-linecap="round" stroke-linejoin="round" />
				</g>
			</svg>
		</div>
		<img src="<?php echo esc_url($hero_image); ?>" alt="<?php esc_attr_e('Featured building', 'estatein'); ?>" class="hero-image" loading="eager" fetchpriority="high" />
	</div>
	<div class="container py-5">
		<div class="row align-items-center gy-5">
			<div class="hero-text-col">
				<h1><?php echo esc_html(get_theme_mod('estatein_hero_title', 'Discover Your Dream Property with Estatein')); ?></h1>
				<p class="lead text-body-secondary"><?php echo esc_html(get_theme_mod('estatein_hero_subtitle', 'Your journey to finding the perfect property begins here. Explore our listings to find the home that matches your dreams.')); ?></p>

				<div class="d-flex gap-3 hero-cta">
					<a href="<?php echo esc_url(home_url('/about/')); ?>" class="btn btn-outline-light"><?php esc_html_e('Learn More', 'estatein'); ?></a>
					<a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="btn btn-primary"><?php esc_html_e('Browse Properties', 'estatein'); ?></a>
				</div>

				<div class="d-flex flex-wrap hero-stats">
					<div class="hero-stat-box">
						<strong class="d-block mb-0"><?php echo esc_html(get_theme_mod('estatein_stat1_number', '200+')); ?></strong>
						<span class="text-body-secondary"><?php echo esc_html(get_theme_mod('estatein_stat1_label', 'Happy Customers')); ?></span>
					</div>
					<div class="hero-stat-box">
						<strong class="d-block mb-0"><?php echo esc_html(get_theme_mod('estatein_stat2_number', '10k+')); ?></strong>
						<span class="text-body-secondary"><?php echo esc_html(get_theme_mod('estatein_stat2_label', 'Properties For Clients')); ?></span>
					</div>
					<div class="hero-stat-box">
						<strong class="d-block mb-0"><?php echo esc_html(get_theme_mod('estatein_stat3_number', '16+')); ?></strong>
						<span class="text-body-secondary"><?php echo esc_html(get_theme_mod('estatein_stat3_label', 'Years of Experience')); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="feature-strip" id="features">
	<div class="feature-strip-container">
		<div class="row row-cols-2 row-cols-lg-4 g-3">
			<?php foreach ($feature_items as $item) : ?>
				<div class="col">
					<a href="<?php echo esc_url($item['link']); ?>" class="feature-item d-flex flex-column align-items-center text-center gap-4 h-100 text-decoration-none position-relative">
						<span class="feature-arrow" aria-hidden="true">
							<img src="<?php echo esc_url(ESTATEIN_URI . '/assets/images/link-icon.png'); ?>" alt="" loading="lazy" />
						</span>
						<span class="feature-icon">
							<img src="<?php echo esc_url(ESTATEIN_URI . '/assets/images/' . $item['icon']); ?>" alt="" loading="lazy" />
						</span>
						<span class="feature-label fw-semibold text-body"><?php echo esc_html($item['label']); ?></span>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
$featured_query = new WP_Query(
	array(
		'post_type'      => 'property',
		'posts_per_page' => 6,
		'meta_key'       => '_property_featured',
		'meta_value'     => '1',
	)
);

if ($featured_query->have_posts()) :
?>
	<section class="section" id="properties">
		<div class="container">
			<div class="d-flex justify-content-between align-items-end gap-3 mb-5">
				<div style="max-width:1135px;">
					<img src="<?php echo esc_url(ESTATEIN_URI . '/assets/images/faq-abstract.png'); ?>" alt="" class="mb-3" loading="lazy" />
					<h2 class="mb-2"><?php esc_html_e('Featured Properties', 'estatein'); ?></h2>
					<p class="text-body-secondary section-description mb-0"><?php esc_html_e('Explore our handpicked selection of featured properties. Each listing offers a glimpse into exceptional homes and investments available through Estatein.  Click "View Details" for more information.', 'estatein'); ?></p>
				</div>
				<a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="btn btn-outline-light flex-shrink-0 d-none d-lg-inline-block"><?php esc_html_e('View All Properties', 'estatein'); ?></a>
			</div>
			<div class="es-slider" data-es-slider>
				<div class="es-slider-track" data-es-slider-track>
					<?php
					while ($featured_query->have_posts()) :
						$featured_query->the_post();
					?>
						<div class="es-slider-slide es-slider-slide--3up"><?php get_template_part('template-parts/property-card'); ?></div>
					<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
				<?php
				estatein_slider_nav(
					$featured_query->post_count,
					array(
						'url'   => get_post_type_archive_link( 'property' ),
						'label' => __( 'View All Properties', 'estatein' ),
						'class' => 'd-lg-none',
					)
				);
				?>
			</div>
		</div>
	</section>
<?php
endif;
?>

<?php
$testimonials_query = new WP_Query(
	array(
		'post_type'      => 'testimonial',
		'posts_per_page' => 6,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
	)
);
?>
<?php if ( $testimonials_query->have_posts() ) : ?>
<section class="section" id="testimonials">
	<div class="container">
		<div class="d-flex justify-content-between align-items-end gap-3 testimonials-header">
			<div style="max-width:1135px;">
				<img src="<?php echo esc_url(ESTATEIN_URI . '/assets/images/faq-abstract.png'); ?>" alt="" class="mb-3" loading="lazy" />
				<h2 class="mb-2"><?php esc_html_e('What Our Clients Say', 'estatein'); ?></h2>
				<p class="text-body-secondary section-description mb-0"><?php esc_html_e('Read the success stories and heartfelt testimonials from our valued clients. Discover why they chose Estatein for their real estate needs.', 'estatein'); ?></p>
			</div>
			<a href="<?php echo esc_url(get_post_type_archive_link('testimonial')); ?>" class="btn btn-outline-light flex-shrink-0 d-none d-lg-inline-block"><?php esc_html_e('View All Testimonials', 'estatein'); ?></a>
		</div>
		<div class="es-slider testimonials-slider" data-es-slider>
			<div class="es-slider-track" data-es-slider-track>
				<?php
				while ( $testimonials_query->have_posts() ) :
					$testimonials_query->the_post();
					$testimonial_name     = get_post_meta( get_the_ID(), '_testimonial_name', true );
					$testimonial_location = get_post_meta( get_the_ID(), '_testimonial_location', true );
					?>
					<div class="es-slider-slide es-slider-slide--3up-direct">
						<div class="card testimonial-card h-100">
							<div class="testimonial-stars d-flex gap-2">
								<?php for ($i = 0; $i < 5; $i++) : ?>
									<img class="testimonial-star" src="<?php echo esc_url(ESTATEIN_URI . '/assets/images/star-icon.png'); ?>" alt="" loading="lazy" />
								<?php endfor; ?>
							</div>
							<h3 class="testimonial-title"><?php the_title(); ?></h3>
							<p class="testimonial-quote"><?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?></p>
							<div class="testimonial-author d-flex align-items-center gap-3">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'testimonial-avatar-img' ) ); ?>
								<?php else : ?>
									<span class="testimonial-avatar" aria-hidden="true"><?php echo esc_html( estatein_initials_from_name( $testimonial_name ) ); ?></span>
								<?php endif; ?>
								<div>
									<div class="testimonial-name"><?php echo esc_html( $testimonial_name ); ?></div>
									<div class="testimonial-location"><?php echo esc_html( $testimonial_location ); ?></div>
								</div>
							</div>
						</div>
					</div>
				<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			<?php
			estatein_slider_nav(
				$testimonials_query->post_count,
				array(
					'url'   => get_post_type_archive_link( 'testimonial' ),
					'label' => __( 'View All Testimonials', 'estatein' ),
					'class' => 'd-lg-none',
				)
			);
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
$faq_query = new WP_Query(
	array(
		'post_type'      => 'faq',
		'posts_per_page' => 6,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
	)
);
?>
<?php if ( $faq_query->have_posts() ) : ?>
<section class="section" id="faq">
	<div class="container">
		<div class="d-flex justify-content-between align-items-end gap-3 faq-header">
			<div style="max-width:1135px;">
				<img src="<?php echo esc_url(ESTATEIN_URI . '/assets/images/faq-abstract.png'); ?>" alt="" class="mb-3" loading="lazy" />
				<h2 class="mb-2"><?php esc_html_e('Frequently Asked Questions', 'estatein'); ?></h2>
				<p class="text-body-secondary section-description mb-0"><?php esc_html_e("Find answers to common questions about Estatein's services, property listings, and the real estate process. We're here to provide clarity and assist you every step of the way.", 'estatein'); ?></p>
			</div>
			<a href="<?php echo esc_url(get_post_type_archive_link('faq')); ?>" class="btn btn-outline-light flex-shrink-0 d-none d-lg-inline-block"><?php esc_html_e("View All FAQ's", 'estatein'); ?></a>
		</div>
		<div class="es-slider faq-slider" data-es-slider>
			<div class="es-slider-track" data-es-slider-track>
				<?php
				while ( $faq_query->have_posts() ) :
					$faq_query->the_post();
					?>
					<div class="es-slider-slide es-slider-slide--3up-direct">
						<div class="faq-card d-flex flex-column h-100">
							<h3 class="faq-question"><?php the_title(); ?></h3>
							<p class="faq-answer flex-grow-1"><?php echo esc_html( wp_trim_words( get_the_content(), 20 ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="btn btn-outline-light"><?php esc_html_e('Read More', 'estatein'); ?></a>
						</div>
					</div>
				<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			<?php
			estatein_slider_nav(
				$faq_query->post_count,
				array(
					'url'   => get_post_type_archive_link( 'faq' ),
					'label' => __( "View All FAQ's", 'estatein' ),
					'class' => 'd-lg-none',
				)
			);
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
get_footer();
