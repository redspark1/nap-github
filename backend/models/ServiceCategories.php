<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%service_categories}}".
 *
 * @property integer $service_category_id
 * @property string $service_category_name
 * @property string $service_category_description
 *
 * @property Services[] $services
 */
class ServiceCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%service_categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_category_name'], 'required'],
            [['service_category_name', 'service_category_description'], 'string', 'max' => 255],
			[['service_category_name'], 'unique'], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_category_id' => Yii::t('app', 'Service Category ID'),
            'service_category_name' => Yii::t('app', 'Service Category Name'),
            'service_category_description' => Yii::t('app', 'Service Category Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Services::className(), ['service_category_id' => 'service_category_id']);
    }

    /**
     * @inheritdoc
     * @return ServiceCategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServiceCategoriesQuery(get_called_class());
    }
}
