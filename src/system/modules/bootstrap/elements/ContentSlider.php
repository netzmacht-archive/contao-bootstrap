<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 26.08.13
 * Time: 17:05
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap;


/**
 * Class ContentSlider
 * @package Netzmacht\Bootstrap
 */
class ContentSlider extends BootstrapContentElement
{

	/**
	 * @var array
	 */
	protected $arrBootstrapAttributes = array();


	/**
	 * compile content slider
	 */
	protected function compile()
	{
		parent::compile();

		$articles = deserialize($this->sliderArticles, true);

		foreach ($articles as $i => $article)
		{
			$articles[$i]['id']      = $article['article'];
			$articles[$i]['article'] = $this->getArticle($article['article'], false, !((bool)$this->articleMarkup));
		}

		$this->Template->articles      = $articles;
		$this->Template->articlesCount = count($articles);

		if ($this->cssID == '')
		{
			$this->Template->cssID = 'carousel-' . $this->id;
		}
	}

}