<?php

namespace Modules\Core\Trait;

trait GridTrait
{
    public $rows = [];
    public $can_export = false;
    public $can_import = false;

    public array $actions = [];
    public array $columns = [];
    public array $buttons = [];
    public array $filters = [];

    public function renderGridView()
    {
        return $this->renderView( 'core::grid.grid_table' , [ 'view_model' => $this ] );
    }

    public function getRowUpdate($row)
    {
        return $row;
    }

    public function getActionUpdate( $actions , $row)
    {
        return $actions;
    }

    public function setGridData()
    {
        return $this;
    }

    public function addColumn($data)
    {
        $this->columns[] = $data;
        return $this;
    }

    public function addAction($data)
    {
        $this->actions[] = $data;
        return $this;
    }

    public function addButton($data)
    {
        $this->buttons[] = $data;
        return $this;
    }

    public function addFilter($data)
    {
        $this->filters[] = $data;
        return $this;
    }

    public function setColumns()
    {
        return $this;
    }

    public function getActionUrl($route, $row = null)
    {
        if (is_string($route)) {
            return url($route);
        }
        if (is_array($route)) {
            $routeParams = [];
            if (isset($route['parameter'])) {
                if (is_array($route['parameter'])) {
                    $routeParams = [];
                    foreach ($route['parameter'] as $key => $value) {
                        if (is_array($value) && isset($value['value'])) {
                            $routeParams[$key] = $value['value'];
                        } else {
                            if (isset($row->{$key})) {
                                $routeParams[$value] = $row->{$key};
                            } else {
                                if (!$row) {
                                    continue;
                                }
                                $routeParams[$value] = $row->{$value};
                            }

                        }
                    }
                } else {
                    $routeParams = [$route['parameter'] => $row->{$route['parameter']}];
                }
            }
            if (sizeof($routeParams) == 1)
                $routeParams = implode(',', $routeParams);
            return route($route['name'], $routeParams);
        }
        return '#';
    }

    public function generateFilterHtml($filter_options)
    {
        return $this->renderView( 'core::grid.filters.'.$filter_options['type'] , [ 'view_model' => $this , 'options'=> $filter_options ] );
    }

    public function getRowExportUpdate($row)
    {
        return $row;
    }

    public function getRowImportUpdate($row)
    {
        return $row;
    }



}
