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

    public static function showAreaSearch($controllerName, $paramsSearch)
    {
        $xhtml      = null;
        $tmplField  = config('shop.template.search');
        $fieldInController = config('shop.config.search');

        $controllerName = (array_key_exists($controllerName, $fieldInController)) ? $controllerName : 'default';
        $xhtmlField = null;

        foreach ($fieldInController[$controllerName] as $field) {
            $xhtmlField .= sprintf(
                '<li>
                    <a href="#" class="dropdown-item select-field" data-field="%s" role="button">
                        %s
                    </a>
                </li>',
                $field,
                $tmplField[$field]['name']
            );
        }

        $searchField = (in_array($paramsSearch['field'], $fieldInController[$controllerName])) ? $paramsSearch['field'] : 'all';

        $xhtml = sprintf(
            '
            <div class="input-group">
                <button type="button" class="btn btn-outline-secondary dropdown-toggle btn-active-field"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    %s <span class="caret"></span>
                </button>
                
                <ul class="dropdown-menu dropdown-menu-end">
                    %s
                </ul>

                <input type="text" class="form-control" name="search_value" value="%s">
                
                <input type="hidden" name="search_field" value="%s">
                
                <div class="input-group-append ms-4">
                    <button id="btn-clear-search" type="button" class="btn btn-success me-2">Xóa tìm kiếm</button>
                    <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </div>',
            $tmplField[$searchField]['name'],
            $xhtmlField,
            $paramsSearch['value'],
            $searchField,
        );

        return $xhtml;
    }
}
