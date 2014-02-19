<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$params     = $this->params;
$useDefList =
	($params->get('show_modify_date') ||
		$params->get('show_publish_date') ||
		$params->get('show_create_date') ||
		$params->get('show_hits') ||
		$params->get('show_category') ||
		$params->get('show_parent_category') ||
		$params->get('show_author'));
$cols       = $params->get('highlight_columns', 2);
$positions  = $params->get('featured_info_positions', array());
$col_width  = round(12 / $cols);

$dispatcher = JEventDispatcher::getInstance();
JPluginHelper::importPlugin('content');
?>

<?php foreach ($this->categories as $cat) : ?>

	<?php
	$items = $this->list[$cat->id];
	$i     = 0;
	foreach ($items as $item)
	{
		$item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;

		$item->parent_slug = ($item->parent_alias) ? ($item->parent_id . ':' . $item->parent_alias) : $item->parent_id;

		// No link for ROOT category
		if ($item->parent_alias == 'root')
		{
			$item->parent_slug = null;
		}

		$item->catslug = $item->category_alias ? ($item->catid.':'.$item->category_alias) : $item->catid;
		$item->event   = new stdClass;

		// Old plugins: Ensure that text property is available
		if (!isset($item->text))
		{
			$item->text = $item->introtext;
		}

		$dispatcher->trigger('onContentPrepare', array ('com_content.category', &$item, &$this->params, 0));

		// Old plugins: Use processed text as introtext
		$item->introtext = $item->text;

		$results = $dispatcher->trigger('onContentAfterTitle', array('com_content.category', &$item, &$item->params, 0));
		$item->event->afterDisplayTitle = trim(implode("\n", $results));

		$results = $dispatcher->trigger('onContentBeforeDisplay', array('com_content.category', &$item, &$item->params, 0));
		$item->event->beforeDisplayContent = trim(implode("\n", $results));

		$results = $dispatcher->trigger('onContentAfterDisplay', array('com_content.category', &$item, &$item->params, 0));
		$item->event->afterDisplayContent = trim(implode("\n", $results));
	}
	?>

<div class="magazine-category">

	<div class="magazine-category-title">
		<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($cat->id));?>" title="<?php echo $cat->title;?>">
			<strong><?php echo $cat->title;?></strong> <i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>

	<?php foreach ($items as $item) : ?>
		<?php	if ($i == 0): /* start new row */ ?>
			<div class="row row-articles">
		<?php endif ?>
		<div class="col-xs-12 col-sm-<?php echo $col_width ?> magazine-item">
			<div class="row">

				<div class="col-md-4 magazine-item-media">
					<?php echo JLayoutHelper::render('joomla.content.intro_image', $item); ?>
				</div>

				<div class="col-md-8">
					<?php echo JLayoutHelper::render('joomla.content.blog_style_default_item_title', $item); ?>

					<?php if ($useDefList && in_array('highlight', $positions) && in_array($params->get('info_block_position', 0), array(0, 2))) : ?>
						<aside class="article-aside clearfix">
							<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $item, 'params' => $params, 'position' => 'above')); ?>
						</aside>
					<?php endif; ?>

					<?php if (!$params->get('show_highlight_intro', 1)) : ?>
						<?php echo $item->event->afterDisplayTitle; ?>
					<?php endif; ?>
					<?php echo $item->event->beforeDisplayContent; ?>

					<?php if ($params->get('show_highlight_intro', 1)) : ?>
					<div class="magazine-item-ct">
						<?php echo $item->introtext; ?>
					</div>
					<?php endif; ?>

					<?php if ($useDefList && in_array('highlight', $positions) && in_array($params->get('info_block_position', 0), array(1, 2))) : ?>
						<aside class="article-aside clearfix">
							<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $item, 'params' => $params, 'position' => 'below')); ?>
						</aside>
					<?php endif; ?>

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

			</div>
		</div>
		<?php	if ($i == $cols -1): /* close row */ ?>
			</div>
		<?php endif ?>
		<?php if (++$i >= $cols) $i = 0; ?>
	<?php endforeach; ?>

	<?php	if ($i > 0): /* close row */ ?>
		</div>
	<?php endif ?>

	</div>

<?php endforeach ?>