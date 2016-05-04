<?php

namespace app\module\admin\models;

/**
 * This is the ActiveQuery class for [[Colors]].
 *
 * @see Colors
 */
class ColorsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Colors[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Colors|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}