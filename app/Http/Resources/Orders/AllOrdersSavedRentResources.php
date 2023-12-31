<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\HoursResources;
use App\Http\Resources\TripTypeResources;
use App\Http\Resources\Users\UsersResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllOrdersSavedRentResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'trip_type_id' => new TripTypeResources($this->trip_type),
            'typeOrders' => $this->hour_id == true ? "OrderHours" : "OrderDay",
            'hour_id' => $this->hour_id == true ? new HoursResources($this->hour) : null,
            'order_code' => $this->order_code ?? null,
            'total_price' => $this->total_price ?? null,
            'chat_id' => $this->chat_id ?? null,
            'status' => $this->status ?? null,
            'payments' => $this->payments ?? null,
            'lat_user' => $this->lat_user ?? null,
            'long_user' => $this->long_user ?? null,
            'address_now' => $this->address_now ?? null,
            'start_day' => $this->start_day ?? null,
            'end_day' => $this->end_day ?? null,
            'number_day' => $this->number_day ?? null,
            'start_time' => $this->start_time ?? null,
            'data' => $this->data ?? null,
            'hours_from' => $this->hours_from ?? null,
            'create_dates' => [
                'created_at_human' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ],
            'update_dates' => [
                'updated_at_human' => $this->updated_at->diffForHumans(),
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
