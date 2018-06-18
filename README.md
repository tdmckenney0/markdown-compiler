# Xenolith Games Document Compiler

This digests all of our markdown files, based on a `config.csv` file, and turns them into a beautiful typeset PDF or Word document. This *requires* `pandoc` (https://pandoc.org/) to be installed on your system to work. 

## compile.php

A PHP 5.6+ Script Performs that two functions:

1. Creates a basic `config.csv` to be used as an input file based on the structure of the current directory.

2. Takes a `config.csv` file and assembles a single document. 

Note: In order to generate a PDF, you will need `pdflatex` for your platform.

## config.csv

Each line contains a absolute path to the working directory containg markdown files which will be combined, in line order, into a single document.  

Example: `.\Planets\Cumbria.md`

Also, images can be inserted by creating a markdown file, containing an absolute path from the working directory. 

Example: `.\Characters\Athena\example_athena_1.jpg` 

## Usage

`php compile.php` displays useful help documentation.

`php compile.php -c config.csv` writes a new config file to `config.csv`. Will prompt before overwriting. 

`php compile.php -c config.csv -o output.odt` reads from the config file `config.csv` and writes out a new document to `output.odt`. 