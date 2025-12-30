<div style="position: absolute; bottom: 20px; right: 30px; display: flex; gap: 10px; z-index: 10;">
    @for($i = 0; $i < $count; $i++)
        <div class="indicator-dot {{ $i == 0 ? 'active' : '' }}" onclick="activateSlide('{{ $group }}', {{ $i }})"
            style="width: 12px; height: 12px; border-radius: 50%; background: rgba(255,255,255,0.5); cursor: pointer; transition: 0.3s;">
        </div>
    @endfor
</div>

<style>
    .indicator-dot.active {
        background: white !important;
    }
</style>