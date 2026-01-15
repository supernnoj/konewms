<div class="modal fade" id="transactionSuccessModal" tabindex="-1" role="dialog" aria-labelledby="transactionSuccessLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-primary">
            <div class="modal-header"></div>
            <div class="modal-body text-center">
                <div class="text-center text-white"><span class="modal-main-icon mdi mdi-check"></span>
                    <h3>Transaction Completed!</h3>
                    <p>You can now review and print the Delivery Receipt saved on your device.</p>
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
    window.addEventListener('transaction:success', function(e) {
        const payload = Array.isArray(e.detail) ? e.detail[0] : e.detail;

        if (payload.pdfUrl) {
            window.open(payload.pdfUrl, '_blank');
        }

        $('#transactionSuccessModal').modal('show');
    });
</script>
