<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class SettingsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Collection $unoits;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        $this->unoits = collect();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }

    public function getSettingUnits(): array
    {
        return $this->unoits->toArray();
    }

    public function addSettingUnits(array $settings)
    {
        collect($settings)->each(function (\UnitEnum $setting) {
            $this->unoits->push($setting);
        });
    }
}
