<?php

namespace App\Http\Controllers\Common;

trait Common {
    public function encodeFileName($fileName)
    {
        $dotPos = strrpos($fileName, ".");
        $ext = substr($fileName, $dotPos);
        if (strlen($fileName) > 20) {
            $fileName = substr($fileName, 0, 20);
        }
        $newFileName = time();
        $newFileName .= str_replace(array('+', '/', '='), array('_', '_', '='), base64_encode($fileName)) .$ext;
        return $newFileName;
    }

    public function handleUploadFiled($file, $folderPath)
    {
        $path = $file->storeAs("/public/uploads/$folderPath/", $this->encodeFileName($file->getClientOriginalName()));
        if (!empty($path)) {
           return str_replace('public/','/storage/', $path);
        }
        return null;
    }
}