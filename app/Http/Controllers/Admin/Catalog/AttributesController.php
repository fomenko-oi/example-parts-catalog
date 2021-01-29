<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Entity\Catalog\Attribute;
use App\Model\Catalog\Entity\Category\Attribute\Attribute as AttributeItem;
use App\Entity\Catalog\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Category\Attribute\CreateRequest;
use App\Model\Catalog\Category\Repository\CategoryRepository;
use App\Model\Catalog\Category\UseCase\CategoryService;
use App\Model\Catalog\Entity\Category\Attribute\Name;
use App\Model\Catalog\Entity\Category\Attribute\Value;
use Illuminate\Http\Request;

class AttributesController extends Controller
{
    /**
     * @var CategoryService
     */
    private CategoryService $categoryService;
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categories;

    public function __construct(CategoryService $categoryService, CategoryRepository $categories)
    {
        $this->categoryService = $categoryService;
        $this->categories = $categories;
    }

    public function edit(int $category, Attribute $attribute)
    {
        $category = $this->categories->getById($category);
        $types = Attribute::getTypesList();
        $langs = ['ru' => 'Ru', 'en' => 'En'];

        return view('admin.catalog.category.attribute.edit', compact('attribute', 'category', 'types', 'langs'));
    }

    public function destroy(int $category, Attribute $attribute)
    {
        try {
            $attribute->delete();

            return redirect()->back()->with('success', 'Attribute successful removed.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(CreateRequest $request, int $category, Attribute $attribute)
    {
        try {
            $this->categoryService->updateAttribute(
                $attribute,
                new AttributeItem(
                    new Name($request->input('name'), $request->input('label'), $request->input('label_ru')),
                    new Value(
                        $request->input('type'),
                        $request->input('default'),
                        (bool)$request->input('required'),
                        array_map('trim', preg_split('#[\r\n]+#', $request->input('variants')))
                    ),
                    $request->input('sort'),
                    (bool)$request->input('filterable'),
                ),
                $request->input('lang')
            );

            return redirect()->route('admin.catalog.category', $category);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function store(CreateRequest $request, int $category)
    {
        $category = $this->categories->getById($category);

        $this->categoryService->createAttribute(
            $category,
            new AttributeItem(
                new Name($request->input('name'), $request->input('label'), $request->input('label_ru')),
                new Value(
                    $request->input('type'),
                    $request->input('default'),
                    (bool)$request->input('required'),
                    array_map('trim', preg_split('#[\r\n]+#', $request->input('variants')))
                ),
                $request->input('sort'),
                (bool)$request->input('filterable'),
            ),
            $request->input('lang')
        );

        return redirect()->route('admin.catalog.category', [$category])->with('success', 'Attribute successful created.');
    }

    public function create(int $category)
    {
        $category = $this->categories->getById($category);
        $types = Attribute::getTypesList();
        $langs = ['ru' => 'Ru', 'en' => 'En'];

        return view('admin.catalog.category.attribute.create', compact('category', 'types', 'langs'));
    }
}
