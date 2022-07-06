<?php

namespace app\controllers;

use app\models\Supplier;
use app\models\SupplierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Supplier models.
     *
     * @return string
     */
    public function actionIndex()
    {
//        var_dump(chr(0xEF).'|'.chr(0xBB).'|'.chr(0xBF));
//        die();

        $searchModel = new SupplierSearch();

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Supplier model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Supplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Supplier();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Supplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Supplier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplier::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 导出数据到CSv
     */
    public function actionExport() {
        if(strlen($_GET['ids'])==0){
            $result = Supplier::find()->all();
        }else{
            $idsArr = explode(',',$_GET['ids']);
            $result = Supplier::findAll(['id' =>$idsArr ]);
        }

        $filedsArr = explode(',',$_GET['fileds']);

        $dataExport[]=$filedsArr;
        foreach ($result as $row) {
            $temp=[];
            foreach ($row->attributes as $k=>$v) {
                if (in_array($k,$filedsArr)){
                    $temp[]=$v;
                }
            }
            $dataExport[] = $temp;
        }

        $fileName = "Suppliers".date('Y-m-d_H-i-s') . '.csv';
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment;filename=".$fileName);
        $fp = fopen('php://output', 'w');
        foreach ($dataExport as $row) {
            fputcsv($fp, $row);
        }

//        theCsv::export([
//            'data' => $dataExport,
//        ]);

    }

    /**
     * 选择要导出的列
     */
    public function actionField()
    {
        return $this->render('field', [
            'ids' => $_GET['ids'],
        ]);
    }

}
