<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$author = $displayData['item']->author;
$author = ($displayData['item']->created_by_alias ? $displayData['item']->created_by_alias : $author);
?>
			<dd class="createdby" title="<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author) ?>">
				<i class="fa fa-user"></i>
				<?php if (!empty($displayData['item']->contactid ) && $displayData['params']->get('link_author') == true) : ?>
					<?php
					echo JHtml::_('link', JRoute::_('index.php?option=com_contact&view=contact&id='.$displayData['item']->contactid), $author) ?>
				<?php else :?>
					<?php echo $author ?>
				<?php endif; ?>
			</dd>