<?php
namespace app\models\query\base;

use yii\data\ActiveDataProvider;
use yii\data\Sort;

/**
 * This is the ActiveQuery class for \app\models\Article
 * @see \app\models\Article
 */
class ArticleQuery extends \yii\db\ActiveQuery
{
	/**
	 * @inheritdoc
	 * @return \app\models\Article[]
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}


	/**
	 * @inheritdoc
	 * @return \app\models\Article
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}


	/**
	 * @var mixed $filter
	 * @var array $options Options for ActiveDataProvider
	 * @return ActiveDataProvider
	 */
	public function search($filter = null, $options = [])
	{
		$this->filter($filter);
		$sort = new Sort();
		    return new ActiveDataProvider(
		    array_merge([
		        'query' => $this,
		        'sort'  => $sort
		    ], $options)
		);
	}


	/**
	 * @var mixed $model
	 * @return $this
	 */
	public function filter($model = null)
	{
		if ($model){
		//
		}
		return $this;
	}
}
