<div class="modal fade" id="inventorySuccessModal" tabindex="-1" role="dialog" aria-labelledby="inventorySuccessLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-primary">
            <div class="modal-header"></div>
            <div class="modal-body text-center">
                <div class="text-center text-white"><span class="modal-main-icon mdi mdi-check"></span>
                    <h3>Item Added to Warehouse!</h3>
                    <p>The inventory record has been successfully added, and the warehouse listing has been updated.</p>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    window.addEventListener('inventory:success', function (e) {
        const payload = Array.isArray(e.detail) ? e.detail[0] : e.detail;

        if (payload && payload.pdfUrl) {
            window.open(payload.pdfUrl, '_blank');
        }

        $('#inventorySuccessModal').modal('show');
    });
</script>
