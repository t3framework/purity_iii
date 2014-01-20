<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<?php if ($this->checkSpotlight('spotlight-3', 'position-9, position-10, position-11, position-12')) : ?>
	<!-- SPOTLIGHT 2 -->
	<div class="wrap t3-sl t3-sl-3">
    <div class="container">
		  <?php $this->spotlight('spotlight-3', 'position-9, position-10, position-11, position-12') ?>
    </div>
	</div>
	<!-- //SPOTLIGHT 2 -->
<?php endif ?>