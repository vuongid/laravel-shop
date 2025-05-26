<?php

namespace App\Helpers;


class Template
{
    public static function showItemStatus($controllerName, $id, $statusValue)
    {
        $tmplStatus            = config('shop.template.status');
        // $statusValue           = array_key_exists($statusValue, $tmplStatus) ? $statusValue : 'default';
        $currentTemplateStatus = $tmplStatus[$statusValue];
        $link                  = '#';
        // $link                  = route($controllerName . '/status', ['status' => $statusValue, 'id' => $id]);

        $xhtml = sprintf(
            '<a href="%s" type="button" class="btn btn-round %s">%s</a>',
            $link,
            $currentTemplateStatus['class'],
            $currentTemplateStatus['name']
        );
        return $xhtml;
    }
}
