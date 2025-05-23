<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{

    // public function __construct()
    // {
    //     $this->checkAdminAccess();
    // }

    // /**
    //  * Check if the authenticated user is a midwife with admin role
    //  */
    // private function checkAdminAccess()
    // {
    //     // Check if user is authenticated as midwife
    //     if (!Auth::guard('midwife')->check()) {
    //         abort(403, 'Unauthorized access');
    //     }

    //     // Check if midwife has admin role
    //     $midwife = Auth::guard('midwife')->user();

    //     // Check if role field exists, is not null, and is set to 'admin'
    //     if (!isset($midwife->role) || $midwife->role === null || empty($midwife->role) || $midwife->role !== 'admin') {
    //         abort(403, 'Admin access required');
    //     }
    // }
    /**
     * Display a listing of the content.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
{
    $contents = Content::orderBy('created_at', 'desc')->paginate(10);
    return view('admin.menu3', compact('contents'));
}


    /**
     * Store a newly created content in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'url' => 'required|url',
            'category' => 'required|in:nutrition,exercise,health_tips',
            'description' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $filename = 'content-' . time() . '.' . $thumbnail->getClientOriginalExtension();
            $path = $thumbnail->storeAs('content-thumbnails', $filename, 'public');
            $validatedData['thumbnail'] = $path;
        }

        Content::create($validatedData);

        return redirect()->route('content.index')
            ->with('success', 'Content created successfully.');
    }

    /**
     * Update the specified content in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
   public function updateContent(Request $request, $id)
{
    try {
        // Find the content
        $content = Content::where('content_id', $id)->firstOrFail();

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'url' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'thumbnail' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Changed to handle file upload
        ]);

        // Return error if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle thumbnail upload
        $thumbnailPath = $content->thumbnail; // Keep existing thumbnail as default

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($content->thumbnail && Storage::disk('public')->exists($content->thumbnail)) {
                Storage::disk('public')->delete($content->thumbnail);
            }

            // Store new thumbnail
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = time() . '_' . uniqid() . '.' . $thumbnailFile->getClientOriginalExtension();
            $thumbnailPath = $thumbnailFile->storeAs('thumbnails', $thumbnailName, 'public');
        }

        // Update content with validated data
        $content->fill($request->only([
            'title',
            'url',
            'category',
            'description',
        ]));

        // Update thumbnail path
        $content->thumbnail = $thumbnailPath;

        // Save the updated content
        $content->save();

        // Prepare response data with full thumbnail URL
        $responseData = $content->toArray();
        if ($content->thumbnail) {
            $responseData['thumbnail_url'] = asset('storage/' . $content->thumbnail);
        }

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Content updated successfully',
            'data' => $responseData
        ], 200);

    } catch (\Exception $e) {
        // Log the error
        \Log::error('Error updating content: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while updating content',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Remove the specified content from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $content = Content::findOrFail($id);

        // Delete thumbnail if exists
        if ($content->thumbnail && Storage::disk('public')->exists($content->thumbnail)) {
            Storage::disk('public')->delete($content->thumbnail);
        }

        $content->delete();

        return back()->with('success', 'Content deleted successfully.');
    }
}
