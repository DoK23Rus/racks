<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

/**
 * Export reports service
 */
class ExportService
{
    /**
     * Export model data to csv
     *
     * @param  Model  $model  Model
     * @param  int  $chunk  Chunk for lazy load
     * @param  string  $column  PK name
     * @return string
     */
    public static function createCsvReport(Model $model, int $chunk, string $column): string
    {
        $fileName = 'export_'.$model->getTable().'_'.Carbon::now()->format('YmdHs').'.csv';
        $handle = fopen(public_path($fileName), 'w');
        fputcsv($handle, Schema::getColumnListing($model->getTable()));
        $model::query()
            ->lazyById($chunk, $column)
            ->each(function ($item) use ($handle) {
                fputcsv($handle, $item->toArray());
            });
        fclose($handle);

        return $fileName;
    }
}
