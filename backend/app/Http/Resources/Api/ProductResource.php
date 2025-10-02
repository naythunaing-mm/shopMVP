<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float) $this->price,
            'discount' => (float) ($this->discount ?? 0),
            'pics' => $this->transformPics($this->pics),
            'video' => $this->video,
            'types' => $this->transformArrayField($this->types),
            'colors' => $this->transformArrayField($this->colors),
            'stock' => (int) $this->stock,
            'category_id' => $this->category_id,
            'shop_id' => $this->shop_id,
            'category' => $this->whenLoaded('category'),
            'shop' => $this->whenLoaded('shop'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Transform pics field to return array of image URLs
     */
    private function transformPics($pics)
    {
        if (!$pics) {
            return [];
        }

        // Handle JSON-encoded strings first
        if (is_string($pics)) {
            // Try to decode as JSON first
            $decoded = json_decode($pics, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                // If it's a single string after JSON decode
                if (is_string($decoded)) {
                    $picsArray = [$decoded];
                } elseif (is_array($decoded)) {
                    $picsArray = $decoded;
                } else {
                    $picsArray = [$decoded];
                }
            } else {
                // Not JSON, treat as comma-separated string
                $picsArray = array_map('trim', explode(',', $pics));
            }
        } elseif (is_array($pics)) {
            $picsArray = $pics;
        } else {
            $picsArray = [$pics];
        }

        // Filter out empty/invalid entries and transform to URLs
        $validPics = [];
        foreach ($picsArray as $pic) {
            if ($pic && $pic !== 'null' && $pic !== 'undefined' && trim($pic) !== '') {
                $validPics[] = $this->transformImageUrl(trim($pic));
            }
        }

        return $validPics;
    }

    /**
     * Transform array fields (types, colors) to proper arrays
     */
    private function transformArrayField($field)
    {
        if (!$field) {
            return [];
        }

        if (is_string($field)) {
            return array_map('trim', explode(',', $field));
        }

        if (is_array($field)) {
            return $field;
        }

        return [$field];
    }

    /**
     * Transform single image filename to full URL
     */
    private function transformImageUrl($filename)
    {
        // If already a full URL, return as is
        if (substr($filename, 0, 7) === 'http://' || substr($filename, 0, 8) === 'https://') {
            return $filename;
        }

        // If starts with /, treat as absolute path
        if (substr($filename, 0, 1) === '/') {
            return url($filename);
        }

        // If contains product_pics, construct storage URL
        if (strpos($filename, 'product_pics') !== false) {
            return url('/storage/' . $filename);
        }

        // Default: assume it's just a filename in product_pics directory
        return url('/storage/product_pics/' . $filename);
    }
}
