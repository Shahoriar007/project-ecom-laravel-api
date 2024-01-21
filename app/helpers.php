<?php

use Carbon\Carbon;
use App\Models\File;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

if (!function_exists('message')) {
    /**
     * Message response for the API
     *
     * @param string $message Message to return
     * @param int $statusCode Response code
     * @return \Illuminate\Http\JsonResponse
     */
    function message($message = "Operation successful", $statusCode = 200, $data = [])
    {
        return response()->json(['message' => $message, 'data' => $data, 'status' => $statusCode], $statusCode);
    }
}


if (!function_exists('image')) {
    /**
     * Image URL generating
     *
     * @param mixed $file File including path
     * @param string $name Default name to create placeholder image
     * @return string URL of the file
     */
    function image($file, $name = 'Avatar')
    {
        if (Storage::exists($file))
            $url = asset('uploads/' . $file);
        else
            $url = 'https://i2.wp.com/ui-avatars.com/api/' . Str::slug($name) . '/400';

        return $url;
    }
}

if (!function_exists('uploadFile')) {
    /**
     * Upload a file
     *
     * @param mixed $requestFiles
     * @param string $path
     * @param mixed $remarks
     * @return mixed
     */
    function uploadFile($requestFiles, $path = '', $remarks = null)
    {
        $files = [];
        if (is_array($requestFiles))
            foreach ($requestFiles as $key => $file) {
                $ext = $file->getClientOriginalExtension();
                $size = $file->getSize() / 1024; //Convert to KB
                $loc = $file->store($path);
                $nameExt = $file->getClientOriginalName();
                $name = pathinfo($nameExt, PATHINFO_FILENAME);

                $files[$key] = File::create([
                    'file_name' => $name,
                    'file_ext' => $ext,
                    'file_size' => $size,
                    'path' => $loc,
                    'remarks' => $remarks
                ]);
            }

        else
            $files = $requestFiles->store($path);

        return $files;
    }
}


if (!function_exists('to_boolean')) {

    /**
     * Convert to boolean
     *
     * @param $booleable
     * @return boolean
     */
    function to_boolean($boolean)
    {
        return filter_var($boolean, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}

if (!function_exists('createFile')) {
    /**
     * Create a file from the request
     *
     * @param mixed $key
     * @param mixed $file
     * @param mixed $path
     */
    function createFile($key, $file, $path, $remarks)
    {
        $ext = $file->getClientOriginalExtension();
        $size = $file->getSize() / 1024; //Convert to KB
        $loc = $file->store($path);
        $nameExt = $file->getClientOriginalName();
        $name = pathinfo($nameExt, PATHINFO_FILENAME);

        $files[$key] = File::create([
            'file_name' => $name,
            'file_ext' => $ext,
            'file_size' => $size,
            'path' => $loc,
            'remarks' => $remarks
        ]);
    }
}

if (!function_exists('user')) {

    /**
     * Get the authenticated user instance
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function user()
    {
        return auth()->user();
    }
}

if (!function_exists('access')) {
    /**
     * Check whether the user has access to the endpoint
     *
     * @param string $permission
     * @return bool
     */
    function access($permission)
    {
        $user = user();

        if ($user->hasRole('Admin'))
            return true;

        if ($user->can($permission))
            return true;

        return false;
    }
}

if (!function_exists('getDirtyFields')) {

    function getDirtyFields($model, $fields = [])
    {
        $new = collect($model->getDirty());
        $old = collect($model->getOriginal());

        if (count($fields)) {
            $new = $new->only($fields);
            $old = $old->only($new->keys());
        }

        $old = $old->toArray();
        $new = $new->toArray();

        return [
            'old' => $old,
            'new' => $new,
        ];
    }
}

if (!function_exists('settings')) {
    function settings()
    {
        return Setting::all()->map(fn ($d) => [
            'key' => $d->key,
            'value' => $d->value
        ]);
    }
}

if (!function_exists('setting')) {
    function setting($key)
    {
        return Setting::find($key)->value ?? null;
    }
}


if (!function_exists('validatorErrorsToArray')) {
    function validatorErrorsToArray($errors): array
    {
        $array = [];
        foreach (collect($errors) as $key => $error) {
            $array[$key] = $error;
        }
        return $array;
    }
}



if (!function_exists('diffHoursToMinutes')) {
    function diffHoursToMinutes($to_time, $from_time): float
    {
        $today_check_in = Carbon::parse($to_time);
        $check_out = Carbon::parse($from_time);
        $duration = $today_check_in->diff($check_out)->format('%H:%I:%S');
        $time = explode(':', $duration);
        return ($time[0] * 60) + ($time[1]) + ($time[2] / 60);
    }
}

if (!function_exists('diffDate')) {
    function diffDate($to_time, $from_time): int
    {
        $startDate = Carbon::parse($to_time);
        $endDate = Carbon::parse($from_time);
        $duration = $startDate->diff($endDate)->format("%a");
        return $duration;
    }
}

if (!function_exists('diffTime')) {
    function diffTime($to_time, $from_time)
    {
        $startTime = strtotime($to_time);
        $endTime = strtotime($from_time);
        $diff = $startTime - $endTime;
        return $diff;
    }
}

// if (!function_exists('minutesToHours')) {
//     function minutesToHours($minutes)
//     {
//         $hours = intdiv($minutes, 60) . ':' . ($minutes % 60);
//         return $hours;
//     }
// }
