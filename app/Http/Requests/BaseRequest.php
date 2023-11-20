<?php

namespace App\Http\Requests;

use App\Enum\ResponseCodeEnum;
use App\Response\Model\ResponseObject;
use App\Rules\DevTokenRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                $this->filterErrorCode(array_keys(collect($validator->failed())->first())[0])
            )
        );
    }

    private function filterErrorCode(string $validationError): array
    {
        switch ($validationError) {

            case "Min":
            case "Max":
            case "File":
            case "Array":
            case "App\Rules\EmailRule":
            case "App\Rules\UsernameRule":
            case "App\Rules\ImageUploadRule":
            case "App\Rules\VideoUploadRule":
            case "App\Rules\ChangePasswordRequest":
            case "App\Rules\LatitudeRule":
            case "App\Rules\LongitudeRule":
            case "App\Rules\DevTokenRule":
                $errorCode = ResponseCodeEnum::CODE_1004;
                break;

            case "String":
            case "Integer":
                $errorCode = ResponseCodeEnum::CODE_1003;
                break;

            case "Required":
                $errorCode = ResponseCodeEnum::CODE_1002;
                break;

            default:
                $errorCode = ResponseCodeEnum::CODE_9999;
                break;
        }

        $responseError = new ResponseObject($errorCode);

        return $responseError->toArray();
    }
}
