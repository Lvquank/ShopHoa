<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;

class LocationController extends Controller
{
    public function getDistricts($provinceId)
    {
        $province = Province::find($provinceId);

        if (!$province) {
            return response()->json(['message' => 'Tỉnh/thành không tồn tại.'], 404);
        }

        // Trả về danh sách quận/huyện của tỉnh đó
        return response()->json(['districts' => $province->districts()->get()]);
    }

    public function getWards($districtId)
    {
        $district = District::find($districtId);

        if (!$district) {
            return response()->json(['message' => 'Quận/huyện không tồn tại.'], 404);
        }

        // Trả về danh sách phường/xã của quận/huyện đó
        return response()->json($district->wards()->get());
    }
}
