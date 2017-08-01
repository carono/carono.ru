<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class Article extends \yii\db\ActiveRecord
{

protected $_relationClasses = [];


    /**
    * @inheritdoc
    * @return \app\models\Article    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\Article not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'content'], 'string'],
            [['position'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'title' => Yii::t('models', 'Title'),
            'description' => Yii::t('models', 'Description'),
            'content' => Yii::t('models', 'Content'),
            'position' => Yii::t('models', 'Position'),
            'created_at' => Yii::t('models', 'Created At'),
            'updated_at' => Yii::t('models', 'Updated At'),
        ];
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ArticleQuery(get_called_class());
    }


}
