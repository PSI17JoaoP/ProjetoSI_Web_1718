<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Categoria;
use common\models\CategoriaEletronica;
use common\models\CategoriaComputadores;

/**
 * Anuncio form
 */
class ComputadoresForm extends Model
{
    
    public $nome;
    public $marca;
    public $descricao;
    public $processador;
    public $ram;
    public $hdd;
    public $gpu;
    public $os;
    public $portatil; //true or false


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome','marca', 'processador', 'ram', 'hdd', 'gpu', 'os'], 'required'],
            
            ['portatil', 'integer'],            
            [['nome', 'marca', 'os'], 'string', 'max' => 25],
            [['descricao'], 'string', 'max' => 30],
            [['processador', 'gpu'], 'string', 'max' => 50],
            [['ram'], 'string', 'max' => 5],
            [['hdd'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nome' => 'Nome',
            'marca' => 'Marca',
            'descricao' => 'Descrição',
            'processador' => 'Processador',
            'ram' => 'Memória RAM',
            'hdd' => 'Disco Rígido',
            'gpu' => 'Placa Gráfica',
            'os' => 'Sistema Operativo',
            'portatil' => 'Portátil ?',
        ];
    }

    public function guardar()
    {
        if ($this->validate()) {
            $categoriaBase = new Categoria();
            $categoriaBase->nome = $this->nome;
            $categoriaBase->save();
    
            $categoriaElec = new CategoriaEletronica();
            $categoriaElec->id_categoria = $categoriaBase->id;
            $categoriaElec->marca = $this->marca;
            $categoriaElec->descricao = $this->descricao;
            $categoriaElec->save();

            $categoria = new CategoriaComputadores();
            $categoria->id_eletronica = $categoriaElec->id_categoria;
            $categoria->processador = $this->processador;
            $categoria->ram = $this->ram;
            $categoria->hdd = $this->hdd;
            $categoria->gpu = $this->gpu;
            $categoria->os = $this->os;
            $categoria->portatil = $this->portatil;
            $categoria->save();


            return $categoria->id_eletronica;
        }

        return null;
    }

}
