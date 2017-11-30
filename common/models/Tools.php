<?php

namespace common\models;

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
}