<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// get featured items
$params        = $this->params;
$count_leading = $params->get ('featured_leading', 1);
$count_intro   = $params->get ('featured_intro', 3);
$intro_columns = $params->get ('featured_intro_columns', 3);
$leading       = $intro = $links = array();

$dispatcher    = JEventDispatcher::getInstance();
$i = 0;
foreach ($this->items as &$item) {

	$item->event = new stdClass;

	// Old plugins: Ensure that text property is available
	if (!isset($item->text))
	{
		$item->text = $item->introtext;
	}
	JPluginHelper::importPlugin('content');
	$dispatcher->trigger('onContentPrepare', array ('com_content.featured', &$item, &$this->params, 0));

	// Old plugins: Use processed text as introtext
	$item->introtext = $item->text;

	$results = $dispatcher->trigger('onContentAfterTitle', array('com_content.featured', &$item, &$item->params, 0));
	$item->event->afterDisplayTitle = trim(implode("\n", $results));

	$results = $dispatcher->trigger('onContentBeforeDisplay', array('com_content.featured', &$item, &$item->params, 0));
	$item->event->beforeDisplayContent = trim(implode("\n", $results));

	$results = $dispatcher->trigger('onContentAfterDisplay', array('com_content.featured', &$item, &$item->params, 0));
	$item->event->afterDisplayContent = trim(implode("\n", $results));

	if ($i < $count_leading) {
		$leading[] = $item;
	} elseif ($i < $count_leading + $count_intro) {
		$intro[] = $item;
	} else {
		$links[] = $item;
	}

	$i++;
}

//show info block?
$useDefList =
	($params->get('show_modify_date') ||
	$params->get('show_publish_date') ||
	$params->get('show_create_date') ||
	$params->get('show_hits') ||
	$params->get('show_category') ||
	$params->get('show_parent_category') ||
	$params->get('show_author'));

$info_positions = $params->get('featured_info_positions', array());
?>

<div class="magazine-featured">
	<div class="row">
		<div class="col-md-8">
			<?php if (count ($leading)): ?>
				<div class="magazine-leading magazine-featured-leading">
					<?php foreach ($leading as $item) :?>
						<div class="magazine-item">

							<?php echo JLayoutHelper::render('joomla.content.intro_image', $item); ?>

							<?php echo JLayoutHelper::render('joomla.content.blog_style_default_item_title', $item); ?>

							<?php // Todo Not that elegant would be nice to group the params ?>

							<?php if ($useDefList && in_array('leading', $info_positions) && in_array($params->get('info_block_position', 0), array(0, 2))) : ?>
							<aside class="article-aside clearfix">
								<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $item, 'params' => $params, 'position' => 'above')); ?>
							</aside>
							<?php endif; ?>

							<?php if (!$params->get('show_intro')) : ?>
								<?php echo $item->event->afterDisplayTitle; ?>
							<?php endif; ?>

							<?php echo $item->event->beforeDisplayContent; ?>
							<div class="magazine-item-ct">
								<?php echo $item->introtext; ?>
							</div>

							<?php if ($useDefList && in_array('leading', $info_positions) && in_array($params->get('info_block_position', 0), array(1, 2))) : ?>
								<aside class="article-aside clearfix">
									<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $item, 'params' => $params, 'position' => 'below')); ?>
								</aside>
							<?php  endif; ?>

							<?php if ($params->get('show_readmore') && $item->readmore) :
								if ($item->params->get('access-view')) :
									$link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid));
								else :
									$menu      = JFactory::getApplication()->getMenu();
									$active    = $menu->getActive();
									$itemId    = $active->id;
									$link1     = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
									$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid));
									$link      = new JUri($link1);
									$link->setVar('return', base64_encode($returnURL));
								endif; ?>

								<section class="readmore">
									<a class="btn btn-default" href="<?php echo $link; ?>"><span>

										<?php if (!$item->params->get('access-view')) :
											echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
										elseif ($readmore = $item->alternative_readmore) :
											echo $readmore;
											if ($params->get('show_readmore_title', 0) != 0) :
												echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));
											endif;
										elseif ($params->get('show_readmore_title', 0) == 0) :
											echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
										else :
											echo JText::_('COM_CONTENT_READ_MORE');
											echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));
										endif; ?>

									</span></a>
								</section>

							<?php endif; ?>

							<?php echo $item->event->afterDisplayContent; ?>

						</div>
					<?php endforeach; ?>
				</div>
			<?php endif ?>
		</div> <!-- //Left Column -->

		<div class="col-md-4">
			<?php if (count ($links)): ?>
				<div class="magazine-links magazine-featured-links">
					<?php foreach ($links as $item) :?>
						<div class="magazine-item link-item">
							<?php echo JLayoutHelper::render('joomla.content.blog_style_default_item_title', $item); ?>
							<?php if ($useDefList && in_array('link', $info_positions)) : ?>
								<aside class="article-aside clearfix">
									<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $item, 'params' => $params, 'position' => 'above')); ?>
								</aside>
							<?php  endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif ?>
		</div> <!-- //Right Column -->
	</div> <!-- //Row -->

	<div class="row">
		<?php if ($intro_count = count ($intro)): ?>
			<div class="col-sm-12 magazine-intro magazine-featured-intro">
				<?php $intro_index = 0; ?>
				<?php foreach ($intro as $item) : ?>
					<?php if($intro_index % $intro_columns == 0) : ?>
						<div class="row">
					<?php endif ?>
							<div class="magazine-item col-sm-<?php echo round((12 / $intro_columns)) ?>">
								<?php echo JLayoutHelper::render('joomla.content.intro_image', $item); ?>
								<?php echo JLayoutHelper::render('joomla.content.blog_style_default_item_title', $item); ?>

								<?php if ($useDefList && in_array('intro', $info_positions)) : ?>
									<aside class="article-aside clearfix">
										<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $item, 'params' => $params, 'position' => 'above')); ?>
									</aside>
								<?php  endif; ?>

								<?php echo $item->event->afterDisplayTitle; ?>
								<?php echo $item->event->beforeDisplayContent; ?>
								<?php echo $item->event->afterDisplayContent; ?>
							</div>
					<?php if(($intro_index % $intro_columns == 0 && $intro_index > 0) || $intro_index == $intro_count -1) : ?>
						</div>
					<?php endif ?>
					<?php $intro_index++; ?>
				<?php endforeach; ?>
			</div>
		<?php endif ?>
	</div>

</div>