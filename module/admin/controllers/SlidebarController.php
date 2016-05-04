<?php

namespace app\module\admin\controllers;

use Yii;
use app\module\admin\models\Slidebar;
use app\module\admin\models\SlidebarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SlidebarController implements the CRUD actions for Slidebar model.
 */
class SlidebarController extends Controller
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
     * Lists all Slidebar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SlidebarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Slidebar model.
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
     * Creates a new Slidebar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /*$model = new Slidebar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/

        $model = new Slidebar();

        $imgname = uniqid();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->file->saveAs('images/' . $imgname . '.' . $model->file->extension);
            $dst = 'images/' . $imgname . '2.' . $model->file->extension;
            $src = 'images/' . $imgname . '.' . $model->file->extension;
            if ($this->imageResize($src, $dst) == true) {
                $model->image_url = $imgname . '2.' . $model->file->extension;
                unlink('images/' . $imgname . '.' . $model->file->extension);
            }else{
                $model->image_url = $imgname . '.' . $model->file->extension;
            }
            htmlentities ($model->description);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    public function imageResize($src_image, $dst_image)
    {
        $heightResult = 1000;
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
     * Updates an existing Slidebar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $model = $this->findModel($id);
        $imgname = uniqid();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!empty($model->file)) {
                $model->file->saveAs('images/' . $imgname . '.' . $model->file->extension);
                $dst = 'images/' . $imgname . '2.' . $model->file->extension;
                $src = 'images/' . $imgname . '.' . $model->file->extension;
                if ($this->imageResize($src, $dst) == true) {
                    $model->image_url = $imgname . '2.' . $model->file->extension;
                    unlink('images/' . $imgname . '.' . $model->file->extension);
                } else {
                    $model->image_url = $imgname . '.' . $model->file->extension;
                }
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Slidebar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        unlink('images/' . substr($this->findModel($id)->image_url, strrpos($this->findModel($id)->image_url, '/')));
        $this->findModel($id)->delete();
        //return print ('uploads' . substr($this->findModel($id)->img_file, strrpos($this->findModel($id)->img_file, '/')));
        return $this->redirect(['index']);
    }

    public function actionDisplay($id)
    {
        $publication = Slidebar::find()->where(['id' => $id])->one();
            $publication->display = 1;
            $publication->save();
            return $this->redirect(['index']);
    }

    public function actionHide($id)
    {
        $publication = Slidebar::find()->where(['id' => $id])->one();
        $publication->display = 0;
        $publication->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Slidebar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Slidebar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Slidebar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
