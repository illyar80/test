<?php

echo "<pre>";
print_r(getCatalogInfo());



function getCatalogInfo($catName = false, $isJson = false)
{
    if (!$catName) {
        $catName = __DIR__;
    }
    $filesArr = array();
    $totalSize = $totalFiles = $dublicat = 0;
    $dublicatArr = array();
    if ($catalog = opendir($catName)) {
        while (($files = readdir($catalog)) !== false) {
            if ($files !== '.' && $files !== '..') {
                $dirName = $catName . '/' . $files;
                if (is_dir($dirName)) {
                    $inArr = getFilesSize($dirName);
                    $filesArr['in'][$files] = $inArr;
                }
            }
        }
    }
    if (isset($filesArr['in'])) {
        $filesArr = sortArr($filesArr['in']);
    }
    return $isJson ? json_encode($filesArr) : $filesArr;

}


function getFilesSize($catName)
{
    $totalSize = $totalFiles = $dublicat = 0;
    $dublicatArr = $filesArr = $inArr = array();
    $filesArr['totalSize'] = 0;
    if ($catalog = opendir($catName)) {
        while (($files = readdir($catalog)) !== false) {
            if ($files !== '.' && $files !== '..') {
                $dirName = $catName . '/' . $files;
                if (file_exists($dirName) && !is_dir($dirName)) {
                    $fsize = filesize($dirName);
                    $totalFiles++;
                    $totalSize += $fsize;
                    $hash = md5(file_get_contents($dirName));

                    $dublicatArr[$hash] = empty($dublicatArr[$hash]) ? 1 : ++$dublicatArr[$hash];
                    if (isset($dublicatArr[$hash]) && $dublicatArr[$hash] > 1) {
                        $dublicat++;
                    }
                } else {
                    $inArr = getFilesSize($dirName);
                    $filesArr['in'][$files] = $inArr;
                    $filesArr['in'][$files]['totalSize'] = $inArr['totalSize'];
                    $filesArr['totalSize'] += $inArr['totalSize'];
                }
            }
        }
        if (isset($filesArr['in'])) {
            $filesArr['in'] = sortArr($filesArr['in']);
        }
        $filesArr['duplicate'] = $dublicat;
        $filesArr['totalSize'] += $totalSize;
        $filesArr['numberFiles'] = $totalFiles;
    }
    return $filesArr;
}



function sortArr($arr)
{
    if (count($arr) == 0) {
        return ($arr);
    }
    $midArr = $midArr = $newArr = array();
    foreach ($arr as $name => $data) {
        $midArr[$name] = $data['totalSize'];
    }
    asort($midArr);

    foreach ($midArr as $name => $size) {
        $newArr[$name] = $arr[$name];
    }
    return $newArr;
}