<?php
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $profile_image;

    public function rules()
    {
        return [
            //[['profile_image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['profile_image'], 'file', 'skipOnEmpty' => true ],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
			$file_name =  $this->profile_image->baseName . '-' . time() . '-' . rand() . '.' . $this->profile_image->extension;
			$file_path = '../../uploads/' . $file_name;
            $this->profile_image->saveAs( $file_path );
            //return true;
            return $file_name;
        } else {
            return false;
        }
    }
}