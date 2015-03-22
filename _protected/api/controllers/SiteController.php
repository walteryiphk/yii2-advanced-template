<?php
namespace api\controllers;

use Yii;
use yii\rest\Controller;


/**
 * Site controller.
 * It is responsible for displaying static pages, and logging users in and out.
 */
class SiteController extends Controller
{
    public function actionError() {
        return new \yii\web\NotFoundHttpException();
    }
}
