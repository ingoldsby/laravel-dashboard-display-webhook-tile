<x-dashboard-tile :position="$position" :fade="false">
	<div wire:poll.{{ $refreshIntervalInSeconds }}s>
		<div class="absolute inset-0 p-4 my-1">
			<div class="justify-items-center h-full text-center">
				<div class="grid gap-4 justify-items-center h-full text-center">
					<div class="font-medium text-dimmed text-sm uppercase tracking-wide tabular-nums">{{ $title ?? 'Latest Webhook' }}</div>
					<div class="self-center font-bold text-xl tracking-wide leading-none">{{ $webhook['value'] }}</div>
					<div class="flex w-full justify-center space-x-4 items-center text-xs text-dimmed">{{ \Carbon\Carbon::parse($webhook['created_at'])->diffForHumans() }}</div>
				</div>
			</div>
		</div>
	</div>
</x-dashboard-tile>