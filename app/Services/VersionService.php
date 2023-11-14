<?php

namespace App\Services;

use App\Enum\ResponseCodeEnum;
use App\Enum\StatusUserEnum;
use App\Http\Requests\CheckNewVersionRequest;
use App\Models\Version;
use App\Response\Model\ResponseObject;
use Illuminate\Support\Facades\Auth;

class VersionService extends BaseService
{
    public function checkNewVersion(CheckNewVersionRequest $checkNewVersionRequest)
    {
        $currentVersion = Version::where('version', $checkNewVersionRequest->last_update)->first();

        if (!$currentVersion) {
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9994);
            return $this->responseData($responseError);
        }

        $newestVersion = Version::orderByDesc('id')->first();
        $user = Auth::user();

        $data['version'] = [
            'version' => $newestVersion->version,
            'require' => $newestVersion->version != $currentVersion->version,
            'url' => "Lmao",
        ];

        $data['user'] = [
            'id' => $user->id,
            'active' => $user->status_user == StatusUserEnum::ACTIVE,
        ];

        $data['badge'] = 99;
        $data['unread_message'] = 99;

        $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data);
        return $this->responseData($response);
    }
}
