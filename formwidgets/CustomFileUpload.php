<?php namespace Jc91715\Widget\FormWidgets;

use Backend\Classes\FormWidgetBase;
use System\Models\File;
use Jc91715\Oss\Models\Settings;
use October\Rain\Database\Attach\Resizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * CustomFileUpload Form Widget
 */
class CustomFileUpload extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'yiyou_activity_custom_file_upload';

    public $ifCrop = 0;//是否裁剪
    public $radio = 1;//裁剪比例宽/高
    public $inputId = 'custom-input-src';//输入框id引入多个widget不能重复
    public $inputFileId = 'file-change';//上传文件id多个widget不能重复
    public $imgId = 'img-src-temp';//图片标签id多个widget不能重复
    public $cropId = 'crop-id';//裁剪按钮id多个widget不能重复
    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->fillFromConfig([
            'ifCrop',
            'radio',
            'inputId',
            'inputFileId',
            'imgId',
            'cropId'
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('customfileupload');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['ifCrop'] = $this->ifCrop;
        $this->vars['radio'] = $this->radio;
        $this->vars['inputId'] = $this->inputId;
        $this->vars['inputFileId'] = $this->inputFileId;
        $this->vars['imgId'] = $this->imgId;
        $this->vars['cropId'] = $this->cropId ;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/customfileupload.css', 'yiyou.activity');
        $this->addJs('js/customfileupload.js', 'yiyou.activity');
        $this->addCss('//cdn.bootcss.com/jquery-jcrop/2.0.4/css/Jcrop.css');
        $this->addJs('//cdn.bootcss.com/jquery-jcrop/2.0.4/js/Jcrop.js');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }

    public function onCustomUpload()
    {
        $data = request()->base64;
        $base64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));

        $dir_temp= date('Y-m').'/';
        if(!is_dir(storage_path('app/uploads/'.$dir_temp))){
            mkdir(storage_path('app/uploads/'.$dir_temp), 0777, true);
        }

        if(request()->ifCrop){
            $url = $this->imginfo($dir_temp,$base64);
        }else{
            $url = $this->uploadOss($base64);
        }



//        $url = $this->uploadOss($base64);


        return ['src'=>$url];
    }
    public function getUrl($finally_name)
    {
        return rtrim(Settings::get('domain'),'/').'/'.ltrim($finally_name,'/');
    }

    protected function uploadOss($base64)
    {

        $dir = 'app/uploads/'.date('Y-m').'/'.date('Y-m-d').'/';
        $filename = sprintf('%s.%s',str_random(40),'jpeg');
        $finally_name = $dir.$filename;
        \Storage::disk('oss_file')->put($finally_name,$base64);

        return $this->getUrl($finally_name);
    }

    protected function imginfo($dir_temp,$base64)
    {
        $dir = $dir_temp;
        $filename = sprintf('%s.%s',str_random(40),'jpeg');
        $file = '/tmp/'.$filename;
        file_put_contents($file, $base64);
        chmod($file,0777);
        $info = pathinfo($file);
        $img_info=getimagesize($file);

        $uploaded_file = new UploadedFile($file, $info['basename']);

        $radio =$img_info[0]/$img_info[1];
//        $fileName = uniqid().'.'.$uploaded_file->getClientOriginalExtension();

        $filePath = $dir.$filename;
        Resizer::open($uploaded_file)
            ->resize(500 , 500/$radio, array('mode'=> 'portrait', 'quality'=> 30))
            ->save(storage_path('app/uploads/'.$filePath));

       return  \Config::get('cms.storage.uploads.path').'/'.$filePath;
    }

    public function onCrop()
    {
        $crop = request()->crop;
        $src = request()->src;

        if(!$crop||!$src){
            return ['code'=>1,'msg'=>'裁剪出错'];
        }
        $start = strpos($src,'storage');

        Resizer::open(storage_path(substr($src,$start+8)))
            ->crop(
                $crop['x'],
                $crop['y'],
                $crop['w'],
                $crop['h'],
                $crop['w'],
                $crop['h']
            )
            ->save(storage_path(substr($src,$start+8)));

        \Storage::disk('oss_file')->put('storage/'.substr($src,$start+8),file_get_contents(storage_path(substr($src,$start+8))));

        return ['code'=>0,'src'=>$this->getUrl('storage/'.substr($src,$start+8))];
    }
}
