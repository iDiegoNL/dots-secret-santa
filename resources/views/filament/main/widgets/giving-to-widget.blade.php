<x-filament-widgets::widget>
    @if($this->givingTo === null)
        <x-filament::empty-state
            icon="heroicon-o-face-frown"
            iconSize="2xl"
        >
            <x-slot name="heading">
                You aren't anyone's Secret Santa...
            </x-slot>
            <x-slot name="description">
                This probably shouldn't happen, please contact Dot.
            </x-slot>
        </x-filament::empty-state>
    @else
        <x-filament::section icon="heroicon-o-gift">
            <x-slot name="heading">
                You're giving to... {{ $givingTo->decoded_name }}
            </x-slot>

            <x-slot name="description">
                Here are some hints to help you choose the perfect gift.
            </x-slot>

            @if($this->givingTo->giftHints === null)
                <x-filament::empty-state
                    icon="heroicon-o-face-frown"
                    iconSize="2xl"
                    compact
                >
                    <x-slot name="heading">
                        {{ $this->givingTo->decoded_name }} hasn't provided any gift hints... I suggest gifting them a lump of coal!
                    </x-slot>
                    <x-slot name="description">
                        Or alternatively... try throwing some rocks in their general direction and see if they react.
                    </x-slot>
                </x-filament::empty-state>
            @else
                {{ $this->givingToInfolist }}
            @endif
        </x-filament::section>
    @endif
</x-filament-widgets::widget>
