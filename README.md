<p align="center"><h1>Laravel Importer</h1></p>

<p align="center">
<a href="https://styleci.io/repos/82349568"><img src="https://styleci.io/repos/82349568/shield?branch=master" alt="StyleCI"></a>
<a href="https://travis-ci.org/DuckThom/laravel-importer"><img src="https://travis-ci.org/DuckThom/laravel-importer.svg?branch=master" alt="TravisCI"></a>
</p>

<h1>Note: This project is not finished yet. It will not work in it's current form and/or state.</h1>

<h3># Configuration</h3>
`config/importer.php`:
```php
return [
    /**
     * These will define the model and table specific properties
     * to be used for a specific import.
     */
    'importers' => [
        'product' => ProductImporter::class,
    ],
    
    /**
     * These will loop through the file and perform the database
     * insertions.
     */
    'runner' => [
        'csv' => CsvRunner::class, // Import the data from a csv file
    ]
];
```