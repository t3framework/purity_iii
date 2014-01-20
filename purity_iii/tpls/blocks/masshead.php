<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$input = JFactory::getApplication()->input;
$menu = JFactory::getApplication()->getMenu();
$activemenu = $menu->getActive() ? $menu->getActive() : $menu->getDefault();
$query = $activemenu->query;
$mass_title = $mass_slogan = '';
if ((!isset ($query['option']) || $query['option'] == $input->get ('option'))
		&& (!isset ($query['view']) || $query['view'] == $input->get ('view'))
		&& (!isset ($query['id']) || $query['id'] == $input->get ('id'))) {
	$mass_title = $activemenu->params->get ('masshead-title');
	$mass_slogan = $activemenu->params->get ('masshead-slogan');
}

$masshead_position = 'masshead';
?>

<?php if ($mass_title || $this->countModules($masshead_position)) : ?>
<div class="page-masthead">
	<?php if ($mass_title) : ?>
	<div class="jumbotron jumbotron-primary">
		<div class="container">
			<h1><?php echo $mass_title ?></h1>
			<p><?php echo $mass_slogan ?></p>
		</div>
	</div>
	<?php endif ?>

	<?php if ($this->countModules ($masshead_position)): ?>
		<jdoc:include type="modules" name="<?php echo $masshead_position ?>" style="FeatureRow" />
	<?php endif ?>
</div>
<?php endif ?>

