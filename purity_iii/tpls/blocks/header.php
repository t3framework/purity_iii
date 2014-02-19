<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// get params
$sitename  = $this->params->get('sitename');
$slogan    = $this->params->get('slogan', '');
$logotype  = $this->params->get('logotype', 'text');
$logoimage = $logotype == 'image' ? $this->params->get('logoimage', 'templates/' . T3_TEMPLATE . '/images/logo.png') : '';

if (!$sitename) {
	$sitename = JFactory::getConfig()->get('sitename');
}

?>

<!-- MAIN NAVIGATION -->
<header id="t3-mainnav" class="wrap navbar navbar-default navbar-fixed-top t3-mainnav">

	<!-- OFF-CANVAS -->
	<?php if ($this->getParam('addon_offcanvas_enable')) : ?>
		<?php $this->loadBlock ('off-canvas') ?>
	<?php endif ?>
	<!-- //OFF-CANVAS -->

	<div class="container">

		<!-- NAVBAR HEADER -->
		<div class="navbar-header">

			<!-- LOGO -->
			<div class="logo logo-<?php echo $logotype ?>">
				<a href="<?php echo JURI::base(true) ?>" title="<?php echo strip_tags($sitename) ?>">
					<?php if($logotype == 'image'): ?>
						<img class="logo-img" src="<?php echo JURI::base(true) . '/' . $logoimage ?>" alt="<?php echo strip_tags($sitename) ?>" />
					<?php endif ?>
					<span><?php echo $sitename ?></span>
				</a>
			</div>
			<!-- //LOGO -->

			<?php if ($this->getParam('navigation_collapse_enable', 1) && $this->getParam('responsive', 1)) : ?>
				<?php $this->addScript(T3_URL.'/js/nav-collapse.js'); ?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".t3-navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
			<?php endif ?>

	    <?php if ($this->countModules('head-search')) : ?>
	    <!-- HEAD SEARCH -->
	    <div class="head-search<?php $this->_c('head-search')?>">     
	      <jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="raw" />
	    </div>
	    <!-- //HEAD SEARCH -->
	    <?php endif ?>

		</div>
		<!-- //NAVBAR HEADER -->

		<!-- NAVBAR MAIN -->
		<?php if ($this->getParam('navigation_collapse_enable')) : ?>
		<nav class="t3-navbar-collapse navbar-collapse collapse"></nav>
		<?php endif ?>

		<nav class="t3-navbar navbar-collapse collapse">
			<jdoc:include type="<?php echo $this->getParam('navigation_type', 'megamenu') ?>" name="<?php echo $this->getParam('mm_type', 'mainmenu') ?>" />
		</nav>
    <!-- //NAVBAR MAIN -->

	</div>
</header>
<!-- //MAIN NAVIGATION -->

<?php $this->loadBlock ('masthead') ?>