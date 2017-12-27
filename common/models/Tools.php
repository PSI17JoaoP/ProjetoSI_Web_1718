<?php

namespace common\models;

use yii\db\Query;

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
}