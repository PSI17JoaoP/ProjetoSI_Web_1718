<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\AnuncioForm;
use common\models\Categoria;
use common\models\CategoriaEletronica;
use common\models\CategoriaSmartphones;

/**
 * Anuncio form
 */
class AnuncioSmartphonesForm extends Model
{
    
    public $nome;
    public $marca;
    public $descricao;
    public $processador;
    public $ram;
    public $hdd;
    public $os;
    public $tamanho; 


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome','marca', 'processador', 'ram', 'hdd', 'tamanho'], 'required'],
            
            [['nome', 'marca', 'os'], 'string', 'max' => 25],
            [['descricao'], 'string', 'max' => 30],
            [['processador'], 'string', 'max' => 50],
            [['ram'], 'string', 'max' => 5],
            [['hdd', 'tamanho'], 'string', 'max' => 10],
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
            'os' => 'Sistema Operativo',
            'tamanho' => 'Tamanho (Polegadas)',
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

            $categoria = new CategoriaSmartphones();
            $categoria->id_eletronica = $categoriaElec->id_categoria;
            $categoria->processador = $this->processador;
            $categoria->ram = $this->ram;
            $categoria->hdd = $this->hdd;
            $categoria->os = $this->os;
            $categoria->tamanho = $this->tamanho;
            $categoria->save();


            return $categoria->id_eletronica;
        }

        return null;
    }

}
