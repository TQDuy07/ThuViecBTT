<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * This is the model class for table "{{%book}}".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $author
 */
class Book extends \yii\db\ActiveRecord implements Linkable
{

    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
//        unset($fields['']);

        return $fields;
    }

    public function extraFields()
    {
        return ['author'];
    }
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['book/view', 'id' => $this->id], true),
            'edit' => Url::to(['book/view', 'id' => $this->id], true),
            'index' => Url::to(['/changeURLBook'], true),
        ];
    }



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%book}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'author'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'author' => 'Author',
        ];
    }

    /**
     * {@inheritdoc}
     * @return BookQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BookQuery(get_called_class());
    }
}
