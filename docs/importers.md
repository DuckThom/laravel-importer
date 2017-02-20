# Importers

Importers define import specific settings.
They define which Eloquent model to use for example.

## Methods

The following methods are required by an importer.
Custom importers should implement `Luna\Importer\Contracts\Importer`.

```php
/**
 * Parse a csv line to an importable array for the model
 *
 * @param  array  $data
 * @return array
 */
public function parseLine(array $data): array;
```

```php
/**
 * Validate the raw line data
 *
 * @param  array  $data
 * @return bool
 */
public function validateLine(array $data): bool;
```

```php
/**
 * Get the model class path for the import
 *
 * @return string
 */
public function getModel(): string;
```

```php
/**
 * Get the file to import
 *
 * @return string
 */
public function getFilePath(): string;
```

```php
/**
 * Get the unique column key
 *
 * This should match a unique column in the table as
 * this is used to determine if a row needs to be updated
 * or inserted
 *
 * @return string
 */
public function getUniqueKey(): string;
```

```php
/**
 * Determine if the source file should be removed
 *
 * @return bool
 */
public function shouldCleanup(): bool;
```

## Example

```php
namespace Tests;

use App\Product;
use Luna\Importer\Contracts\Importer;
use Luna\Importer\Importers\BaseImporter;

class ProductImporter extends BaseImporter implements Importer
{
    public function parseLine(array $data): array
    {
        return [
            'sku' => $data[0],
            'name' => $data[2]
        ];
    }

    public function getFilePath(): string
    {
        return storage_path('import/products.csv');
    }

    public function getModel(): string
    {
        return Product::class;
    }

    public function getUniqueKey(): string
    {
        return 'sku';
    }

    public function validateLine(array $data): bool
    {
        return count($data) === 3;
    }
    
    public function shouldCleanup(): bool
    {
        return true;
    }
}
```