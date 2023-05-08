<?php

namespace App\Services\Compare;

class Compare
{
    const DS = DIRECTORY_SEPARATOR;

    public function execute($image1, $image2)
    {
        $output = $this->runScript($image1, $image2);

        return $output;
    }

    private function runScript($image1, $image2)
    {
        $image1 = storage_path('app' . self::DS . 'public' . self::DS . $image1);
        $image2 = storage_path('app' . self::DS . 'public' . self::DS . $image2);
        $pathScript = 'Console' . self::DS . 'Scripts' .
            self::DS . 'face_compare.py';
        $scriptAppPath = app_path($pathScript);
        $path = env('PYTHON_PATH3') ?? "/usr/bin/python3";
        $console = $path . " $scriptAppPath $image1 $image2";
        // var_dump($console); die;
        try {
            exec(escapeshellcmd($console), $result);
            return $result;
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}
