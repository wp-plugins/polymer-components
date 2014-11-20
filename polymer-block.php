<?php
while( have_posts() )
{
	the_post();
	//the_content();
	echo $post->post_content;
}
