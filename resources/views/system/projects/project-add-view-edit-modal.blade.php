<div class="modal fade" id="projectViewModal" tabindex="-1" role="dialog" aria-labelledby="projectViewModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            {{-- HEADER (same design as filter modal, dynamic title) --}}
            <div class="modal-header mt-2 mb-2">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="120" align="center" valign="middle" style="padding:10px 20px 10px 30px;">
                            <img src="{{ asset('assets/img/kone.png') }}" alt="KONE" style="height:40px;">
                        </td>
                        <td align="left" valign="middle">
                            <div
                                style="font-size:10px; color:#444; letter-spacing:2px; font-family: Arial, Helvetica, sans-serif; font-weight:500; margin-bottom:2px;">
                                PROJECT MANAGEMENT SYSTEM
                            </div>
                            <div class="text-uppercase"
                                style="font-size:25px; font-weight:bold; color:#333; font-family: Arial, Helvetica, sans-serif; letter-spacing:1px; margin-top:5px;">
                                @if ($isCreating)
                                    ADD PROJECT
                                @else
                                    PROJECT DETAILS
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- BODY --}}
            <div class="modal-body mx-4 ml-6">
                {{-- Name --}}
                <div class="form-group mb-2"> {{-- smaller bottom margin --}}
                    <label class="form-label mb-0" style="font-size: 13px;">Name</label> {{-- mb-0 makes it closer --}}
                    @if (!$isEditing)
                        {{-- VIEW MODE: plain text --}}
                        <div class="form-control-plaintext" style="font-size: 16px; padding-left: 0;">
                            {{ $view_name ?: '—' }}
                        </div>
                    @else
                        {{-- EDIT/CREATE MODE: input --}}
                        <input type="text" class="form-control @error('view_name') is-invalid @enderror"
                            wire:model.defer="view_name">
                        @error('view_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    @endif
                </div>

                {{-- Address --}}
                <div class="form-group mt-5 mb-2">
                    <label class="form-label mb-0" style="font-size: 13px;">Address</label>
                    @if (!$isEditing)
                        {{-- VIEW MODE: multi-line text --}}
                        <div class="form-control-plaintext" style="font-size: 16px; padding-left: 0;">
                            {{ $view_address ?: '—' }}
                        </div>
                    @else
                        {{-- EDIT/CREATE MODE: textarea --}}
                        <textarea class="form-control @error('view_address') is-invalid @enderror" rows="3"
                            wire:model.defer="view_address"></textarea>
                        @error('view_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    @endif
                </div>


                {{-- @if (!$isCreating && $viewProjectId)
        <div class="form-group mb-0">
            <label class="form-label mb-0" style="font-size: 13px;">Project ID</label>
            <div class="form-control-plaintext"
                 style="font-size: 13px; padding-left: 0; margin-top: 2px;">
                {{ $viewProjectId }}
            </div>
        </div>
    @endif --}}
            </div>



            {{-- FOOTER --}}
            <div class="modal-footer mr-4">
                @if ($isCreating)
                    {{-- Creating a NEW project: show Cancel + Save, both affect the modal --}}
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="saveProject">
                        Save
                    </button>
                @else
                    @if ($isEditing)
                        {{-- Editing EXISTING project: Cancel only exits edit mode, keep modal open --}}
                        <button type="button" class="btn btn-outline-primary" wire:click="cancelEdit">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="saveProject">
                            Save changes
                        </button>
                    @else
                        {{-- Pure VIEW mode --}}
                        @if ($viewProjectId)
                            <button type="button" class="btn btn-outline-primary" wire:click="enableEdit">
                                Edit
                            </button>
                        @endif
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                            Close
                        </button>
                    @endif
                @endif
            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script data-navigate-once>
        document.addEventListener('open-project-view-modal', () => {
            $('#projectViewModal').modal('show');
        });

        document.addEventListener('project:save-success', () => {
            // optional: show a toast or reload something
            // $('#projectViewModal').modal('hide'); // uncomment if you want to auto-close after save
        });
    </script>
@endpush
