<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Clarity;
use App\Models\Color;
use App\Models\Cut;
use App\Models\Page;
use App\Models\Product;
use App\Models\Shape;
use App\Support\JewelleryCategory;
use App\Support\ProductMedia;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JewelleryController extends Controller
{
    public function index(Request $request): View
    {
        $shapeId = $request->query('shape_id');
        $colorId = $request->query('color_id');
        $cutId = $request->query('cut_id');
        $clarityId = $request->query('clarity_id');
        $categoryId = $request->query('category_id');

        $shapes = Shape::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        $shapes->transform(function (Shape $shape) {
            $shape->list_image_src = $this->resolveShapeImageSrc($shape);

            return $shape;
        });

        $productsQuery = Product::query()
            ->where('status', 'active')
            ->with(['shape', 'color', 'clarity', 'cut', 'categories', 'media']);

        JewelleryCategory::scopeProducts($productsQuery);

        if (! empty($shapeId)) {
            $productsQuery->where('shape_id', $shapeId);
        }
        if (! empty($colorId)) {
            $productsQuery->where('color_id', $colorId);
        }
        if (! empty($cutId)) {
            $productsQuery->where('cut_id', $cutId);
        }
        if (! empty($clarityId)) {
            $productsQuery->where('clarity_id', $clarityId);
        }
        if (! empty($categoryId)) {
            $productsQuery->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId);
            });
        }

        $products = $productsQuery->latest()->paginate(12)->withQueryString();
        $products->getCollection()->transform(function (Product $product) {
            $media = $this->resolveListMedia($product);
            $product->list_media_src = $media['src'];
            $product->list_media_type = $media['type'];

            return $product;
        });

        return view('frontend.pages.product-catalog', [
            'page' => Page::where('slug', 'jewellery')->where('status', 'active')->first()
                ?? Page::where('slug', 'diamonds')->where('status', 'active')->firstOrFail(),
            'products' => $products,
            'shapes' => $shapes,
            'colors' => Color::query()->orderBy('name')->get(),
            'cuts' => Cut::query()->orderBy('name')->get(),
            'clarities' => Clarity::query()->orderBy('name')->get(),
            'categories' => Category::query()
                ->whereHas('products', function ($query) {
                    JewelleryCategory::scopeProducts($query);
                })
                ->orderBy('name')
                ->get(),
            'activeShapeId' => $shapeId,
            'activeColorId' => $colorId,
            'activeCutId' => $cutId,
            'activeClarityId' => $clarityId,
            'activeCategoryId' => $categoryId,
            'filterRoute' => 'jewellery',
            'hideCategoryFilter' => false,
            'hideSidebar' => true,
            'catalogLabel' => 'jewellery',
            'defaultListTitle' => 'All Jewellery',
        ]);
    }

    private function resolveListMedia(Product $product): array
    {
        if (ProductMedia::hasFeatured($product)) {
            return [
                'src' => ProductMedia::srcFromStoragePath($product->featured_path),
                'type' => $product->featured_type === 'video' ? 'video' : 'image',
            ];
        }

        return [
            'src' => ProductMedia::placeholderSrc(),
            'type' => 'image',
        ];
    }

    private function resolveShapeImageSrc(Shape $shape): ?string
    {
        if (empty($shape->image)) {
            return asset('images/home/shapes/round.png');
        }

        $normalized = ltrim(str_replace('\\', '/', $shape->image), '/');

        if (str_starts_with($normalized, 'shapes/') || str_contains($normalized, '/')) {
            return ProductMedia::srcFromStoragePath($normalized);
        }

        return asset('images/home/shapes/'.$normalized);
    }
}
