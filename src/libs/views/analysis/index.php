<input type="hidden" id="all_reservation_graph_data" value='<?= $this->all_reservation_graph; ?>'>
<input type="hidden" id="new_reservation_graph_data" value='<?= $this->new_reservation_graph; ?>'>
<input type="hidden" id="existing_reservation_graph_data" value='<?= $this->existing_reservation_graph; ?>'>
<input type="hidden" id="all_visitors_graph_data" value='<?= $this->all_visitors_graph; ?>'>
<input type="hidden" id="new_visitors_graph_data" value='<?= $this->new_visitors_graph; ?>'>
<input type="hidden" id="existing_visitors_graph_data" value='<?= $this->existing_visitors_graph; ?>'>
<input type="hidden" id="advertisement_graph_data" value='<?= $this->advertisement_graph; ?>'>
<input type="hidden" id="total_sales_data" value='<?= $this->total_sales_graph; ?>'>
<input type="hidden" id="total_grossprofit_data" value='<?= $this->total_grossprofit_graph; ?>'>
<div class="main-section analysis">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back"></i>
    </div>
    <div class="main-wrapper">
        <div class="graph-wrap">
            <div>
                <canvas id="visitors_graph" class="canvas"></canvas>
            </div>
            <div>
                <canvas id="reservation_graph" class="canvas"></canvas>
            </div>
            <div>
                <canvas id="advertisement_graph" class="canvas"></canvas>
            </div>
            <div>
                <canvas id="total_sales" class="canvas"></canvas>
            </div>
        </div>
    </div>
</div>