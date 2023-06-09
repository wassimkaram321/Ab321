<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Category;
use App\Models\Day;
use App\Models\SubCategory;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VendorService
{
    protected $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function all($request = null)
    {


        $query = $this->vendor->withCount('favoriteUsers');

        if ($request->all()) {
            $query = $this->applyQueryFilters($query, $request);
            return $query->app();
        }

        return $query->app();
    }

    public function find($request)
    {


        $vendor = $this->vendor
            ->with([
                'days', 'category', 'subCategories', 'socialMedia', 'features',
                'banners' => function ($query) {
                    $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")->active();

                }
            ])
            ->withCount('favoriteUsers')
            ->app()
            ->where('id', $request->id)
            ->first();

        $result = [
            'vendor' => $vendor,
            'recomindation'=>[]
        ];

        if ($request->recomindation == 1) {
            $recomindation = $this->recomendation($request);
            $recomindationArray = $recomindation->toArray();
            $reindexedRecomindation = array_values($recomindationArray);
            $result['recomindation'] = $reindexedRecomindation;
        }

        $mergedData = array_merge($result['vendor']->toArray(), ['recomindation' => $result['recomindation']]);

        return $mergedData;
    }

    public function create($request)
    {
        $subCategories = $request->subcategories ?? [];
        $vendor = $this->vendor->create($request->all());
        if($subCategories != [])
            $vendor->subcategories()->attach($subCategories);
        if (isset($request->days)) {
            foreach ($request->days as $day) {
                $vendor->days()->attach([$day['day_id'] => ['open_at' => $day['open_at'], 'close_at' => $day['close_at']]]);
            }
        }
        if (isset($request->social_media)) {
            foreach ($request->social_media as $social_media) {
                $vendor->socialMedia()->attach([$social_media['id'] => ['link' => $social_media['link']]]);
            }
        }

        if ($request->has('image')) {
            $file_name = FileHelper::addFile($request->image,'images/vendors');
            $vendor->image = $file_name;
            $vendor->save();
        }
        return $vendor;
    }

    public function update($request)
    {
        $subCategories = $request->subcategories ?? [];
        $vendor = $this->vendor->findOrFail($request->id);
        if ($request->has('image')) {
            $vendor->update($request->all());
            $file_name = FileHelper::addFile($request->image);
            $vendor->image = $file_name;
            $vendor->save();
        }
        $vendor->subcategories()->detach();
        $vendor->subcategories()->attach($subCategories);
        if (isset($request->days)) {
            foreach ($request->days as $day) {
                if (
                    $vendor
                    ->days()
                    ->where('days.id', $day['day_id'])
                    ->exists()
                ) {
                    $vendor->days()->updateExistingPivot($day['day_id'], ['open_at' => $day['open_at'], 'close_at' => $day['close_at']]);
                } else {
                    $vendor->days()->attach([$day['day_id'] => ['open_at' => $day['open_at'], 'close_at' => $day['close_at']]]);
                }
            }
            // Remove days that are not included in the days array
            $existingDays = $vendor
                ->days()
                ->pluck('days.id')
                ->toArray();
            $daysToRemove = array_diff($existingDays, array_column($request->days, 'day_id'));

            if (!empty($daysToRemove)) {
                $vendor->days()->detach($daysToRemove);
            }
        }

        if (isset($request->social_media)) {
            foreach ($request->social_media as $social_media) {
                if (
                    $vendor
                    ->socialMedia()
                    ->where('social_media.id', $social_media['id'])
                    ->exists()
                ) {
                    $vendor->socialMedia()->updateExistingPivot($social_media['id'], ['link' => $social_media['link']]);
                } else {
                    $vendor->socialMedia()->attach([$social_media['id'] => ['link' => $social_media['link']]]);
                }
            }
            // Remove midea that are not included in the days array
            $existingMedia = $vendor
                ->socialMedia()
                ->pluck('social_media.id')
                ->toArray();
            $MediaToRemove = array_diff($existingMedia, array_column($request->social_media, 'id'));

            if (!empty($MediaToRemove)) {
                $vendor->socialMedia()->detach($MediaToRemove);
            }
        }

        return $vendor;
    }

    public function delete($request)
    {
        $this->vendor->findOrFail($request->id)->delete();
    }
    public function changeStatus($request)
    {
        $vendor = $this->vendor->findOrFail($request->id);
        $vendor->update([
            'is_active' => $request->is_active,
        ]);
        if($vendor->register == 1){
            $vendor->update([
                'register' => 0,
            ]);
        }
    }
    public function addImage($vendor, $image)
    {
        $vendor->image = $image->getClientOriginalName();
        $vendor->save();
    }
    public function getCategoryVendors($request)
    {
        $category = Category::findOrFail($request->category_id);
        return $category->vendors;
    }
    public function search($request)
    {
        $keyword = $request->input('keyword');
        if ($request->has('category_id')) {
            $category_vendors = Vendor::with(['category', 'subCategories', 'features'])
                ->where('category_id', $request->category_id)
                ->where(function ($query) use ($keyword) {
                    $query
                        ->where('name', 'like', "%$keyword%")
                        ->orWhere('name_ar', 'like', "%$keyword%")
                        ->orWhere('description', 'like', "%$keyword%")
                        ->orWhere('description_ar', 'like', "%$keyword%");
                })

                ->app();

            return $category_vendors;
        } elseif ($request->has('subcategory_id')) {
            $subcategory_vendors = Vendor::with(['category', 'subCategories', 'features'])
                ->whereHas('subCategories', function ($query) use ($keyword, $request) {
                    $query->where('sub_categories.id', $request->subcategory_id);
                })
                ->where(function ($query) use ($keyword) {
                    $query
                        ->where('name', 'like', "%$keyword%")
                        ->orWhere('name_ar', 'like', "%$keyword%")
                        ->orWhere('description', 'like', "%$keyword%")
                        ->orWhere('description_ar', 'like', "%$keyword%");
                })

                ->app();
            return $subcategory_vendors;
        } else {
            $vendors = Vendor::with(['category', 'subCategories', 'features'])

                ->where(function ($query) use ($keyword) {
                    $query
                        ->where('name', 'like', "%$keyword%")
                        ->orWhere('name_ar', 'like', "%$keyword%")
                        ->orWhere('description', 'like', "%$keyword%")
                        ->orWhere('description_ar', 'like', "%$keyword%");
                })

                ->app();

            $categoryVendors = Vendor::with(['category', 'subCategories', 'features'])
                ->whereHas('category', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%$keyword%")->orWhere('name_ar', 'like', "%$keyword%");
                })

                ->app();

            $subcategoryVendors = Vendor::with(['category', 'subCategories', 'features'])
                ->whereHas('subCategories', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%$keyword%")->orWhere('name_ar', 'like', "%$keyword%");
                })

                ->app();

            $featureVendors = Vendor::with(['category', 'subCategories', 'features'])
                ->whereHas('features', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%$keyword%")->orWhere('name_ar', 'like', "%$keyword%");
                })

                ->app();
            $results = $vendors
                ->merge($categoryVendors)
                ->merge($subcategoryVendors)
                ->merge($featureVendors)
                ->unique('id')
                ->values();

            return $results;
        }
    }

    private function applyQueryFilters($query, $request)
    {
        $query->where(function ($query) use ($request) {


            if ($request->has('subcategories')) {
                $subcategories = $request->subcategories;
                $query->whereHas('subCategories', function ($query) use ($subcategories) {
                    $query->whereIn('sub_categories.id', $subcategories);
                });
            }
            if ($request->category_id != null) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->features !=null) {
                $features = $request->features;
                $query->whereHas('features', function ($query) use ($features) {
                    $query->whereIn('features.id', $features);
                });
            }
            if ($request->rate!=null) {
                $query->where('avg_rating', $request->rate);
            }
            if ($request->latitude!=null && $request->longitude!=null) {
                $latitude = $request->latitude;
                $longitude = $request->longitude;
                $radius = 5;

                $query->whereRaw('ST_Distance_Sphere(point(longitude, latitude), point(?, ?)) <= ?', [$longitude, $latitude, $radius * 1000]);
            }
        });
        return $query;
    }

    public function recomendation($request)
    {
        $vendor = $this->vendor->with(['subCategories'])->findOrFail($request->id);
        $subcategories = $vendor->subcategories;
        $vendors = Vendor::where('id', '!=', $request->id)
            ->whereIn('id', function ($query) use ($subcategories) {
                $query
                    ->select('vendor_id')
                    ->from('sub_category_vendor')
                    ->whereIn('sub_category_id', $subcategories->pluck('id'));
            })
            ->orderByDesc('visits')
            ->take(5)
            ->get();

        return $vendors;
    }
    public function register($request)
    {
        $request->merge(['register'=>1]);
        $vendor = $this->vendor->create($request->all());
        $request->merge(['vendor_id'=>$vendor->id]);
        (new PackageService())->addVendorFeatures($request);
        return $vendor;
    }
    public function registration($request)
    {
        return $this->vendor->where('register',1)->get();
    }
}
