@props(['icon' => 'inbox', 'title' => '', 'description' => ''])

<div class="empty-state text-center">
    <div class="empty-state-icon mx-auto">
        <x-icon :name="$icon" />
    </div>
    <h5 class="fw-bold mt-3 mb-1">{{ $title }}</h5>
    @if ($description)
        <p class="text-muted small mb-3">{{ $description }}</p>
    @endif
    {{ $slot }}
</div>
