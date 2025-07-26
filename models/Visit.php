<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visit".
 *
 * @property int $id
 * @property int $link_id
 * @property string $ip
 * @property int $counter
 *
 * @property Link $link
 */
class Visit extends \yii\db\ActiveRecord
{

    public function fill(
        $linkId,
        $ip
    ){
        $this->link_id = $linkId;
        $this->ip = $ip;
        $this->counter++;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['counter'], 'default', 'value' => 0],
            [['link_id', 'ip'], 'required'],
            [['link_id', 'counter'], 'integer'],
            [['ip'], 'string'],
            [['link_id'], 'exist', 'skipOnError' => true, 'targetClass' => Link::class, 'targetAttribute' => ['link_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link_id' => 'Link ID',
            'ip' => 'Ip',
            'counter' => 'Counter',
        ];
    }

    /**
     * Gets query for [[Link]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLink()
    {
        return $this->hasOne(Link::class, ['id' => 'link_id']);
    }

}