<?php

namespace app\repositories;

use app\models\Visit;

class VisitRepository
{
    public function getByIPandLinkId($ip, $linkId)
    {
        $visit = Visit::findOne(['ip' => $ip, 'link_id' =>  $linkId]);
        return $visit ? $visit : new Visit() ;
    }
    public function save(Visit $visit, $runValidation = true){
        return $visit->save($runValidation) ? $visit : null;
    }
}