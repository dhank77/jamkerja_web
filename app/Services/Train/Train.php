<?php

/**
 * Recognize file
 *
 * PHP Version 7.4
 *
 * @category Services
 * @package  Services\Train
 * @author   Renato Laranjo <renatolaranjo@gmail.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/renatolaranjo/php-python-face-recognition/app/Services
 */

namespace App\Services\Train;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Train Class
 *
 * @category Services
 * @package  Services\Train
 * @author   Renato Laranjo <renatolaranjo@gmail.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://github.com/renatolaranjo/php-python-face-recognition/app/Services
 */
class Train
{
    /**
     * DIRECTORY SEPARATOR
     */
    const DS = DIRECTORY_SEPARATOR;

    /**
     * Execute
     *
     * @param object $request Request
     *
     * @return void
     */
    public function execute($nip)
    {
        $this->runScript($nip);

        return response()->json([
            'status' => 'success',
        ], 201);
    }

    /**
     * Run script python
     *
     * @return void
     */
    private function runScript($nip)
    {
        $storagePath = storage_path('app' . self::DS . 'public' . self::DS . 'faces' . self::DS . $nip);
        $scriptPath = app_path('Console' . self::DS . 'Scripts');
        $pathScript = 'Console' . self::DS . 'Scripts' .
            self::DS . 'face_train.py';
        $scriptAppPath = app_path($pathScript);
        // $console = env('PYTHON_PATH3') . " $scriptAppPath $storagePath $scriptPath $nip";
        $console = "/usr/local/bin/python3.8 $scriptAppPath $storagePath $scriptPath $nip";
        // var_dump($console); die;
        try {
            exec(escapeshellcmd($console), $result);
            return $result;
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}
