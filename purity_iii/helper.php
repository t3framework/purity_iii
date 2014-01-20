<?php
class JATemplateHelper
{
	public static function getArticles($params, $catid, $count, $front = 'show')
	{
		require_once JPATH_ROOT . '/modules/mod_articles_category/helper.php';
		$aparams = clone $params;
		$aparams->set('count', $count);
		$aparams->set('show_front', $front);
		$aparams->set('catid', (array)$catid);
		$aparams->set('show_child_category_articles', 1);
		$aparams->set('levels', 2);
		$alist = ModArticlesCategoryHelper::getList($aparams);
		return $alist;
	}

	public static function getCategories($parent = 'root', $count = 0)
	{
		require_once JPATH_ROOT . '/modules/mod_articles_categories/helper.php';
		$params = new JRegistry();
		$params->set('parent', $parent);
		$params->set('count', $count);
		return ModArticlesCategoriesHelper::getList($params);
	}

	public static function loadModule($name, $style = 'raw')
	{
		jimport('joomla.application.module.helper');
		$module = JModuleHelper::getModule($name);
		$params = array('style' => $style);
		echo JModuleHelper::renderModule($module, $params);
	}

	public static function loadModules($position, $style = 'raw')
	{
		jimport('joomla.application.module.helper');
		$modules = JModuleHelper::getModules($position);
		$params = array('style' => $style);
		foreach ($modules as $module) {
			echo JModuleHelper::renderModule($module, $params);
		}
	}

}

?>