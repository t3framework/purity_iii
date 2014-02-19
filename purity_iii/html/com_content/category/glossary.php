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
$catid = $app->input->getInt('id');

$items = JATemplateHelper::getArticles($params, $catid, 0);
$groups = array();
$other = 'others';
for ($group = 'a'; $group < 'z'; $group++) {
	$groups[$group] = array();
}
$groups[$other] = array();

foreach ($items as $item) {
	$title = clean_special_chars ($item->title);
	$firstChar = strtolower($title[0]);

	if ($firstChar < 'a' || $firstChar > 'z') {
		$groups[$other][] = $item;
	} else {
		$groups[$firstChar][] = $item;
	}
}

/* clean special char to put it into alphabet list */
function clean_special_chars ($s, $d=false) {
	if($d) $s = utf8_decode( $s );

	$chars = array(
		'_' => '/`|´|\^|~|¨|ª|º|©|®/',
		'a' => '/à|á|ả|ạ|ã|â|ầ|ấ|ẩ|ậ|ẫ|ă|ằ|ắ|ẳ|ặ|ẵ|ä|å|æ/',
		'd' => '/đ/',
		'e' => '/è|é|ẻ|ẹ|ẽ|ê|ề|ế|ể|ệ|ễ|ë/',
		'i' => '/ì|í|ỉ|ị|ĩ|î|ï/',
		'o' => '/ò|ó|ỏ|ọ|õ|ô|ồ|ố|ổ|ộ|ỗ|ö|ø/',
		'u' => '/ù|ú|û|ũ|ü|ů|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/',
		'A' => '/À|Á|Ả|Ạ|Ã|Â|Ầ|Ấ|Ẩ|Ậ|Ẫ|Ă|Ằ|Ắ|Ẳ|Ặ|Ẵ|Ä|Å|Æ/',
		'D' => '/Đ/',
		'E' => '/È|É|Ẻ|Ẹ|Ẽ|Ê|Ề|Ế|Ể|Ệ|Ễ|Ê|Ë/',
		'I' => '/Ì|Í|Ỉ|Ị|Ĩ|Î|Ï/',
		'O' => '/Ò|Ó|Ỏ|Ọ|Õ|Ô|Ồ|Ố|Ổ|Ộ|Ỗ|Ö|Ø/',
		'U' => '/Ù|Ú|Û|Ũ|Ü|Ů|Ủ|Ụ|Ư|Ứ|Ừ|Ữ|Ử|Ự/',
		'c' => '/ć|ĉ|ç/',
		'C' => '/Ć|Ĉ|Ç/',
		'n' => '/ñ/',
		'N' => '/Ñ/',
		'y' => '/ý|ỳ|ỷ|ỵ|ỹ|ŷ|ÿ/',
		'Y' => '/Ý|Ỳ|Ỷ|Ỵ|Ỹ|Ŷ|Ÿ/'
	);

	return preg_replace( $chars, array_keys( $chars ), $s );
}
?>


<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<div class="page-header clearfix">
		<h1 class="page-title"><?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
	</div>
<?php endif; ?>

<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
	<div class="page-subheader clearfix">
		<h2 class="page-subtitle"><?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title')) : ?>
				<?php echo $this->category->title;?>
			<?php endif; ?>
		</h2>
	</div>
<?php endif; ?>

<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
	<div class="category-desc clearfix">
		<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
			<img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
		<?php endif; ?>
		<?php if ($this->params->get('show_description') && $this->category->description) : ?>
			<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
		<?php endif; ?>
	</div>
<?php endif; ?>


<?php if ($params->get ('show_navigation', 1)) : ?>
	<div class="glossary-nav">
		<nav class="container">
			<ul class="nav nav-pills">
			<?php foreach ($groups as $group => $group_items): ?>
				<?php if (count ($group_items) || $params->get ('show_empty_group', 0)) : ?>
				<li><a href="#<?php echo $group ?>"><?php echo $group ?></a></li>
				<?php endif ?>
			<?php endforeach ?>
			</ul>
		</nav>
	</div>

	<script type="text/javascript">
		!function($) {
			$('.glossary-nav nav').affix({
				offset:{
					top: function(){
						return $('#t3-content').offset().top - $('#t3-mainnav').height();
					}
				}
			});
		} (jQuery);
	</script>
<?php endif ?>

<div class="glossary-items">
<?php foreach ($groups as $group=>$group_items) : ?>
	<?php if (count ($group_items) || $params->get ('show_empty_group', 0)) {
		$this->group = $group;
		$this->group_items = $group_items;
		echo $this->loadTemplate ('group');
	} ?>
<?php endforeach ?>
</div>

<?php if ($params->get('show_detail_in_popup', 1)): ?>
<!-- Modal -->
<div class="modal fade" id="glossary-detail" tabindex="-1" role="dialog" aria-labelledby="glossary-detail-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="glossary-detail-label">Modal title</h4>
			</div>
			<div class="modal-body">

			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	!function ($) {
		// click to open popup
		var $a = $('.glossary-group-items ul li a');
		$a.click (function() {
			var url = this.href,
				label = this.innerHTML;
			// ajax to request content
			url += (/\?/.test(url) ? '&' : '?') + 'tmpl=component';
			$.ajax (url).done(function(data){
				$('#glossary-detail .modal-body').html($(data).find ('section.article-content'));
				$('#glossary-detail-label').html(label );
				$('#glossary-detail').modal ('show');
				console.log ($('.modal-content').height());
			});

			return false;
		})
	} (jQuery);
</script>
<?php endif ?>