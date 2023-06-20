<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Package;
use App\Models\Vendor;

class PackageService
{
    protected $package;

    public function __construct()
    {
        $this->package =new Package();
    }

    public function all($request)
    {
        return $this->package->with('features')->get();
    }

    public function find($request)
    {
        return $this->package->with('features')->findOrFail($request->id);
    }

    public function create($request)
    {
        return $this->package->create($request->all());
    }

    public function update($request)
    {
        return tap($this->package->findOrFail($request->id)->update($request->all()));
    }

    public function delete($request)
    {
        return $this->package->findOrFail($request->id)->delete();
    }
    public function addVendorPackage($request)
    {
       $vendor = Vendor::findOrFail($request->vendor_id);
       $vendor->update([
        'package_id' => $request->package_id,
       ]);
       return $vendor;
    }
    public function addVendorFeatures($request)
    {
       $vendor = Vendor::findOrFail($request->vendor_id);
       $features = $request->features;
       foreach($features as $feature){

        $vendor->features()->attach(
            $feature['feature_id'],
            ['content' => $feature['content']]
        );
       }
       return $vendor->with('features');
    }
}
