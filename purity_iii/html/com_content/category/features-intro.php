<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

JHtml::_('behavior.caption');

$items = $this->items;
?>
<div class="blog<?php echo $this->pageclass_sfx;?> features-intro">

	<?php if (!empty($items)) : ?>
		<?php foreach ($items as &$item) : ?>
			<?php
			$this->item = &$item;
			echo $this->loadTemplate('item');
			?>
		<?php endforeach; ?>
	<?php endif; ?>

</div>
