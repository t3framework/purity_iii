<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tags
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Tags Component Route Helper
 *
 * @static
 * @package     Joomla.Site
 * @subpackage  com_tags
 * @since       3.1
 */
class JATagsHelperRoute extends TagsHelperRoute
{
	public static function getTagRoute($id)
	{
		$needles = array(
			'tag'  => array((int) $id)
		);
		if ($id < 1)
		{
			$link = '';
		}
		else
		{
			if (!empty($needles) && $item = self::_findItem($needles))
			{
				$link = 'index.php?Itemid=' . $item;
			}
			else
			{
				// detect tags page
				$app = JFactory::getApplication();
				$menus		= $app->getMenu('site');
				$component	= JComponentHelper::getComponent('com_tags');
				$items		= $menus->getItems('component_id', $component->id);
				$itemid = '';
				if ($items) {
					foreach ($items as $item) {
						if (isset($item->query) && isset($item->query['view']) && $item->query['view'] == 'tags') {
							$itemid = '&Itemid='.$item->id;
							break;
						}
					}
				}
				// Create the link
				$link = 'index.php?option=com_tags&view=tag&id=' . $id . $itemid;
			}
		}

		return $link;
	}
}