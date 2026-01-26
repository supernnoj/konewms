<div class="modal fade" id="confirmUserModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>

    <div class="modal-dialog" role="document" style="margin-top: 14vh">
        <div class="modal-content bg-primary">
            <div class="modal-header"></div>
            <div class="modal-body text-center">
                <div class="text-center text-white"><span class="modal-main-icon mdi mdi-info"></span>
                    <h3>
                        @if ($confirmAction === 'deactivate')
                            Delete
                        @else
                            Restore
                        @endif
                        User?
                    </h3>
                    <p>
                        @if ($confirmAction === 'deactivate')
                            Are you sure you want to delete this user?
                        @else
                            Are you sure you want to restore this user?
                        @endif
                    </p>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" wire:click="performConfirm">
                    Yes,  @if ($confirmAction === 'deactivate') delete @else restore @endif
                </button>
            </div>
        </div>
    </div>
</div>

<script data-navigate-once>
    window.addEventListener('open-confirm-modal', () => {
        $('#confirmUserModal').modal('show');
    });

    window.addEventListener('close-confirm-modal', () => {
        $('#confirmUserModal').modal('hide');
    });
</script>
