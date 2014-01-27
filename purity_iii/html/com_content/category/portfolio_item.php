<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Define default image size (do not change)
$attribs = new JRegistry($this->item->attribs);
$params = $this->item->params;
$images = json_decode($this->item->images);
?>

<div class="thumbnail">

	<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>" title="">
		<?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>
    <div class="item-image">
		  <img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/>
			<?php if ($attribs->get('portfolio-state')) : ?>
			<span class="item-state state-<?php echo $attribs->get('portfolio-state') ?>">
				<?php echo $attribs->get('portfolio-state') ?>
			</span>
			<?php endif ?>
    </div>
		<?php endif; ?>
		<h3><?php echo $this->item->title ?></h3>
	</a>

	<?php if ($params->get('show_intro')) : ?>
		<?php echo $this->item->introtext ?>
	<?php endif ?>

	<?php if ($attribs->get('portfolio-demo')) : ?>
		<p class="item-demo-url">
			<a class="btn btn-default" href="<?php echo $attribs->get('portfolio-demo') ?>">Live Demo</a>
		</p>
	<?php endif ?>

</div>