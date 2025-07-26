<?php

namespace app\controllers;

use app\models\Visit;
use app\repositories\LinkRepository;
use app\repositories\VisitRepository;
use Yii;

class RedirectController extends \yii\web\Controller
{
    private LinkRepository $linkRepository;
    private VisitRepository $visitRepository;
    public function __construct(
        $id,
        $module,
        LinkRepository $linkRepository,
        VisitRepository $visitRepository,
        $config = [])
    {
        $this->linkRepository = $linkRepository;
        $this->visitRepository = $visitRepository;
        parent::__construct($id, $module, $config);
    }
    public function actionRedirect($code)
    {
        $link = $this->linkRepository->getByShortCode($code);
        if (!$link) {
            throw new \yii\web\NotFoundHttpException('Короткая ссылка не найдена.');
        }
        $this->linkRepository->save($link, false);
        $visit = $this->visitRepository->getByIPandLinkId(Yii::$app->request->userIP, $link->id);
        $visit->fill($link->id, Yii::$app->request->userIP);
        $this->visitRepository->save($visit, false);
        return $this->redirect($link->url);
    }
}