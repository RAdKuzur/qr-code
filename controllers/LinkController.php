<?php

namespace app\controllers;

use app\models\Link;
use app\models\Visit;
use app\repositories\LinkRepository;
use app\repositories\VisitRepository;
use Endroid\QrCode\Builder\Builder;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class LinkController extends Controller
{
    private LinkRepository $linkRepository;
    public function __construct(
        $id,
        $module,
        LinkRepository $linkRepository,
        $config = [])
    {
        $this->linkRepository = $linkRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(){
        $model = new Link();
        return $this->render('index', ['model' => $model]);
    }
    public function actionCheckUrl()
    {
        $model = new Link();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->validate()) {
                $link = $this->linkRepository->save($model);
                if ($link) {
                    $qrCodeUrl = Url::to(['link/qr', 'text' => $link->url], true);
                    return [
                        'success' => true,
                        'shortUrl' => Url::to(['redirect/redirect', 'code' => $link->short_url], true),
                        'qrCodeUrl' => $qrCodeUrl,
                    ];
                } else {
                    return ['success' => false, 'message' => 'Ошибка сохранения ссылки'];
                }
            } else {
                return ['success' => false, 'message' => $model->getFirstError('url')];
            }
        }
        throw new \yii\web\BadRequestHttpException('Неверный запрос');
    }
    public function actionQr($text)
    {
        $result = Builder::create()
            ->data($text)
            ->size(200)
            ->build();
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/png');
        return $result->getString();
    }
}