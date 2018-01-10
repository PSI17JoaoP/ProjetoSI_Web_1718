<?php

namespace common\models;

use yii\db\Query;
use common\models\CategoriaRoupa;
use common\models\CategoriaJogos;
use common\models\CategoriaLivros;
use common\models\CategoriaEletronica;
use common\models\CategoriaBrinquedos;
use common\models\CategoriaComputadores;

class Tools
{
    public static function listaRegioes()
    {
        return array('aveiro' => "Aveiro",
                    'beja' => "Beja",
                    'braga' => "Braga",
                    'braganca' => "Bragança",
                    'castbranco' => "Castelo Branco",
                    'coimbra' => "Coimbra",
                    'evora' => "Évora",
                    'faro' => "Faro",
                    'guarda' => "Guarda",
                    'leiria' => "Leiria",
                    'lisboa' => "Lisboa",
                    'portalegre' => "Portalegre",
                    'porto' => "Porto",
                    'santarem' => "Santarém",
                    'setubal' => "Setúbal",
                    'vcastelo' => "Viana do Castelo",
                    'vreal' => "Vila Real",
                    'viseu' => "Viseu",
                    'acores' => "Açores",
                    'madeira' => "Madeira"
                );
    }

    public static function listaCategorias()
    {
        return array('brinquedos' => "Brinquedos" ,
                    'jogos' => "Jogos",
                    'eletronica' => "Eletrónica",
                    'computadores' => "Computadores",
                    'smartphones' => "Smartphones",
                    'livros' => "Livros",
                    'roupa' => "Roupa"
                );
    }

    /**
     * Noma da categoria
     */
    public static function tipoCategoria($idCategoria)
    {
        $base = Categoria::findOne(['id' => $idCategoria]);

        if($base)
        {
            if ($base->cRoupa) {
                return "Roupa";
            }

            if ($base->cLivros) {
                return "Livros";
            }

            if ($base->cEletronica) {
                if ($base->cEletronica->cComputadores) {
                    return "Computadores";
                }else if ($base->cEletronica->cSmartphones) {
                    return "Smartphones";
                }else{
                    return "Eletrónica";
                }

            }

            if ($base->cBrinquedos) {
                if ($base->cBrinquedos->cJogos) {
                    return "Jogos";
                }else{
                    return "Brinquedos";
                }
            }
        }

        return "Aberto a sugestões";
    }

    /**
     * Nova instância da categoria
     * (detalhes only)
     */
    public static function novaCategoria($idCategoria)
    {
        $base = Categoria::findOne(['id' => $idCategoria]);

        if($base)
        {
            if ($base->cRoupa) {
                return new CategoriaRoupa();
            }

            if ($base->cLivros) {
                return new CategoriaLivros();
            }

            if ($base->cEletronica) {
                if ($base->cEletronica->cComputadores) {
                    return new CategoriaComputadores();
                }else if ($base->cEletronica->cSmartphones) {
                    return new CategoriaSmartphones();
                }else{
                    return new CategoriaEletronica();
                }

            }

            if ($base->cBrinquedos) {
                if ($base->cBrinquedos->cJogos) {
                    return new CategoriaJogos();
                }else{
                    return new CategoriaBrinquedos();
                }
            }

            return new Categoria();
        }

        return null;
    }
}