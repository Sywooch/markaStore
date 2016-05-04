<?php

namespace app\module\admin\models;

use app\module\admin\models\Materials;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "materialproduct".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $material_id
 */
class Materialproduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'materialproduct';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'material_id', 'procent'], 'required'],
            [['product_id', 'material_id', 'procent'], 'integer'],
            [['procent'], 'number','max' => $this->getMaterialSum(isset($_GET['product_id']) ? $_GET['product_id'] : '0'),
                'tooBig' => 'Введите число не больше ' . $this->getMaterialSum(isset($_GET['product_id']) ? $_GET['product_id'] : '0')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'material_id' => 'Материал',
            'procent' => 'Процент',
        ];
    }

    public function getMaterials()
    {
        return$this->hasOne(Materials::className(),['id'=>'material_id']);
    }

    public function getMaterialSum($id = false)
    {
        //$model = Materialproduct::find()->select('procent')->where(['product_id' => $id])->all();

        /*foreach(Materialproduct::find()->select('procent')->where(['product_id' => $id])->all() as $proc){
            $procent[] = $proc->procent;
        }*/
        $proc = Materialproduct::find()->where(['product_id' => $id])->all();
        $finish_proc = array();
        foreach($proc as $allproc){
            $finish_proc[] = $allproc->procent;
        }

       // print_r($finish_proc);
        return 100-array_sum($finish_proc);

    }


}
