<?php

/*
    Copyright © 2018, Xenolith Games, LLC.
*/

$config = 'compile.csv';
$output = 'output.odt';
$exclude = 'exclude.csv';
$margin = '0.5in';
$wd = '..'; // Working Directory

if(!function_exists('readline')) {
  function readline( $prompt = '> ' )
  {
    echo $prompt;
    return rtrim(fgets(STDIN), "\n");
  }
}

if($argc > 1) {

    $options = getopt('c:o:x:');

    if(!empty($options['c'])) {
        $config = $options['c'];
    } else {
        exit("Provide a Config file. `compile.php -c example.csv`" . PHP_EOL);
    }

    if(!empty($options['x'])) {

    }

    if(!empty($options['o'])) {

        $output = $options['o'];

        if(!file_exists($config)) {
            exit('Config file does not exist!' . PHP_EOL);
        }

        $files = file($config);

        foreach($files as $key => $file) {
			if(strpos($file, '.md') !== false) {
            	$files[$key] = escapeshellarg(trim($file));
			} else {
				unset($files[$key]);
			}
        }

        $files = implode(' ', $files);

        // Build the document.

        if(!chdir($wd)) {
            exit("Could not change to working directory...");
        }

        system('pandoc -V documentclass=report -V margin-left=' . $margin . ' -V margin-right=' . $margin . ' --toc --top-level-division=chapter -f markdown -o ' . $output . ' ' . $files);

    } else {

         // Build the compile.csv //

        if(!chdir($wd)) {
            exit("Could not change to working directory...");
        }

        $dir = new RecursiveDirectoryIterator('.');
        $itr = new RecursiveIteratorIterator($dir);
        $reg = new RegexIterator($itr, '/^.+\.md$/i');

        $lines = array();

        foreach($reg as $name => $obj) {

            $lines[] =  $name;

        }

        $lines = implode(PHP_EOL, $lines);

        $w = readline("Write to " . $config .  "? ");

        if(!chdir(__DIR__)) {
            exit("Could not change to compiler directory...");
        }

        if(stristr($w, 'Y')) {
            file_put_contents($config, $lines);
        }
    }

} else {

    $lines = array(
        '',
        '-- Xenolith Games, LLC Document Compiler -- ',
        '',
        'Compiles Markdown file structure into a single document',
        '',
        'Options:',
        ' -c [config.csv] : Specifies a config files to write/read to.',
        ' -o [output.odt] : Specifies an output format that Pandoc can use. ',
        '                   Omitting this will write the config file only.',
        '',
        ''
    );


    echo implode(PHP_EOL, $lines);
}
