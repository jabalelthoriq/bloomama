<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function yearlyUsersReport()
    {
        try {
            // Log untuk debugging
            Log::info('Starting PDF generation');

            // Ambil data users yang sebenarnya dengan error handling
            $currentYear = Carbon::now()->year;
            
            $currentYearUsers = User::whereYear('created_at', $currentYear)->count();
            $totalUsers = User::count();

            // Data users per tahun dengan limit untuk mencegah memory issue
            $usersByYear = User::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
                ->whereNotNull('created_at')
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->limit(10) // Batasi untuk mencegah data terlalu besar
                ->get();

            // Data bulanan untuk tahun ini
            $monthlyData = collect();
            for ($month = 1; $month <= 12; $month++) {
                $count = User::whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->count();
                
                $monthlyData->push([
                    'month' => $month,
                    'month_name' => Carbon::create()->month($month)->format('F'),
                    'count' => $count
                ]);
            }

            $data = [
                'title' => 'User Registration Report ' . $currentYear,
                'generatedDate' => Carbon::now()->format('F d, Y'),
                'currentYear' => $currentYear,
                'currentYearUsers' => $currentYearUsers,
                'totalUsers' => $totalUsers,
                'usersByYear' => $usersByYear,
                'monthlyData' => $monthlyData,
            ];

            Log::info('Data prepared successfully', [
                'current_year_users' => $currentYearUsers,
                'total_users' => $totalUsers,
                'years_count' => $usersByYear->count()
            ]);

            // Coba generate PDF dengan pengaturan minimal dulu
            $pdf = Pdf::loadView('reports.yearly-users', $data);
            
            // Set paper dan options
            $pdf->setPaper('a4', 'portrait');
            
            // Set options yang minimal untuk menghindari konflik
            $pdf->setOptions([
                'isRemoteEnabled' => false,
                'isPhpEnabled' => false,
                'isJavascriptEnabled' => false,
                'defaultFont' => 'serif' // Gunakan serif yang lebih aman
            ]);

            Log::info('PDF configured successfully');

            $filename = 'user-registration-report-' . $currentYear . '.pdf';
            
            // Return sebagai response download langsung
            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('PDF Generation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return error response yang proper
            return response()->json([
                'success' => false,
                'error' => 'PDF generation failed',
                'message' => env('APP_DEBUG') ? $e->getMessage() : 'Internal server error',
                'debug' => [
                    'file' => env('APP_DEBUG') ? $e->getFile() : null,
                    'line' => env('APP_DEBUG') ? $e->getLine() : null
                ]
            ], 500);
        }
    }

    // Method untuk testing PDF dengan HTML sederhana
    public function testSimplePdf()
    {
        try {
            Log::info('Starting simple PDF test');

            $html = '<!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="UTF-8">
                        <title>Test PDF</title>
                        <style>
                            body { 
                                font-family: serif; 
                                margin: 20px; 
                                font-size: 12px;
                            }
                            .header { 
                                text-align: center; 
                                margin-bottom: 20px; 
                                border-bottom: 1px solid #000;
                                padding-bottom: 10px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="header">
                            <h1>Simple PDF Test</h1>
                        </div>
                        <p>This is a simple test PDF document.</p>
                        <p>Generated on: ' . date('Y-m-d H:i:s') . '</p>
                        <p>If you can see this, PDF generation is working correctly.</p>
                    </body>
                    </html>';

            $pdf = Pdf::loadHTML($html);
            $pdf->setPaper('a4');

            Log::info('Simple PDF generated successfully');

            return $pdf->download('simple-test.pdf');

        } catch (\Exception $e) {
            Log::error('Simple PDF Test Failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Simple PDF test failed: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk debugging - return HTML view tanpa PDF
    public function debugHtml()
    {
        try {
            $currentYear = Carbon::now()->year;
            $currentYearUsers = User::whereYear('created_at', $currentYear)->count();
            $totalUsers = User::count();

            $usersByYear = User::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
                ->whereNotNull('created_at')
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->limit(10)
                ->get();

            $monthlyData = collect();
            for ($month = 1; $month <= 12; $month++) {
                $count = User::whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->count();
                
                $monthlyData->push([
                    'month' => $month,
                    'month_name' => Carbon::create()->month($month)->format('F'),
                    'count' => $count
                ]);
            }

            $data = [
                'title' => 'User Registration Report ' . $currentYear,
                'generatedDate' => Carbon::now()->format('F d, Y'),
                'currentYear' => $currentYear,
                'currentYearUsers' => $currentYearUsers,
                'totalUsers' => $totalUsers,
                'usersByYear' => $usersByYear,
                'monthlyData' => $monthlyData,
            ];

            // Return HTML view untuk debugging
            return view('reports.yearly-users', $data);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Debug HTML failed: ' . $e->getMessage()
            ], 500);
        }
    }
}