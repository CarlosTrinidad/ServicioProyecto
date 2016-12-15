<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class ImportFile extends Model
{
    /**
     * @var UploadedFile
     */
    public $fileImport;

    public function rules()
    {
        return [
            [['fileImport'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx', 'checkExtensionByMimeType' => false],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->fileImport->saveAs('files/' . $this->fileImport->baseName . '.' . $this->fileImport->extension);
            return true;
        } else {
            return false;
        }
    }
}