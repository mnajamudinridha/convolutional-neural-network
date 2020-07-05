<?php

function getDirContents($dir, &$results = array()){
    $files = scandir($dir);
    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }
    return $results;
}

function getPages($pageNum, $perPage, $input){
    $start = ($pageNum-1) * $perPage;
    $end = $start + $perPage;
    $count = count($input);

    // Conditionally return results
    if ($start < 0 || $count <= $start) {
        // Page is out of range
        return array(); 
    } else if ($count <= $end) {
        // Partially-filled page
        return array_slice($input, $start);
    } else {
        // Full page 
        return array_slice($input, $start, $end - $start);
    }
}

function followFiles($file)
{
    $size = 0;
    while (true) {
        clearstatcache();
        $currentSize = filesize($file);
        if ($size == $currentSize) {
            usleep(1000000);
            continue;
        }

        $fh = fopen($file, "r");
        fseek($fh, $size);

        while ($d = fgets($fh)) {
            echo $d;
        }
        fclose($fh);
        $size = $currentSize;
    }
}
?>