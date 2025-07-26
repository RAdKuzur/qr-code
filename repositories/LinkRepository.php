<?php

namespace app\repositories;

use app\models\Link;

class LinkRepository
{
    public function getByShortCode($code)
    {
        return Link::find()
            ->where(['short_url' => $code])
            ->one();
    }
    public function save(Link $link, $runValidation = true){
        return $link->save($runValidation) ? $link : null;
    }
}