<?php

namespace app\controllers;

use Yii;
use app\models\Categoria;
use yii\web\Controller;
use yii\web\Response;

class CategoriaController extends Controller
{

    public function actionOptions()
    {
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', '*');  // Set specific origin or '*' for all
        Yii::$app->response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        Yii::$app->response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        Yii::$app->response->headers->set('Access-Control-Allow-Credentials', 'true');

        return Yii::$app->response->send();
    }
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $categorias = Categoria::find()->all();

        $result = [];
        foreach ($categorias as $categoria) {
            $result[] = [
                'id' => $categoria['id'],
                'nome' => $categoria['nome'],
                
            ];
        }

        return $result;
    }


    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    // restrict access to
                    'Origin' => ['http://localhost:4200', 'https://localhost:4200'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Method' => ['POST', 'PUT', 'GET'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],

            ],
        ];
    }
}
