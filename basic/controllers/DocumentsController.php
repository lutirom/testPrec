<?php

namespace app\controllers;

use Yii;
use yii\web\Request;
use yii\web\Controller;
use app\models\Document;
use yii\data\Pagination;

class DocumentsController extends Controller
{
    /**
     * show page with documents
     */

    public function actionIndex(Request $request)
    {
        $query = Document::find();
        $pages = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => 25]);
        echo $request->get('sort');
        if ($request->get('sort') === 'judgment') {
            $documents = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->where('num_litigation')
            ->orderBy(['justice_id' => SORT_DESC])
            ->all();
        } else {
            $documents = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->where('num_litigation')
            ->all();
        }

        return $this->render('index', [
            'documents' => $documents,
            'pages' => $pages,
        ]);
    }

    /**
     * shows page with chosen document
    */

    public function actionDocument(Request $request)
    {
        $docId = $request->get('id');
        $doc = Document::find()
            ->where(['a_id' => $docId])
            ->one();

        return $this->render('document', [
            'doc' => $doc,
        ]);
    }

    public function actionGetDocument(Request $request)
    {
        $searchLine = $request->get('line');
        $docList = Document::find()
            ->limit(10)
            ->select(['a_id', 'num_litigation'])
            ->where(['like', 'num_litigation', $searchLine])
            ->all();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'docList' => $docList,
        ];

    }

}

 