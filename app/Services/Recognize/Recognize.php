<?php

/**
 * Recognize file
 *
 * PHP Version 7.4
 *
 * @category Services
 * @package  Services\Recognize
 * @author   Renato Laranjo <renatolaranjo@gmail.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/renatolaranjo/php-python-face-recognition/app/Services
 */

namespace App\Services\Recognize;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Recognize Class
 *
 * @category Services
 * @package  Services\Recognize
 * @author   Renato Laranjo <renatolaranjo@gmail.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://github.com/renatolaranjo/php-python-face-recognition/app/Services
 */
class Recognize
{
    /**
     * DIRECTORY SEPARATOR
     */
    const DS = DIRECTORY_SEPARATOR;

    /**
     * Execute
     *
     * @param array $img64encode Image Encoded
     *
     * @return void
     */
    public function execute($nip, $img64encode)
    {
        $output = $this->runScript($nip, $img64encode);
        $found = new Found();
        $notFound = new NotFound();
        $noFace = new NoFace();
        $found->next($notFound);
        $notFound->next($noFace);
        return $found->getResult($output);
    }

    /**
     * Run script python
     *
     * @param string $img64encode Image encoded
     * @return object
     */
    private function runScript($nip, $image)
    {
        $scriptPath = app_path('Console' . self::DS . 'Scripts' . self::DS . $nip);
        // if(!is_dir($scriptPath)){
        //     return "{'confidence': '101', 'id' : 'no_face'}";
        // }
        $scriptPathHaar = app_path('Console' . self::DS . 'Scripts');
        $storagePath = storage_path('app' . self::DS . 'public' . self::DS . $image);
        $scriptAppPath = $scriptPathHaar . self::DS . 'face_recog.py';

        // $command = escapeshellcmd(env('PYTHON_PATH3') . " $scriptAppPath $storagePath $scriptPath $scriptPathHaar");
        $command = escapeshellcmd("/usr/local/bin/python3.8 $scriptAppPath $storagePath $scriptPath $scriptPathHaar");
        // var_dump($command); die;
        exec($command, $result);

        return $result;


        // $process = new Process([
        //     env('PYTHON_PATH'),
        //     $scriptPath . self::DS . 'face_recog.py',
        //     $storagePath. self::DS. $image,
        //     $scriptPath
        // ], $scriptPath);
        // $process->run();
        // if (!$process->isSuccessful()) {
        //     throw new ProcessFailedException($process);
        // }
        // $output =  json_decode($process->getOutput());
        // return $output;
    }
}
