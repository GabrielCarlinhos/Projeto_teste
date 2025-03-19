<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produtos".
 *
 * @property int $id
 * @property string $nome
 * @property int $quantidade
 * @property int $categoria
 *
 * @property Categoria $categoria0
 */
class Produto extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produtos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'quantidade', 'categoria'], 'required'],
            [['quantidade', 'categoria'], 'default', 'value' => null],
            [['quantidade', 'categoria'], 'integer'],
            [['nome'], 'string', 'max' => 100],
            [['categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'quantidade' => 'Quantidade',
            'categoria' => 'Categoria',
        ];
    }

    /**
     * Gets query for [[Categoria0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria0()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria']);
    }

}
