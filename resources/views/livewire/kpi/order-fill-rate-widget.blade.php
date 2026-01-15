<div class="card card-border-color-success">
    <div class="card-header card-header-divider">
        Order Fill Rate
        <span class="card-subtitle">Orders shipped complete</span>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <h2 class="no-margin">{{ number_format(end($series)[1], 1) }}%</h2>
                <span class="text-muted">Today</span>
            </div>
            <div class="col-md-8 text-right">
                <span class="text-success">
                    <span class="icon s7-arrow-up"></span> +1.2% vs last week
                </span>
            </div>
        </div>

        {{-- Beagle "Without Points" Flot chart --}}
        <div id="order-fill-rate-chart" style="height: 220px;"></div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', initOrderFillRateChart);
            document.addEventListener('livewire:load', initOrderFillRateChart);

            function initOrderFillRateChart() {
                var el = $('#order-fill-rate-chart');
                if (!el.length) return;

                var data = [{
                    data: @json($series),
                    color: '#4c84ff',
                    lines: { show: true, fill: true, lineWidth: 2 },
                    shadowSize: 0
                }];

                $.plot(el, data, {
                    xaxis: { tickDecimals: 0 },
                    yaxis: { min: 0, max: 100, tickFormatter: v => v + '%' },
                    grid: { borderWidth: 0, hoverable: true, clickable: true }
                });
            }
        </script>
    @endpush
</div>
