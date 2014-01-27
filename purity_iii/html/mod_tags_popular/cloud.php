<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_tags_popular
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$minsize	= $params->get('minsize', 1);
$maxsize	= $params->get('maxsize', 2);

JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
require_once (dirname(__FILE__).'/helper/route.php');
?>
<div class="tagspopular<?php echo $moduleclass_sfx; ?> tagscloud<?php echo $moduleclass_sfx; ?>">
<?php
if (!count($list)) : ?>
	<div class="alert alert-no-items"><?php echo JText::_('MOD_TAGS_POPULAR_NO_ITEMS_FOUND'); ?></div>
<?php else :
	// Find maximum and minimum count
	$mincount = null;
	$maxcount = null;
	foreach ($list as $item)
	{
		if ($mincount === null or $mincount > $item->count)
		{
			$mincount = $item->count;
		}
		if ($maxcount === null or $maxcount < $item->count)
		{
			$maxcount = $item->count;
		}
	}
	$countdiff = $maxcount - $mincount;

	foreach ($list as $item) :
		if ($countdiff == 0) :
			$fontsize = $minsize;
		else :
			$fontsize = $minsize + (($maxsize - $minsize) / ($countdiff)) * ($item->count - $mincount);
		endif;
?>
		<span class="tag">
			<a class="tag-name" style="font-size: <?php echo $fontsize.'em'; ?>" href="<?php echo JRoute::_(JATagsHelperRoute::getTagRoute($item->tag_id . '-' . $item->alias)); ?>">
				<?php echo htmlspecialchars($item->title); ?>
				<?php if ($display_count) : ?>
					(<?php echo $item->count; ?>)
				<?php endif; ?>
			</a>
		</span>
	<?php endforeach; ?>
<?php endif; ?>
</div>
