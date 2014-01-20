<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;
$title = $this->escape($displayData['item']->parent_title);
$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($displayData['item']->parent_slug)).'">'.$title.'</a>';
?>
			<dd class="parent-category-name" title="<?php echo JText::sprintf('COM_CONTENT_PARENT', $title); ?>">
				<?php if ($displayData['params']->get('link_parent_category') && !empty($displayData['item']->parent_slug)) : ?>
					<?php echo $url ?>
				<?php else : ?>
					<?php echo $title ?>
				<?php endif; ?>
			</dd>