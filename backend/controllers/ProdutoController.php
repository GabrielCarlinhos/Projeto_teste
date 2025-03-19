<?php

namespace app\controllers;

use Yii;
use app\models\Produto;

use yii\web\Controller;
use yii\web\Response;

class ProdutoController extends Controller
{
      public function beforeAction($action)
    {
        if ($action->id == 'create' || $action->id == 'update') {
            Yii::$app->controller->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $produtos = Produto::find()
            ->with('categoria0')
            ->asArray()
            ->all();

        $result = [];
        foreach ($produtos as $produto) {
            $result[] = [
                'id' => $produto['id'],
                'nome' => $produto['nome'],
                'quantidade' => $produto['quantidade'],
                'categoria' => $produto['categoria0']['nome'] ?? null,
            ];
        }

        return $result;
    }

    public function actionCreate(){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->getRawBody();
            $data = json_decode($data,true);
            $produto = new Produto();
            
            $produto->setAttributes($data);
          
        if ($produto->save()) {
            return ['status' => 'success', 'message' => 'Produto inserido com sucesso!', 'produto' => $produto];
        } else {
            return ['status' => 'error', 'message' => 'Falha ao inserir produto.', 'errors' => $produto->errors];
        }
    }

    public function actionUpdate($id){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Yii::$app->request->getRawBody();
        $data = json_decode($data,true);

        $produto = Produto::findOne($id);
        $produto->setAttributes($data);
        if ($produto->save()) {
            return ['status' => 'success', 'message' => 'Produto inserido com sucesso!', 'produto' => $produto];
        } else {
            return ['status' => 'error', 'message' => 'Falha ao inserir produto.', 'errors' => $produto->errors];
        }
    }


    public function actionDelete($id){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $produto = Produto::findOne($id);
        if($produto->delete()){
            return ['status' => 'success', 'message' => 'Produto excluído'];
        }else{
            return ['status' => 'error', 'message' => 'Erro!'];
        }
    }

    public function actionGet($id){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $produto = Produto::findOne($id);
        $result = [
            'nome' => $produto['nome'],
            'quantidade' => $produto['quantidade'],
            'categoria' => $produto['categoria'],
        ];
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
                    'Access-Control-Allow-Headers' => ['Content-Type'],
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],

            ],
        ];
    }
}
