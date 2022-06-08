<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string $t_status
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['t_status'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 3],
            [['code','id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '姓名',
            'code' => '编码',
            't_status' => '状态',
        ];
    }

    const ID_DROPDOWNLIST_MAP = [
        'g10' => '>10',
        'l10' => '<10',
        'gt10' => '>=10',
        'lt10' => '<=10'
    ];

}
