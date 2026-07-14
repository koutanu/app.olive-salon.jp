<input type="hidden" id="customer_geo" value="<?= $this->jsonAttr($this->customer_geo); ?>">
<input type="hidden" id="customer_geo_recently" value="<?= $this->jsonAttr($this->customer_geo_recently); ?>">
<input type="hidden" id="api" value="<?= $this->h(MAP_API); ?>">
<div class="main-section map">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <div class="gmap-wrapper">
                <div id="gmap" class="gmap"></div>
            </div>
            <button class="btn-map">全員</button>
            <button class="btn-map-recently">半年以内</button>
        </div>
    </div>
</div>