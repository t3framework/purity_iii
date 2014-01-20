<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once T3_TEMPLATE_PATH . '/helper.php';

// get featured items
$app      = JFactory::getApplication();
$params   = $this->params;
$parentid = $app->input->getInt('id');

$featured_count = $params->get('featured_leading', 1) + $params->get('featured_intro', 3) + $params->get('featured_links', 5);
$featured_items = JATemplateHelper::getArticles($params, $parentid, $featured_count, 'only');

// get child categories
$categories = JATemplateHelper::getCategories($parentid);

// get list articles for each sub cat
$list_items = array();
foreach ($categories as $cat) {
	$list_items[$cat->id] = JATemplateHelper::getArticles($params, $cat->id, $params->get('highlight_count', 4));
}
?>

<?php
$this->items = $featured_items;
echo $this->loadTemplate('featured'); ?>

<?php
$this->list = $list_items;
$this->categories = $categories;
echo $this->loadTemplate('list'); ?>
