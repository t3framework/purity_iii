<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<div class="glossary-group">
	<a name="<?php echo $this->group ?>"></a>
	<h3 class="glossary-group-title"><?php echo $this->group ?></h3>
	<div class="glossary-group-items">
		<ul class="row">
		<?php foreach ($this->group_items as $item):
			$title = $item->title;
			$link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid));
		?>
				<li class="col-xs-6 col-md-4"><a href="<?php echo $link ?>"><?php echo $title ?></a></li>
		<?php endforeach ?>
		</ul>
	</div>
</div>
