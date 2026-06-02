<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        'categories',
        'diamond_carat_size',
        'diamond_carat_weight',
        'row_weight',
        'polish_weight',
        'length',
        'width',
        'table_percent',
        'total_depth',
        'ratio',
        'gold_karat',
        'gold_weight',
        'gold_hallmarked',
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

    public function export()
    {
        $products = Product::with(['shape', 'color', 'clarity', 'cut', 'categories', 'media'])
            ->orderBy('id')
            ->get();

        $filename = 'products-export-'.now()->format('Y-m-d-His').'.csv';

        $callback = function () use ($products) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM so Excel opens special characters correctly
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, self::TEMPLATE_HEADERS);

            foreach ($products as $product) {
                fputcsv($handle, $this->productToExportRow($product));
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
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
            'Engagement|Loose',
            '1.02',
            '1.00 ct',
            '1.02',
            '1.00',
            '6.45',
            '6.42',
            '58',
            '61.2',
            '1.00',
            '22',
            '4.5 g',
            'yes',
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
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, self::TEMPLATE_HEADERS);
            fputcsv($handle, $sample);
            fclose($handle);
        };

        return response()->streamDownload($callback, 'product-import-template.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
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
            'categories' => $mapByName(Category::orderBy('name')->get()),
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
            'remarks' => $this->nullable($data['remarks'] ?? ''),
            'short_description' => $this->nullable($data['short_description'] ?? ''),
            'long_description' => $this->nullable($data['long_description'] ?? ''),
            'meta_title' => $this->nullable($data['meta_title'] ?? ''),
            'meta_description' => $this->nullable($data['meta_description'] ?? ''),
            'meta_keywords' => $this->nullable($data['meta_keywords'] ?? ''),
            'status' => $this->resolveStatus($data['status'] ?? ''),
        ];

        $productData = $this->mergeOptionalImportFields($productData, $data);

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

        if (array_key_exists('categories', $data)) {
            $product->categories()->sync(
                $this->resolveCategoryIds($data['categories'], $lookups['categories'])
            );
        }

        $gallery = $data['gallery'] ?? '';

        if ($gallery !== '' && $action === 'created') {
            $this->importGallery($product, $gallery);
        }

        return $action;
    }

    private function resolveCategoryIds(string $value, array $lookup): array
    {
        if ($value === '') {
            return [];
        }

        $names = preg_split('/[|,;]/', $value) ?: [];
        $ids = [];

        foreach ($names as $name) {
            $name = trim($name);

            if ($name === '') {
                continue;
            }

            $key = strtolower($name);

            if (! isset($lookup[$key])) {
                throw new \InvalidArgumentException('Unknown category: "'.$name.'".');
            }

            $ids[] = $lookup[$key];
        }

        return array_values(array_unique($ids));
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

    private function resolveGoldHallmarked(string $value): bool
    {
        $value = strtolower(trim($value));

        return in_array($value, ['1', 'yes', 'true', 'y'], true);
    }

    private function mergeOptionalImportFields(array $productData, array $data): array
    {
        $nullableStringFields = [
            'diamond_carat_size',
            'diamond_carat_weight',
            'row_weight',
            'polish_weight',
            'length',
            'width',
            'table_percent',
            'total_depth',
            'ratio',
            'gold_karat',
            'gold_weight',
        ];

        foreach ($nullableStringFields as $field) {
            if (array_key_exists($field, $data)) {
                $productData[$field] = $this->nullable($data[$field]);
            }
        }

        if (array_key_exists('gold_hallmarked', $data)) {
            $productData['gold_hallmarked'] = $this->resolveGoldHallmarked($data['gold_hallmarked']);
        }

        return $productData;
    }

    private function productToExportRow(Product $product): array
    {
        return [
            $product->name ?? '',
            $product->stone_id ?? '',
            $product->slug ?? '',
            $product->shape?->name ?? '',
            $product->color?->name ?? '',
            $product->clarity?->name ?? '',
            $product->cut?->name ?? '',
            $product->categories->pluck('name')->filter()->implode('|'),
            $product->diamond_carat_size ?? '',
            $product->diamond_carat_weight ?? '',
            $product->row_weight ?? '',
            $product->polish_weight ?? '',
            $product->length ?? '',
            $product->width ?? '',
            $product->table_percent ?? '',
            $product->total_depth ?? '',
            $product->ratio ?? '',
            $product->gold_karat ?? '',
            $product->gold_weight ?? '',
            $product->gold_hallmarked ? 'yes' : 'no',
            $product->remarks ?? '',
            $product->short_description ?? '',
            $product->long_description ?? '',
            $product->meta_title ?? '',
            $product->meta_description ?? '',
            $product->meta_keywords ?? '',
            $product->status ?? 'active',
            $product->featured_type ?? '',
            $product->featured_path ?? '',
            $this->formatGalleryForExport($product),
        ];
    }

    private function formatGalleryForExport(Product $product): string
    {
        return $product->media
            ->map(fn (ProductMedia $media) => strtolower($media->type).':'.$media->path)
            ->implode('|');
    }
}
