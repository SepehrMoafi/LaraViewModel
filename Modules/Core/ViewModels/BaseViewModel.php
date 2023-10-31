<?php

namespace Modules\Core\ViewModels;

class BaseViewModel
{
    public $theme_name = 'theme_master';
    public $modelData = 'theme_master';

    /**
     * @param null $key
     * @param null $default
     * @return null
     */
    public function getModelDataJson($key = null, $default = null)
    {
        if ($this->modelData){
            try{
                $keyArr = explode(".", $key);
                $first = reset($keyArr);
                $data_json = $this->getModelData($first);
                if ($data_json && is_object($data_json)){
                    unset($keyArr[0]);
                    $obj = $data_json;
                    $counter = 0;
                    foreach ($keyArr as $item) {
                        $obj = !$counter && isset($obj->$item) ? $obj->$item : $default;
                    }
                    return $obj;
                }
            }catch (\Exception $exception){
                report($exception);
                return $default;
            }
        }
        return $default;
    }

    /**
     * @param null $name
     * @param null $return
     * @return bool|mixed|null
     */
    public function getModelData($name = null, $return = null)
    {

        if (is_null($name)) {
            return $this->modelData;
        }
        if (is_object($this->modelData)) {
            if (isset($this->modelData->{$name})) {
                return $this->modelData->{$name};
            } else {
                return $return;
            }
        }
        if (is_array($this->modelData)) {
            if (isset($this->modelData[$name])) {
                return $this->modelData[$name];
            }
        }
        return $return;
    }

    public function renderView($view_name ,$compacts = [])
    {
        $arr = explode('::', $view_name);
        $view_name = $arr[0].'::'.$this->theme_name.'.'.$arr[1];
        return view($view_name ,$compacts);
    }

    public function uploadFile( $request , $file_request_name , $sub_directory = '' )
    {
        $fileName = time().'_'.$request->$file_request_name->getClientOriginalName();
        $filePath = $request->file($file_request_name)->storeAs('uploads', $fileName, 'public');
        return  '/storage/' . $filePath;
    }



}
