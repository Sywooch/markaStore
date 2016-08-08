<?php

namespace app\module\admin\controllers;

use Yii;
use app\module\admin\models\Images;
use app\module\admin\models\ImagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use app\module\admin\models\Log;

/**
 * ImagesController implements the CRUD actions for Images model.
 */
class ImagesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Images models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImagesSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Images::find(),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        /*$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
    }

    /**
     * Displays a single Images model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Images model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new images();
        $imgname = uniqid();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->file->saveAs('images/' . $imgname . '.' . $model->file->extension);
            $dst = 'images/' . $imgname . '2.' . $model->file->extension;
            $src = 'images/' . $imgname . '.' . $model->file->extension;
            if ($this->imageResize($src, $dst) == true) {
                $model->img_file = $imgname . '2.' . $model->file->extension;
                unlink('images/' . $imgname . '.' . $model->file->extension);
            }else{
                $model->img_file = $imgname . '.' . $model->file->extension;
            }
            $model->save();

            $newModel = [
                'id' => $model->id,
                'product_id' => $model->product_id,
                'color_id' => $model->color->color_name,
                'file' => $model->file,
            ];
            Log::writeLog(Log::logMessageGenerator(false, $newModel, $model), 'Create', 'Фото товаров');

            return $this->redirect(['view', 'id' => $model->id]);
        }else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Images model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreating($product_id)
    {
        $model = new images();
        $imgname = uniqid();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->file->saveAs('images/' . $imgname . '.' . $model->file->extension);
            $dst = 'images/' . $imgname . '2.' . $model->file->extension;
            $src = 'images/' . $imgname . '.' . $model->file->extension;
            if ($this->imageResize($src, $dst) == true) {
                $model->img_file = $imgname . '2.' . $model->file->extension;
                unlink('images/' . $imgname . '.' . $model->file->extension);
            }else{
                $model->img_file = $imgname . '.' . $model->file->extension;
            }
            $model->save();

            $newModel = [
                'id' => $model->id,
                'product_id' => $model->product_id,
                'color_id' => $model->color->color_name,
                'file' => $model->file,
            ];
            Log::writeLog(Log::logMessageGenerator(false, $newModel, $model), 'Create', 'Фото товаров');

            return $this->redirect(['view', 'id' => $model->id]);
        }else {
            return $this->render('create', [
                'model' => $model,
                'product_id' => $product_id,
            ]);
        }

    }


    public function imageResize($src_image, $dst_image)
    {
        $heightResult = 1500;
        list($width, $height) = getimagesize($src_image);
            if ($height > $heightResult) {
                $widthResult = ($heightResult / $height) * $width;
                $get_image = imagecreatefromjpeg($src_image);
                $create_image = imagecreatetruecolor($widthResult, $heightResult);
                imagecopyresized($create_image, $get_image, 0, 0, 0, 0, $widthResult, $heightResult, $width, $height);
                imagejpeg($create_image, $dst_image);
                return true;
            }else{
                return false;
            }
    }


    /**
     * Updates an existing Images model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $model = $this->findModel($id);

        $oldModel = [
            'id' => $model->id,
            'product_id' => $model->product_id,
            'color_id' => $model->color->color_name,
            'file' => $model->file,
        ];
        
        $imgname = uniqid();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!empty($model->file)) {
                $model->file->saveAs('images/' . $imgname . '.' . $model->file->extension);
                $dst = 'images/' . $imgname . '2.' . $model->file->extension;
                $src = 'images/' . $imgname . '.' . $model->file->extension;
                if ($this->imageResize($src, $dst) == true) {
                    $model->img_file = $imgname . '2.' . $model->file->extension;
                    unlink('images/' . $imgname . '.' . $model->file->extension);
                } else {
                    $model->img_file = $imgname . '.' . $model->file->extension;
                }
                $model->save();

                $newModel = [
                    'id' => $model->id,
                    'product_id' => $model->product_id,
                    'color_id' => $model->color->color_name,
                    'file' => $model->file,
                ];
                Log::writeLog(Log::logMessageGenerator($oldModel, $newModel, $model), 'Update', 'Фото товаров');

                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                $model->save();

                $newModel = [
                    'id' => $model->id,
                    'product_id' => $model->product_id,
                    'color_id' => $model->color->color_name,
                    'file' => $model->file,
                ];
                Log::writeLog(Log::logMessageGenerator($oldModel, $newModel, $model), 'Update', 'Фото товаров');

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

        /*$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }*/
    }

    /**
     * Deletes an existing Images model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        unlink('images/' . substr($this->findModel($id)->img_file, strrpos($this->findModel($id)->img_file, '/')));
        $this->findModel($id)->delete();

        $newModel = [
            'id' => $id,
        ];
        $model = new Images();
        Log::writeLog(Log::logMessageGenerator(false, $newModel, $model), 'Delete', 'Фото товаров');
        //return print ('uploads' . substr($this->findModel($id)->img_file, strrpos($this->findModel($id)->img_file, '/')));
        return $this->redirect(['index']);
    }

    /**
     * Finds the Images model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Images the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Images::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
