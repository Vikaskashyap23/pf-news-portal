<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Category;
use App\Models\Website;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'super_admin') {

            $categories = Category::with('website')
                ->latest()
                ->get();

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */
        } elseif ($currentUser->role === 'admin') {

            if (!$currentUser->website_id) {
                $categories = Category::whereRaw('1 = 0')
                    ->get();
            } else {
                $categories = Category::with('website')
                    ->where(
                        'website_id',
                        $currentUser->website_id
                    )
                    ->latest()
                    ->get();
            }

        } else {

            abort(403, 'Unauthorized access.');
        }

        return view(
            'admin.categories.index',
            compact('categories')
        );
    }


    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | WEBSITE LIST
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'super_admin') {

            $websites = Website::orderBy('name')->get();

        } elseif ($currentUser->role === 'admin') {

            if (!$currentUser->website_id) {
                abort(
                    403,
                    'Your account is not assigned to any website.'
                );
            }

            $websites = Website::where(
                'id',
                $currentUser->website_id
            )->get();

        } else {

            abort(403, 'Unauthorized access.');
        }

        /*
        |--------------------------------------------------------------------------
        | PARENT CATEGORIES
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'super_admin') {

            $parents = Category::orderBy('name')->get();

        } else {

            $parents = Category::where(
                'website_id',
                $currentUser->website_id
            )
                ->orderBy('name')
                ->get();
        }

        return view(
            'admin.categories.create',
            compact(
                'websites',
                'parents'
            )
        );
    }


    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([
            'website_id' => [
                'required',
                'integer',
                'exists:websites,id',
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | WEBSITE SECURITY
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'admin') {

            if (!$currentUser->website_id) {
                abort(
                    403,
                    'Your account is not assigned to any website.'
                );
            }

            /*
             * Ignore website_id submitted by Admin.
             * Always use Admin's assigned website.
             */
            $websiteId = $currentUser->website_id;

        } elseif ($currentUser->role === 'super_admin') {

            $websiteId = $validated['website_id'];

        } else {

            abort(403, 'Unauthorized access.');
        }

        /*
        |--------------------------------------------------------------------------
        | PARENT CATEGORY SECURITY
        |--------------------------------------------------------------------------
        */
        $parentId = $validated['parent_id'] ?? null;

        if ($parentId) {

            $parent = Category::findOrFail($parentId);

            /*
             * Parent category must belong to the same website.
             */
            if (
                (int) $parent->website_id !==
                (int) $websiteId
            ) {
                abort(
                    403,
                    'Parent category must belong to the same website.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SLUG
        |--------------------------------------------------------------------------
        */
        $slugExists = Category::where(
            'slug',
            $validated['slug']
        )
            ->where(
                'website_id',
                $websiteId
            )
            ->exists();

        if ($slugExists) {
            return back()
                ->withErrors([
                    'slug' =>
                        'This category slug already exists for this website.'
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */
        Category::create([
            'website_id' => $websiteId,

            'parent_id' => $parentId,

            'name' => $validated['name'],

            'slug' => $validated['slug'],

            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Category Created Successfully.'
            );
    }


    /**
     * Display the specified category.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        $this->authorizeCategoryAccess($category);

        return view(
            'admin.categories.show',
            compact('category')
        );
    }


    /**
     * Show the form for editing a category.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        $this->authorizeCategoryAccess($category);

        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | WEBSITE
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'super_admin') {

            $websites = Website::orderBy('name')->get();

        } else {

            $websites = Website::where(
                'id',
                $currentUser->website_id
            )->get();
        }

        /*
        |--------------------------------------------------------------------------
        | PARENT CATEGORIES
        |--------------------------------------------------------------------------
        */
        $parentsQuery = Category::where(
            'id',
            '!=',
            $category->id
        );

        if ($currentUser->role === 'admin') {

            $parentsQuery->where(
                'website_id',
                $currentUser->website_id
            );

        } else {

            /*
             * Super Admin can edit category website,
             * so parent list can contain categories from
             * the selected website only after selection in UI.
             *
             * For safety, initially show same-website parents.
             */
            $parentsQuery->where(
                'website_id',
                $category->website_id
            );
        }

        $parents = $parentsQuery
            ->orderBy('name')
            ->get();

        return view(
            'admin.categories.edit',
            compact(
                'category',
                'websites',
                'parents'
            )
        );
    }


    /**
     * Update category.
     */
    public function update(
        Request $request,
        string $id
    ) {
        $category = Category::findOrFail($id);

        $this->authorizeCategoryAccess($category);

        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([
            'website_id' => [
                'required',
                'integer',
                'exists:websites,id',
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | WEBSITE SECURITY
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'admin') {

            if (!$currentUser->website_id) {
                abort(
                    403,
                    'Your account is not assigned to any website.'
                );
            }

            /*
             * Admin cannot move category to another website.
             */
            $websiteId = $currentUser->website_id;

        } elseif ($currentUser->role === 'super_admin') {

            $websiteId = $validated['website_id'];

        } else {

            abort(403, 'Unauthorized access.');
        }

        /*
        |--------------------------------------------------------------------------
        | PARENT CATEGORY SECURITY
        |--------------------------------------------------------------------------
        */
        $parentId = $validated['parent_id'] ?? null;

        if ($parentId) {

            /*
             * Category cannot be its own parent.
             */
            if ((int) $parentId === (int) $category->id) {
                return back()
                    ->withErrors([
                        'parent_id' =>
                            'A category cannot be its own parent.'
                    ])
                    ->withInput();
            }

            $parent = Category::findOrFail($parentId);

            /*
             * Parent must belong to the same website.
             */
            if (
                (int) $parent->website_id !==
                (int) $websiteId
            ) {
                abort(
                    403,
                    'Parent category must belong to the same website.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SLUG SECURITY
        |--------------------------------------------------------------------------
        */
        $slugExists = Category::where(
            'slug',
            $validated['slug']
        )
            ->where(
                'website_id',
                $websiteId
            )
            ->where(
                'id',
                '!=',
                $category->id
            )
            ->exists();

        if ($slugExists) {
            return back()
                ->withErrors([
                    'slug' =>
                        'This category slug already exists for this website.'
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */
        $category->update([
            'website_id' => $websiteId,

            'parent_id' => $parentId,

            'name' => $validated['name'],

            'slug' => $validated['slug'],

            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Category Updated Successfully.'
            );
    }


    /**
     * Delete category.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $this->authorizeCategoryAccess($category);

        /*
        |--------------------------------------------------------------------------
        | CHILD CATEGORY CHECK
        |--------------------------------------------------------------------------
        */
        if ($category->children()->exists()) {

            return redirect()
                ->route('categories.index')
                ->with(
                    'error',
                    'This category cannot be deleted because it has child categories.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | NEWS CHECK
        |--------------------------------------------------------------------------
        */
        if ($category->news()->exists()) {

            return redirect()
                ->route('categories.index')
                ->with(
                    'error',
                    'This category cannot be deleted because news is assigned to it.'
                );
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Category Deleted Successfully.'
            );
    }


    /**
     * Check whether current user can access category.
     */
    private function authorizeCategoryAccess(
        Category $category
    ): void {
        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'super_admin') {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'admin') {

            if (!$currentUser->website_id) {

                abort(
                    403,
                    'Your account is not assigned to any website.'
                );
            }

            if (
                (int) $category->website_id !==
                (int) $currentUser->website_id
            ) {
                abort(
                    403,
                    'You do not have access to this website category.'
                );
            }

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | OTHER ROLES
        |--------------------------------------------------------------------------
        */
        abort(
            403,
            'Unauthorized access.'
        );
    }
}

