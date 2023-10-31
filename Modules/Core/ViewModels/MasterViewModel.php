<?php

namespace Modules\Core\ViewModels;

class MasterViewModel
{
    public $view_model='';
    public $module_name='';
    public $view_model_action='';

    public $request= null;

    /**
     * resolve view model name space
     * @return string
     */
    private function getViewModelNamespace(string $view_model_name)
    {
        $namespaces = explode('.', $view_model_name);
        $viewModel = "\\Modules\\" . $this->module_name . "\\ViewModels";
        if (!isset($namespaces[1]) && isset($namespaces[0])) {
            $namespaces[1] = $namespaces[0];
        }
        foreach ($namespaces as $namespace) {
            $viewModel .= "\\" . $this->get_uppercase_by_underscores($namespace);
        }
        $viewModel .= "ViewModel";
        return $viewModel;
    }

    /**
     * @param string $view_model_name
     * @return $this
     */
    public function setViewModel(string $view_model_name)
    {
        $this->view_model = $this->getViewModelNamespace($view_model_name);
        return $this;
    }

    /**
     * @param string $module_name
     * @return $this
     */
    public function setModule(string $module_name)
    {
        $this->module_name = $module_name;
        return $this;
    }

    /**
     * @param string $action
     * @return $this
     */
    public function setAction(string $action)
    {
        $this->view_model_action = $action;
        return $this;
    }

    /**
     * @param $string
     * @return string
     */
    public function get_uppercase_by_underscores($string)
    {
        $arr = explode('_', $string);
        $string = '';
        foreach ($arr as $value) {
            if (!empty($value)) {
                $string .= ucfirst($value);
            }
        }
        return $string;
    }

    public function setRequest($request , $items = [] )
    {
        $request->merge($items);
        $this->request = $request;

        return $this;
    }


    public function render()
    {
        $view_model = new $this->view_model();
        $action = $this->view_model_action;
        return $view_model->$action($this->request);
    }





}
