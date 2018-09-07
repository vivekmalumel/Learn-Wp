					<div class="blog_post col-lg-12 col-md-12">
						<div class="row">
							<div class="col-lg-2 col-md-3 col-sm-2 col-2 date_circle" style="padding: 10px;">
								<div class="blog_post_date">
									<?php
										$eventDate=new DateTime(get_field('event_date'));
									?>
									<span class="post_month"><?php echo $eventDate->format('M')?></span>
									<span class="post_day"><?php echo $eventDate->format('d') ?></span>
								</div>
							</div>
							<div class="blog_post_detail col-lg-10 col-md-9 col-sm-10 col-10">
								<div class="blog_post_title">
									<a href="<?php the_permalink()?>">
									<?php the_title()?>
									</a>
								</div>
								<div class="blog_post_desc">
									<?php echo wp_trim_words(get_the_content(),20)?>
									<a href="<?php the_permalink() ?>">Read More</a>
								</div>
							</div>
						</div>
						<hr>
					</div>