<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            ->withPivot('quantity', 'unit', 'available_quantity')
            ->withTimestamps();
    }

    // SCOPES (Query helpers)

    /**
     * Scope: tikai aktīvās partijas publiskajam skatam
     */
    public function scopeActiveForPublic($query)
    {
        return $query->whereIn('status', ['available', 'preparing']);
    }

    /**
     * Scope: tikai pieejamās partijas
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // ACCESSORS (Formatēti lauki)

    public function getFormattedBatchDateAttribute()
    {
        return $this->batch_date->format('d/m/Y H:i');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'available' => '#28a745',
            'sold_out' => '#dc3545',  
            'preparing' => '#fd7e14', 
            default => '#6c757d'
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'available' => 'Pieejams',
            'sold_out' => 'Izpārdots',
            'preparing' => 'Gatavošanā',
            default => 'Nezināms'
        };
    }

    // BUSINESS LOGIC METHODS

    /**
     * Izveidot jaunu partiju ar zivīm
     * 
     * @param string $name
     * @param string $batchDateString Format: 'd/m/Y H:i'
     * @param array $fishes [['fish_id' => 1, 'quantity' => 10, 'unit' => 'kg'], ...]
     * @param string|null $description
     * @return static
     */
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

            // Pievienot zivis
            foreach ($fishes as $fishData) {
                if (!empty($fishData['fish_id']) && !empty($fishData['quantity'])) {
                    $batch->fishes()->attach($fishData['fish_id'], [
                        'quantity' => $fishData['quantity'],
                        'unit' => $fishData['unit'],
                        'available_quantity' => $fishData['quantity']
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

    /**
     * Atjaunināt partiju un tās zivis
     * 
     * @param string $name
     * @param string $batchDateString Format: 'd/m/Y H:i'
     * @param array $fishes
     * @param string|null $description
     * @return bool
     */
    public function updateWithFishes(
        string $name,
        string $batchDateString,
        array $fishes,
        ?string $description = null
    ): bool {
        DB::beginTransaction();

        try {
            $batchDate = Carbon::createFromFormat('d/m/Y H:i', $batchDateString);

            // Atjaunināt pamata info
            $this->update([
                'name' => $name,
                'description' => $description,
                'batch_date' => $batchDate
            ]);

            // Atjaunināt zivis
            if (!empty($fishes)) {
                // Noņemt vecās saites
                $this->fishes()->detach();

                // Pievienot jaunās
                foreach ($fishes as $fishData) {
                    if (!empty($fishData['fish_id']) && !empty($fishData['quantity'])) {
                        $availableQuantity = min(
                            $fishData['available_quantity'], 
                            $fishData['quantity']
                        );

                        $this->fishes()->attach($fishData['fish_id'], [
                            'quantity' => $fishData['quantity'],
                            'available_quantity' => $availableQuantity,
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

    /**
     * Mainīt partijas statusu
     * 
     * @param string $newStatus
     * @return bool
     */
    public function updateStatus(string $newStatus): bool
    {
        return $this->update(['status' => $newStatus]);
    }

    /**
     * Dzēst partiju ar visām saistītajām zivīm
     * 
     * @return bool
     */
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

    // STATUS CHECK METHODS

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