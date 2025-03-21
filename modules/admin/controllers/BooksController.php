<?php

namespace app\modules\admin\controllers;

use app\models\WorkImages;
use app\models\Sms;
use app\models\Books;
use app\models\AutorsBook;
use app\modules\admin\models\BooksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * BooksController implements the CRUD actions for Books model.
 */
class BooksController extends Controller
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
     * Lists all Books models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Books model.
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
     * Creates a new Books model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Books();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                $authors = $_POST['Books']["author_id"];

                # Загрузка обложки книги
                if (!empty($_FILES['upload_image']) && $_FILES['upload_image']['error'] == 0){

                    $sizes = ['width' => 400, 'height' => null];
                    $img = new WorkImages();

                    try {	

                        $result_original_image = $img->addImage($model->id,  $_FILES['upload_image']['type'], $_FILES['upload_image']['tmp_name'], 'images', $sizes["width"], $sizes["height"]);
                        
                        # Сохранения информации об обложки в  модель
                        $model->saveInfoImg($result_original_image);

                    } catch (\Exception $e) {
                    
                        echo $e->getMessage();
                    
                    }

                    
                }

                # Сохранение авторов
                if (count($authors) > 0)
                {
                    foreach ($authors as $author)
                    {
                        $authorAdd = new AutorsBook();
                        $authorAdd->author_id = $author;
                        $authorAdd->book_id = $model->id;
                        $authorAdd->save();

                        # СМС рассылка о выходе новой книге.
                        try {	

                            $sms = new Sms();
                            $sms->sendingSms($model->title, $author);
                        
                        } catch (\Exception $e) {

                            echo $e->getMessage();

                        }

                    }
                }
                
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


 

    public function actionReport()
    {

        $start = Yii::$app->request->get('date-start');
        $end = Yii::$app->request->get('date-end');

        $model = Yii::$app->db->createCommand('SELECT ab.author_id, COUNT(ab.author_id) as total, b.year_release, a.id, a.FIO 
            FROM books b, authors a, autors_book ab
                WHERE ab.author_id = a.id AND b.id = ab.book_id AND year_release BETWEEN :start AND :end GROUP BY ab.author_id 
                    ORDER BY COUNT(ab.author_id) DESC LIMIT 10')
                    ->bindValue(':start', $start)
                    ->bindValue(':end', $end)
                    ->queryAll();

        return $this->render('report', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Books model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            # Смена изображения
            if (!empty($_FILES['upload_image']) && $_FILES['upload_image']['error'] == 0){

                $sizes = ['width' => 400, 'height' => null];

                $img = new WorkImages();

                $result_original_image = $img->addImage($model->id,  $_FILES['upload_image']['type'], $_FILES['upload_image']['tmp_name'], 'images', $sizes["width"], $sizes["height"]);

                $logo = Books::findOne($model->id);
                $logo->photo = $result_original_image;
                $logo->save();

            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Books model.
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
     * Finds the Books model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Books the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Books::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
