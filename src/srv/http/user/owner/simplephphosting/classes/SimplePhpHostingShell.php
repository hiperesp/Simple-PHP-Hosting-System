<?php
class SimplePhpHostingShell
{
    public static function copyFolder($src, $dst)
    {
        $dir = opendir($src);
        $result = ($dir === false ? false : true);
        if ($result !== false) {
            $result = @mkdir($dst);
            if ($result === true) {
                while (false !== ($file = readdir($dir))) {
                    if (($file != '.') && ($file != '..') && $result) {
                        if (is_dir($src . '/' . $file)) {
                            $result = self::copyFolder($src . '/' . $file, $dst . '/' . $file);
                        } else {
                            $result = copy($src . '/' . $file, $dst . '/' . $file);
                        }
                    }
                }
                closedir($dir);
            }
        }
        return $result;
    }
    public static function deleteFolder($dirPath)
    {
        if (is_dir($dirPath)) {
            $objects = scandir($dirPath);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                        self::deleteFolder($dirPath . DIRECTORY_SEPARATOR . $object);
                    } else {
                        unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dirPath);
        }
    }
    public static function getAllSubFolders($folder)
    {
        $subfolders = [];
        $dir = new DirectoryIterator($folder);
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                array_push($subfolders, $fileinfo->getFilename());
            }
        }
        return $subfolders;
    }
}
