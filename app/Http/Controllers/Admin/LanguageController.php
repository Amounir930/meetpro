<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $languages = Language::orderBy('id', 'DESC');

        $isFiltered = false;

        // Set filter array for code, name and direction
        $filters = [
            'code' => $request->code,
            'name' => $request->name,
            'direction' => $request->direction,
        ];

        // Filter languages by status
        $status = $request->status;
        if ($status) {
            $languages->where('status', $status);
            $isFiltered = true;
        }

        // Filter by code , name and firection
        foreach ($filters as $column => $value) {
            if ($value) {
                $languages->where($column, 'like', '%' . $value . '%');
                $isFiltered = true;
            }
        }

        $languages = $languages->paginate(config('app.pagination'))->withQueryString();

        return view('admin.language.index', [
            'pageTitle' => __('Languages'),
            'languages' => $languages,
            'filters' => $filters,
            'status' => $status,
            'isFiltered' => $isFiltered,
        ]);
    }

    // Show create language form
    public function create(Request $request)
    {
        return view('admin.language.create', ['pageTitle' => __('Create Language')]);
    }

    // Store the details of new language
    public function store(CreateLanguageRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $file = $request->file;

        if ($file && $file->isValid()) {

            // Show error if status is inactive and default language is set to "yes"
            if ($request->default == "yes" && $request->status == "inactive") {
                return redirect()->route('admin.language')->with('error', __('The default language can not be inactive.'));
            }

            // If a new default language is set to "yes," update the previous default language to "no."
            if ($request->default == 'yes') {
                Language::where(['default' => 'yes'])->update(['default' => 'no']);
            }

            // Create new language
            $language = new Language();
            $language->code = $request->code;
            $language->name = $request->name;
            $language->direction = $request->direction;
            $language->default = $request->default;
            $language->status = $request->status;

            $language->save();

            // Store the file in resources/lang
            $destinationPath = base_path('resources/lang');
            $fileName = $request->code . '.json';
            $file->move($destinationPath, $fileName);

            Cache::forget('languages');
            Cache::forget('defaultLangauage');

            return redirect()->route('admin.language')->with('message', __('Language created Successfully.'));
        }
        return redirect()->route('admin.language')->with('error', __('The given file is not valid.'));
    }

    // Show edit language form
    public function edit($id)
    {
        $language = Language::findOrFail($id);

        return view('admin.language.edit', [
            'pageTitle' => __('Edit Language'),
            'language' => $language,
        ]);
    }

    // Update language and update the file if available
    public function update(UpdateLanguageRequest $request, $id)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $language = Language::find($id);
        $file = $request->file;

        // Show error if status is inactive and default language is set to "yes"
        if ($request->default == "yes" && $request->status == "inactive") {
            return redirect()->route('admin.language')->with('error', __('The default language can not be inactive.'));
        }

        // Show error if the default language is updated to "no" because its mandatory to have one default language
        if ($language->default == "yes" && $request->default == "no") {
            return redirect()->route('admin.language')->with('error', __('There must be at least one default language.'));
        }

        // If a new default language is set to "yes," update the previous default language to "no."
        if ($language->default == 'no' && $request->default == 'yes') {
            Language::where(['default' => 'yes'])->update(['default' => 'no']);
        }

        // Update language
        $language->direction = $request->direction;
        $language->default = $request->default;
        $language->status = $request->status;
        $language->save();

        Cache::forget('languages');
        Cache::forget('defaultLangauage');

        // If file is updated then unlink the previous file and store a new file
        if ($file) {
            $destinationPath = base_path('resources/lang');
            $fileName = $language->code . '.json';
            $fullFilePath = $destinationPath . '/' . $fileName;
            unlink($fullFilePath);
            $file->move($destinationPath, $fileName);
        }

        return redirect()->route('admin.language')->with('message', __('Language updated Successfully.'));
    }

    // Soft delete language
    public function delete($id)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $language = Language::findOrFail($id);
        $language->delete();

        // Delete file stored in resources/lang
        $filePath = base_path('resources/lang/' . $language->code . '.json');
        unlink($filePath);

        Cache::forget('languages');
        Cache::forget('defaultLangauage');

        return redirect()->route('admin.language')->with('message', __('Language Deleted Successfully.'));
    }

    public function downloadEnglish()
    {
        $filePath = base_path('/public/sources/en-sample.json');

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return response()->json(['error' => 'File not found.'], 404);
    }

    //download language file
    public function downloadFile($code)
    {
        $filePath = base_path('resources/lang/' . $code . '.json');

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return response()->json(['error' => 'File not found.'], 404);
    }
}
