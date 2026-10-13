<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'category' => ['nullable', 'integer', 'exists:book_categories,id'],
        ]);
        $selectedCategoryId = $validated['category'] ?? null;

        $subscriptionPackages = SubscriptionPackage::latest()->take(3)->get();

        if ($subscriptionPackages->isEmpty()) {
            $defaultPackages = [
                [
                    'name' => 'Paket Silver',
                    'description' => 'Akses e-book dasar dengan fitur membaca ringan.',
                    'price' => 49000,
                    'color' => '#cfe2ff',
                ],
                [
                    'name' => 'Paket Gold',
                    'description' => 'Akses penuh untuk membaca lebih banyak judul premium.',
                    'price' => 99000,
                    'color' => '#fff3cd',
                ],
                [
                    'name' => 'Paket Platinum',
                    'description' => 'Nikmati semua fitur plus prioritas akses konten baru.',
                    'price' => 149000,
                    'color' => '#d1e7dd',
                ],
            ];

            foreach ($defaultPackages as $package) {
                SubscriptionPackage::firstOrCreate(
                    ['name' => $package['name']],
                    $package
                );
            }

            $subscriptionPackages = SubscriptionPackage::latest()->take(3)->get();
        }

        $latestBooks = Book::orderBy('created_at', 'desc')->limit(10)->get();
        $freeBooks = Book::where('price', 0)->orderBy('created_at', 'desc')->limit(6)->get();
        $bookCategories = BookCategory::withCount('books')->orderBy('name')->get();
        $selectedCategory = $selectedCategoryId
            ? BookCategory::findOrFail($selectedCategoryId)
            : null;
        $categoryBooks = $selectedCategory
            ? $selectedCategory->books()->latest()->get()
            : collect();

        return view('home', compact(
            'subscriptionPackages',
            'latestBooks',
            'freeBooks',
            'bookCategories',
            'selectedCategory',
            'categoryBooks'
        ));
    }
}