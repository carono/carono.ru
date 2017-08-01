<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "user".
 *
 * @property integer $id
 * @property string $login
 * @property string $hash
 * @property string $created_at
 * @property string $updated_at
 */
class User extends \yii\db\ActiveRecord
{

protected $_relationClasses = [];


    /**
    * @inheritdoc
    * @return \app\models\User    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\User not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'hash'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'login' => Yii::t('models', 'Login'),
            'hash' => Yii::t('models', 'Hash'),
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
     * @return \app\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UserQuery(get_called_class());
    }


}
