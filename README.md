<p align="center">Laravel Importer</p>

<p align="center">
<a href="https://styleci.io/repos/82349568"><img src="https://styleci.io/repos/82349568/shield?branch=master" alt="StyleCI"></a>
<a href="https://travis-ci.org/DuckThom/laravel-importer"><img src="https://travis-ci.org/DuckThom/laravel-importer.svg?branch=master" alt="TravisCI"></a>
</p>

<h1>Note: This project is not finished yet. It will not work in it's current form and/or state.</h1>

<h3># Features</h3>
This plugin currently only comes with a CSV runner which  means it is only able to parse CSV files out of the box. There will be more info on how to add runners added later.

<h3># Example configuration</h3>
`config/importer.php`:
```php
return [
    /***********************************************************
     * Importers are used for defining specific import tasks
     * For instance, a ProductImporter could import a file with
     * products into a table.
     ***********************************************************/
    'importers' => [
        'default' => \App\Importers\ProductImporter::class
    ],

    /***********************************************************
     * Runners are used for looping through the file
     * The default is a CSV runner which will loop though
     * CSV files line-by-line. A runner uses an importer to get
     * import specific settings like the model class.
     ***********************************************************/
    'runners' => [
        'default' => \Luna\Importer\Runners\CsvRunner::class
    ]
];
```