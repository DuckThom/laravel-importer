# Configuration

The published configuration file (`config/importer.php`) contains 2 arrays: `importers` and `runners`.
Both arrays should contain a key `default`, which is the key that will be used when no specific importer/runner is specified.

## Example:

```php
return [
    /***********************************************************
     * Importers are used for defining specific import tasks
     * For instance, a ProductImporter could import a file with
     * products into a table.
     ***********************************************************/
    'importers' => [
        'default' => App\Importers\ProductImporter::class,
        'user' => App\Importers\UserImporter::class
    ],

    /***********************************************************
     * Runners are used for looping through the file
     * The default is a CSV runner which will loop though
     * CSV files line-by-line. A runner uses an importer to get
     * import specific settings like the model class.
     ***********************************************************/
    'runners' => [
        'default' => \Luna\Importer\Runners\CsvRunner::class
        'xml' => App\Runners\XmlRunner::class
    ]
];
```