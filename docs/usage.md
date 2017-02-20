# Usage

Let's assume the configuration has a runner defined as `xml` and an importer as `product` like so:

```php
return [
    'importers' => [
        ...
        'product' => App\Importers\ProductImporter::class
        ...
    ],
    'runners' => [
        ...
        'xml' => App\Runners\XmlRunner::class
        ...
    ]
];
```

We can then run the import with the included `Import` facade.

```php
    // Using the key in the config
    \Import::runner('xml')->importer('product')->run();
    
    // OR
    
    // Creating new instances
    \Import::runner(new XmlRunner)->importer(new ProductImporter)->run();
```

If no runner and/or importer is specified, the `default` will be used.

```php
    \Import::run();
```