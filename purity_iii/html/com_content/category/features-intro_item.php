<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;?>
<?php
// Create a shortcut for params.
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$canEdit = $this->item->params->get('access-edit');
JHtml::_('behavior.framework');
$attribs = new JRegistry($this->item->attribs);
$images = json_decode($this->item->images);
$has_intro_image = (isset($images->image_intro) && !empty($images->image_intro));

?>

<div class="row-feature <?php echo $attribs->get('extra-class') ?> clearfix">

	<div class="container<?php echo $this->item->state == 0 ? ' system-unpublished' : null; ?>">

		<?php if ($this->item->state == 0) : ?>
			<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
		<?php endif; ?>

		<!-- Intro image -->
		<?php if ($has_intro_image) echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>

		<div class="<?php if ($has_intro_image): ?><?php endif ?>feature-ct pd-feature-ct">
			<?php if ($attribs->get('show_title', 1)) : ?>
				<?php echo JLayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>
			<?php endif ?>

			<?php echo $this->item->introtext; ?>
		</div>


	</div>
</div>