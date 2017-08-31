<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ServiceCategories]].
 *
 * @see ServiceCategories
 */
class ServiceCategoriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ServiceCategories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ServiceCategories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
