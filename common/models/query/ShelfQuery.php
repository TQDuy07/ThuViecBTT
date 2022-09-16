<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Cupboards]].
 *
 * @see \common\models\Cupboards
 */
class ShelfQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Cupboards[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Cupboards|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
