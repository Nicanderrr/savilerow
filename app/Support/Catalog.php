<?php

namespace App\Support;

class Catalog
{
    public static function all(): array
    {
        static $products = null;

        if ($products === null) {
            $json = file_get_contents(resource_path('data/catalog.json'));
            $products = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        }

        return $products;
    }

    public static function find(string $slug): ?array
    {
        foreach (self::all() as $product) {
            if ($product['slug'] === $slug) {
                return $product;
            }
        }

        return null;
    }

    public static function collection(string $gender, string $category): array
    {
        return array_values(array_filter(self::all(), function (array $product) use ($gender, $category) {
            $genderMatches = $gender === 'all' || $product['gender'] === $gender;
            $categoryMatches = $category === 'products' || $product['category'] === $category;

            return $genderMatches && $categoryMatches;
        }));
    }

    public static function related(array $product, int $limit = 4): array
    {
        return array_slice(array_values(array_filter(self::all(), function (array $candidate) use ($product) {
            return $candidate['slug'] !== $product['slug']
                && ($candidate['category'] === $product['category'] || $candidate['gender'] === $product['gender']);
        })), 0, $limit);
    }

    public static function featured(int $limit = 12): array
    {
        $new = array_values(array_filter(self::all(), fn (array $product) => $product['isNew'] ?? false));

        return array_slice(count($new) ? $new : self::all(), 0, $limit);
    }

    public static function money(int|float $amount): string
    {
        return '$'.number_format((float) $amount, 0);
    }
}

