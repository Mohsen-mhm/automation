<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\AboutUsUpdateRequest;
use App\Models\AboutUs;
use App\Services\AboutUsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AboutUsController extends Controller
{
    public function __construct(
        private AboutUsService $aboutUsService
    )
    {
    }

    /**
     * Display the about us page
     */
    public function index()
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(AboutUs::ABOUT_US_INDEX), 403);

        $aboutUs = $this->aboutUsService->getAboutUs();
        abort_if(!$aboutUs, 404);

        return view('panel.about-us.index', compact('aboutUs'));
    }

    /**
     * Show the form for editing the about us content
     */
    public function edit()
    {
        abort_if(!Gate::allows(AboutUs::ABOUT_US_EDIT), 403);

        $aboutUs = $this->aboutUsService->getAboutUs();
        abort_if(!$aboutUs, 404);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $aboutUs
            ]);
        }

        return view('panel.about-us.edit', compact('aboutUs'));
    }

    /**
     * Update the about us content
     */
    public function update(AboutUsUpdateRequest $request)
    {
        try {
            $aboutUs = $this->aboutUsService->getAboutUs();
            abort_if(!$aboutUs, 404);

            $success = $this->aboutUsService->updateAboutUs($aboutUs, $request->validated(), $request->file('image'));

            if (!$success) {
                throw new \Exception('خطا در ثبت اطلاعات');
            }

            $message = 'محتوا با موفقیت به‌روزرسانی شد.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'data' => $aboutUs->fresh()
                ]);
            }

            return redirect()->route('panel.about.us')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('About Us update error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در ثبت اطلاعات'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'خطا در ثبت اطلاعات')
                ->withInput();
        }
    }

    /**
     * Upload image for about us
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        try {
            $imagePath = $this->aboutUsService->uploadImage($request->file('image'));

            return response()->json([
                'success' => true,
                'message' => 'تصویر با موفقیت آپلود شد',
                'path' => $imagePath,
                'url' => asset($imagePath)
            ]);

        } catch (\Exception $e) {
            \Log::error('Image upload error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در آپلود تصویر'
            ], 500);
        }
    }
}
