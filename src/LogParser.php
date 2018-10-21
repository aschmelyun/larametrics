<?php

namespace Aschmelyun\Larametrics;

use Psr\Log\LogLevel;

class LogParser 
{

    private static $file;

    private static $levels_classes = [
        'debug' => 'info',
        'info' => 'info',
        'notice' => 'info',
        'warning' => 'warning',
        'error' => 'danger',
        'critical' => 'danger',
        'alert' => 'danger',
        'emergency' => 'danger',
        'processed' => 'info',
        'failed' => 'warning',
    ];

    private static $levels_imgs = [
        'debug' => 'fe-alert-circle',
        'info' => 'fe-alert-circle',
        'notice' => 'fe-alert-circle',
        'warning' => 'fe-alert-triangle',
        'error' => 'fe-alert-triangle',
        'critical' => 'fe-alert-triangle',
        'alert' => 'fe-alert-triangle',
        'emergency' => 'fe-alert-triangle',
        'processed' => 'fe-alert-circle',
        'failed' => 'fe-alert-triangle'
    ];

    private static $log_levels = [
        'emergency',
        'alert',
        'critical',
        'error',
        'warning',
        'notice',
        'info',
        'debug',
        'processed',
        'failed'
    ];

    const MAX_FILE_SIZE = 52428800; // Why? Uh... Sorry

    public static function setFile($file)
    {
        $file = self::pathToLogFile($file);
        if (app('files')->exists($file)) {
            self::$file = $file;
        }
    }

    public static function pathToLogFile($file)
    {
        $logsPath = storage_path('logs');
        if (app('files')->exists($file)) { // try the absolute path
            return $file;
        }
        $file = $logsPath . '/' . $file;
        // check if requested file is really in the logs directory
        if (dirname($file) !== $logsPath) {
            throw new \Exception('No such log file');
        }
        return $file;
    }

    public static function getFileName()
    {
        return basename(self::$file);
    }

    public static function all()
    {
        $log = array();
        $pattern = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?\].*/';
        if (!self::$file) {
            $log_file = self::getFiles();
            if(!count($log_file)) {
                return [];
            }
            self::$file = $log_file[0];
        }
        if (app('files')->size(self::$file) > self::MAX_FILE_SIZE) return null;
        $file = app('files')->get(self::$file);
        preg_match_all($pattern, $file, $headings);
        if (!is_array($headings)) {
            return $log;
        }
        $log_data = preg_split($pattern, $file);
        if ($log_data[0] < 1) {
            array_shift($log_data);
        }
        foreach ($headings as $h) {
            for ($i=0, $j = count($h); $i < $j; $i++) {
                foreach (self::$log_levels as $level) {
                    if (strpos(strtolower($h[$i]), '.' . $level) || strpos(strtolower($h[$i]), $level . ':')) {
                        preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?)\](?:.*?(\w+)\.|.*?)' . $level . ': (.*?)( in .*?:[0-9]+)?$/i', $h[$i], $current);
                        if (!isset($current[4])) continue;
                        $log[] = array(
                            'context' => $current[3],
                            'level' => $level,
                            'level_class' => self::$levels_classes[$level],
                            'level_img' => self::$levels_imgs[$level],
                            'date' => $current[1],
                            'text' => $current[4],
                            'in_file' => isset($current[5]) ? $current[5] : null,
                            'stack' => preg_replace("/^\n*/", '', $log_data[$i])
                        );
                    }
                }
            }
        }
        if (empty($log)) {
            $lines = explode(PHP_EOL, $file);
            $log = [];
            foreach($lines as $key => $line) {
                $log[] = [
                    'context' => '',
                    'level' => '',
                    'level_class' => '',
                    'level_img' => '',
                    'date' => $key+1,
                    'text' => $line,
                    'in_file' => null,
                    'stack' => '',
                ];
            }
        }
        return array_reverse($log);
    }

    public static function getFiles($basename = false)
    {
        $pattern = function_exists('config') ? config('logviewer.pattern', '*.log') : '*.log';
        $files = glob(storage_path() . '/logs/' . $pattern, preg_match('/\{.*?\,.*?\}/i', $pattern) ? GLOB_BRACE : 0);
        $files = array_reverse($files);
        $files = array_filter($files, 'is_file');
        if ($basename && is_array($files)) {
            foreach ($files as $k => $file) {
                $files[$k] = basename($file);
            }
        }
        return array_values($files);
    }

}