<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clarity;
use App\Models\Color;
use App\Models\Cut;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\Shape;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductImportController extends Controller
{
    private const TEMPLATE_HEADERS = [
        'name',
        'stone_id',
        'slug',
        'shape',
        'color',
        'clarity',
        'cut',
        'row_weight',
        'polish_weight',
        'length',
        'width',
        'table_percent',
        'total_depth',
        'ratio',
        'remarks',
        'short_description',
        'long_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
        'featured_type',
        'featured_path',
        'gallery',
    ];

    public function index()
    {
        return view('backend.pages.products.import');
    }

    public function downloadTemplate()
    {
        $sample = [
            'Round Brilliant 1.02ct',
            'RV-10001',
            'round-brilliant-1-02ct',
            'Round',
            'D',
            'VS1',
            'Excellent',
            '1.02',
            '1.00',
            '6.45',
            '6.42',
            '58',
            '61.2',
            '1.00',
            'Sample remarks',
            '<p>Short <strong>HTML</strong> summary.</p>',
            '<h2>Product Details</h2><p>Long description with <em>HTML</em> formatting.</p><ul><li>Point one</li><li>Point two</li></ul>',
            'SEO Title',
            'SEO description',
            'diamond, round, vs1',
            'active',
            'image',
            'products/featured/example.jpg',
            'image:products/gallery/example1.jpg|image:products/gallery/example2.jpg',
        ];

        $callback = function () use ($sample) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, self::TEMPLATE_HEADERS);
            fputcsv($handle, $sample);
            fclose($handle);
        };

        return response()->streamDownload($callback, 'product-import-template.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $handle = fopen($path, 'r');

        if ($handle === false) {
            return back()->with('error', 'Could not read the uploaded file.');
        }

        $headerRow = fgetcsv($handle);

        if ($headerRow === false || empty(array_filter($headerRow))) {
            fclose($handle);

            return back()->with('error', 'CSV file is empty or missing a header row.');
        }

        $headers = $this->normalizeHeaders($headerRow);
        $lookups = $this->buildLookups();

        $created = 0;
        $updated = 0;
        $errors = [];
        $rowNumber = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;

            if ($this->isEmptyRow($row)) {
                continue;
            }

            $data = $this->mapRow($headers, $row);

            try {
                $result = $this->importRow($data, $lookups);

                if ($result === 'created') {
                    $created++;
                } elseif ($result === 'updated') {
                    $updated++;
                }
            } catch (\Throwable $e) {
                $errors[] = "Row {$rowNumber}: ".$e->getMessage();
            }
        }

        fclose($handle);

        $message = "Import finished. Created: {$created}, Updated: {$updated}.";

        if (! empty($errors)) {
            return back()
                ->with('warning', $message)
                ->with('import_errors', array_slice($errors, 0, 50));
        }

        return redirect()
            ->route('products.import.index')
            ->with('success', $message);
    }

    private function normalizeHeaders(array $headers): array
    {
        return array_map(function ($header) {
            $key = strtolower(trim((string) $header));
            $key = str_replace([' ', '-'], '_', $key);

            return $key;
        }, $headers);
    }

    private function mapRow(array $headers, array $row): array
    {
        $data = [];

        foreach ($headers as $index => $key) {
            $data[$key] = isset($row[$index]) ? trim((string) $row[$index]) : '';
        }

        return $data;
    }

    private function isEmptyRow(array $row): bool
    {
        foreach ($row as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }

    private function buildLookups(): array
    {
        $mapByName = fn ($items) => $items->mapWithKeys(
            fn ($item) => [strtolower(trim($item->name)) => $item->id]
        )->all();

        return [
            'shapes' => $mapByName(Shape::orderBy('name')->get()),
            'colors' => $mapByName(Color::orderBy('name')->get()),
            'clarities' => $mapByName(Clarity::orderBy('name')->get()),
            'cuts' => $mapByName(Cut::orderBy('name')->get()),
        ];
    }

    private function importRow(array $data, array $lookups): string
    {
        $name = $data['name'] ?? '';
        $stoneId = $data['stone_id'] ?? '';

        if ($name === '' && $stoneId === '') {
            throw new \InvalidArgumentException('Either name or stone_id is required.');
        }

        $productData = [
            'name' => $name !== '' ? $name : null,
            'stone_id' => $stoneId !== '' ? $stoneId : null,
            'shape_id' => $this->resolveLookupId($data['shape'] ?? '', $lookups['shapes'], 'shape'),
            'color_id' => $this->resolveLookupId($data['color'] ?? '', $lookups['colors'], 'color'),
            'clarity_id' => $this->resolveLookupId($data['clarity'] ?? '', $lookups['clarities'], 'clarity'),
            'cut_id' => $this->resolveLookupId($data['cut'] ?? '', $lookups['cuts'], 'cut'),
            'row_weight' => $this->nullable($data['row_weight'] ?? ''),
            'polish_weight' => $this->nullable($data['polish_weight'] ?? ''),
            'length' => $this->nullable($data['length'] ?? ''),
            'width' => $this->nullable($data['width'] ?? ''),
            'table_percent' => $this->nullable($data['table_percent'] ?? ''),
            'total_depth' => $this->nullable($data['total_depth'] ?? ''),
            'ratio' => $this->nullable($data['ratio'] ?? ''),
            'remarks' => $this->nullable($data['remarks'] ?? ''),
            'short_description' => $this->nullable($data['short_description'] ?? ''),
            'long_description' => $this->nullable($data['long_description'] ?? ''),
            'meta_title' => $this->nullable($data['meta_title'] ?? ''),
            'meta_description' => $this->nullable($data['meta_description'] ?? ''),
            'meta_keywords' => $this->nullable($data['meta_keywords'] ?? ''),
            'status' => $this->resolveStatus($data['status'] ?? ''),
        ];

        $slugInput = $data['slug'] ?? '';
        $productData['slug'] = $this->resolveUniqueSlug(
            $slugInput !== '' ? Str::slug($slugInput) : Str::slug($name !== '' ? $name : $stoneId)
        );

        $featuredType = strtolower($data['featured_type'] ?? '');
        $featuredPath = $data['featured_path'] ?? '';

        if ($featuredPath !== '') {
            if (! in_array($featuredType, ['image', 'video'], true)) {
                throw new \InvalidArgumentException('featured_type must be image or video when featured_path is set.');
            }
            $productData['featured_type'] = $featuredType;
            $productData['featured_path'] = $featuredPath;
        }

        $existing = null;

        if ($stoneId !== '') {
            $existing = Product::where('stone_id', $stoneId)->first();
        }

        if ($existing) {
            unset($productData['slug']);
            $productData['slug'] = $existing->slug;
            $existing->update($productData);
            $product = $existing;
            $action = 'updated';
        } else {
            $productData['slug'] = $this->resolveUniqueSlug($productData['slug']);
            $product = Product::create($productData);
            $action = 'created';
        }

        $gallery = $data['gallery'] ?? '';

        if ($gallery !== '' && $action === 'created') {
            $this->importGallery($product, $gallery);
        }

        return $action;
    }

    private function resolveLookupId(string $value, array $lookup, string $label): ?int
    {
        if ($value === '') {
            return null;
        }

        $key = strtolower(trim($value));

        if (! isset($lookup[$key])) {
            throw new \InvalidArgumentException("Unknown {$label}: \"{$value}\".");
        }

        return $lookup[$key];
    }

    private function resolveStatus(string $status): string
    {
        $status = strtolower(trim($status));

        if ($status === '' || $status === 'active') {
            return 'active';
        }

        if ($status === 'inactive') {
            return 'inactive';
        }

        throw new \InvalidArgumentException('status must be active or inactive.');
    }

    private function resolveUniqueSlug(string $baseSlug, ?int $ignoreProductId = null): string
    {
        $slug = $baseSlug !== '' ? $baseSlug : 'product-'.time();
        $original = $slug;
        $counter = 1;

        while (
            Product::where('slug', $slug)
                ->when($ignoreProductId, fn ($q) => $q->where('id', '!=', $ignoreProductId))
                ->exists()
        ) {
            $slug = $original.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function importGallery(Product $product, string $gallery): void
    {
        $items = preg_split('/[|;]/', $gallery) ?: [];
        $sortOrder = 0;

        foreach ($items as $item) {
            $item = trim($item);

            if ($item === '') {
                continue;
            }

            if (! str_contains($item, ':')) {
                throw new \InvalidArgumentException('gallery items must use format type:path (e.g. image:products/gallery/file.jpg).');
            }

            [$type, $path] = explode(':', $item, 2);
            $type = strtolower(trim($type));
            $path = trim($path);

            if (! in_array($type, ['image', 'video'], true) || $path === '') {
                throw new \InvalidArgumentException('Invalid gallery item: "'.$item.'".');
            }

            $sortOrder++;

            ProductMedia::create([
                'product_id' => $product->id,
                'type' => $type,
                'path' => $path,
                'sort_order' => $sortOrder,
            ]);
        }
    }

    private function nullable(string $value): ?string
    {
        return $value !== '' ? $value : null;
    }
}
