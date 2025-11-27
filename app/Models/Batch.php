<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


// Batch - Ieplānotā produkcijas izlaišana

class Batch extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'batch_date', 'status', 'description'];

    protected $casts = [
        'batch_date' => 'datetime'
    ];

    // RELATIONSHIPS

    public function fishes()
    {
        return $this->belongsToMany(Fish::class, 'batch_fish')
            ->withPivot('quantity', 'unit')
            ->withTimestamps();
    }

    // SCOPES (Query helpers)

    public function scopeActiveForPublic($query)
    {
        return $query->whereIn('status', ['available', 'preparing']);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function getFormattedBatchDateAttribute()
    {
        return $this->batch_date->format('d/m/Y H:i');
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'available' => '#28a745',
            'sold_out' => '#dc3545',
            'preparing' => '#fd7e14',
            default => '#6c757d'
        };
    }

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'available' => 'Pieejams',
            'sold_out' => 'Izpārdots',
            'preparing' => 'Gatavošanā',
            default => 'Nezināms'
        };
    }

    // CRUD METODES

    // Izveidot jaunu partiju ar zivīm
    
    public static function createWithFishes(
        string $name,
        string $batchDateString,
        array $fishes,
        ?string $description = null
    ): static {
        DB::beginTransaction();

        try {
            $batchDate = Carbon::createFromFormat('d/m/Y H:i', $batchDateString);

            $batch = static::create([
                'name' => $name,
                'batch_date' => $batchDate,
                'description' => $description,
                'status' => 'preparing'
            ]);

            // Pievienot zivis (TIKAI quantity un unit)
            foreach ($fishes as $fishData) {
                if (!empty($fishData['fish_id']) && !empty($fishData['quantity'])) {
                    $batch->fishes()->attach($fishData['fish_id'], [
                        'quantity' => $fishData['quantity'],
                        'unit' => $fishData['unit'],
                    ]);
                }
            }

            DB::commit();
            return $batch;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateWithFishes(
        string $name,
        string $batchDateString,
        array $fishes,
        ?string $description = null
    ): bool {
        DB::beginTransaction();

        try {
            $batchDate = Carbon::createFromFormat('d/m/Y H:i', $batchDateString);

            $this->update([
                'name' => $name,
                'description' => $description,
                'batch_date' => $batchDate
            ]);

            // Atjaunināt zivis
            if (!empty($fishes)) {
                $this->fishes()->detach();

                foreach ($fishes as $fishData) {
                    if (!empty($fishData['fish_id']) && !empty($fishData['quantity'])) {
                        $this->fishes()->attach($fishData['fish_id'], [
                            'quantity' => $fishData['quantity'],
                            'unit' => $fishData['unit']
                        ]);
                    }
                }
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateStatus(string $newStatus): bool
    {
        return $this->update(['status' => $newStatus]);
    }

    public function deleteWithRelations(): bool
    {
        DB::beginTransaction();

        try {
            $this->fishes()->detach();
            $this->delete();

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isPreparing(): bool
    {
        return $this->status === 'preparing';
    }

    public function isSoldOut(): bool
    {
        return $this->status === 'sold_out';
    }

    public function isVisibleToPublic(): bool
    {
        return in_array($this->status, ['available', 'preparing']);
    }
}