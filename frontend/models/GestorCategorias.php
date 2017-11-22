<?php

namespace frontend\models;

use common\models\Categoria;

class GestorCategorias
{
    /**
     * Adquire as categorias de um conjunto de um respetivo dado (Anúncio ou Proposta);
     *
     * @param $dadosArray
     * @param $campoCategoria
     * @return array
     */
    public function getCategoriasDados($dadosArray, $campoCategoria)
    {
        $dados = [];

        if(!empty($dadosArray) && is_array($dadosArray))
        {
            foreach ($dadosArray as $dado)
            {
                $categorias = $this->getCategoria($dado, $campoCategoria);

                if (!empty($categorias))
                {
                    array_push($dados, $categorias);
                }
            }
        }

        return $dados;
    }

    /**
     * Adquire as categorias do respetivo dado (Anúncio ou Proposta);
     *
     * @param $dado
     * @param $campoCategoria
     * @return array
     */
    private function getCategoria($dado, $campoCategoria)
    {
        $dados = [];
        array_push($dados, $dado);

        $categoriaID = $dado->$campoCategoria;
        $categoriaMae = Categoria::findOne(['id' => $categoriaID]);

        $categorias = [];

        array_push($categorias, $categoriaMae);

        if(($categoriaFilha = $categoriaMae->cRoupa))
        {
            array_push($categorias, $categoriaFilha);
        }

        if(($categoriaFilha = $categoriaMae->cLivros))
        {
            array_push($categorias, $categoriaFilha);
        }

        if(($categoriaFilha = $categoriaMae->cEletronica))
        {
            array_push($categorias, $categoriaFilha);

            if(($categoriaNeta = $categoriaFilha->cComputadores))
            {
                array_push($categorias, $categoriaNeta);
            }

            if(($categoriaNeta = $categoriaFilha->cComputadores))
            {
                array_push($categorias, $categoriaNeta);
            }
        }

        if(($categoriaFilha = $categoriaMae->cBrinquedos))
        {
            array_push($categorias, $categoriaFilha);

            if(($categoriaNeta = $categoriaFilha->cJogos))
            {
                array_push($categorias, $categoriaNeta);
            }
        }

        array_push($dados, $categorias);

        return $dados;
    }
}