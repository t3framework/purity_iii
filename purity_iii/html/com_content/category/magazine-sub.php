<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');

$params     = $this->params;

//show info block?
$useDefList =
	($params->get('show_modify_date') ||
		$params->get('show_publish_date') ||
		$params->get('show_create_date') ||
		$params->get('show_hits') ||
		$params->get('show_category') ||
		$params->get('show_parent_category') ||
		$params->get('show_author'));
$info_positions = $params->get('subcat_info_positions', array());

// intro
$cols      = $params->get('num_columns', 3);
$col_width = round(12 / $cols);
$i         = 0;
?>

<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<div class="page-header">
		<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	</div>
<?php endif; ?>

<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
	<div class="page-subheader">
		<h2> <?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title')) : ?>
				<span class="subheading-category"><?php echo $this->category->title;?></span>
			<?php endif; ?>
		</h2>
	</div>
<?php endif; ?>

<div class="magazine-category">
	<?php if (count($this->lead_items)): ?>
		<div class="magazine-leading">
			<?php foreach ($this->lead_items as $item) : ?>
				<div class="magazine-item">

					<?php echo JLayoutHelper::render('joomla.content.intro_image', $item); ?>

					<?php echo JLayoutHelper::render('joomla.content.blog_style_default_item_title', $item); ?>

					<?php // Todo Not that elegant would be nice to group the params ?>

					<?php if ($useDefList && in_array('leading', $info_positions)) : ?>
						<aside class="article-aside clearfix">
							<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $item, 'params' => $params, 'position' => 'above')); ?>
						</aside>
					<?php endif; ?>

					<?php //as we always show intro text for leading ?>
					<?php /* if (!$params->get('show_intro')) : ?>
						<?php echo $item->event->afterDisplayTitle; ?>
					<?php endif; */ ?>

					<?php echo $item->event->beforeDisplayContent; ?>
					<div class="magazine-item-ct">
						<?php echo $item->introtext; ?>
					</div>

					<?php if ($useDefList && in_array('leading', $info_positions)) : ?>
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
			<?php endforeach; ?>
		</div>
	<?php endif ?>

	<?php if (count($this->intro_items)): ?>
	<div class="magazine-intro">
		<?php foreach ($this->intro_items as $item) : ?>

			<?php if ($i == 0): /* start new row */ ?>
				<div class="row row-articles">
			<?php endif ?>

					<div class="col-sm-<?php echo $col_width ?> magazine-item">
						<?php echo JLayoutHelper::render('joomla.content.intro_image', $item); ?>
						<?php echo JLayoutHelper::render('joomla.content.blog_style_default_item_title', $item); ?>

						<?php if ($useDefList && in_array('intro', $info_positions) && in_array($params->get('info_block_position', 0), array(0, 2))) : ?>
							<aside class="article-aside clearfix">
								<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $item, 'params' => $params, 'position' => 'above')); ?>
							</aside>
						<?php endif; ?>

						<?php if (!$params->get('show_subcat_intro', 1)) : ?>
							<?php echo $item->event->afterDisplayTitle; ?>
						<?php endif; ?>
						<?php echo $item->event->beforeDisplayContent; ?>

						<?php if($params->get('show_subcat_intro', 1)) : ?>
						<div class="magazine-item-ct">
							<?php echo $item->introtext; ?>
						</div>
						<?php endif; ?>

						<?php if ($useDefList && in_array('intro', $info_positions) && in_array($params->get('info_block_position', 0), array(1, 2))) : ?>
							<aside class="article-aside clearfix">
								<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $item, 'params' => $params, 'position' => 'below')); ?>
							</aside>
						<?php endif; ?>

						<?php echo $item->event->afterDisplayContent; ?>

					</div>

			<?php if ($i == $cols - 1): /* close row */ ?>
				</div>
			<?php endif ?>
			<?php if (++$i >= $cols) $i = 0; ?>
		<?php endforeach; ?>

	<?php if ($i > 0): /* close row */ ?>
		</div>
	<?php endif ?>

	</div>
	<?php endif ?>

	<?php if (count($this->link_items)): ?>
	<div class="magazine-links">
		<?php foreach ($this->link_items as $item) : ?>
			<div class="magazine-item link-item">
				<?php echo JLayoutHelper::render('joomla.content.blog_style_default_item_title', $item); ?>
				<?php if ($useDefList && in_array('link', $info_positions)) : ?>
					<aside class="article-aside clearfix">
						<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $item, 'params' => $params, 'position' => 'above')); ?>
					</aside>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
	<?php endif ?>

	<?php if (($params->def('show_pagination', 1) == 1  || ($params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
	<div class="pagination">
		<?php  if ($params->def('show_pagination_results', 1)) : ?>
			<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
		<?php endif; ?>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php  endif; ?>

</div>