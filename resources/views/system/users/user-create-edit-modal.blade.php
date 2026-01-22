<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0">
            {{-- Header --}}
            <div class="modal-header border-0 pb-0 pt-3">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="120" align="center" valign="middle" style="padding:10px 20px 10px 30px;">
                            <img src="{{ asset('assets/img/kone.png') }}" alt="KONE" style="height:40px;">
                        </td>
                        <td align="left" valign="middle">
                            <div
                                style="font-size:10px; color:#666; letter-spacing:2px;
                                        font-family: Arial, Helvetica, sans-serif; font-weight:500; margin-bottom:2px;">
                                WAREHOUSE MONITORING SYSTEM
                            </div>
                            <div class="text-uppercase"
                                style="font-size:24px; font-weight:bold; color:#222;
                                        font-family: Arial, Helvetica, sans-serif; letter-spacing:1px; margin-top:4px;">
                                {{ $isEditMode ? 'Edit User' : 'New User' }}
                            </div>
                        </td>
                    </tr>
                </table>

                <button type="button" class="close pr-3 pt-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <hr class="mt-0 mb-0" style="border-top:1px solid #eee;">

            {{-- Body --}}
            <div class="modal-body pb-4 pt-4 mb-2">
                <div class="container">
                    <div class="row">
                        {{-- First name --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>First name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                    wire:model.defer="first_name">
                                @error('first_name')
                                    <div class="parsley-errors-list filled mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Middle name --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Middle name</label>
                                <input type="text" class="form-control @error('middle_name') is-invalid @enderror"
                                    wire:model.defer="middle_name">
                                @error('middle_name')
                                    <div class="parsley-errors-list filled mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Last name --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Last name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                    wire:model.defer="last_name">
                                @error('last_name')
                                    <div class="parsley-errors-list filled mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Employee ID --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Employee ID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('employee_id') is-invalid @enderror"
                                    wire:model.defer="employee_id">
                                @error('employee_id')
                                    <div class="parsley-errors-list filled mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    wire:model.defer="email">
                                @error('email')
                                    <div class="parsley-errors-list filled mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Role <span class="text-danger">*</span></label>
                                <select class="form-control @error('role') is-invalid @enderror"
                                    wire:model.defer="role">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                                @error('role')
                                    <div class="parsley-errors-list filled mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        {{-- Password info --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" wire:model.defer="password"
                                    @if (!$isEditMode) readonly @endif>
                                <small class="form-text text-muted">
                                    @if ($isEditMode)
                                        Leave blank to keep existing password. To reset, type a new password.
                                    @else
                                        Default password is <strong>kwms2026</strong>.
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 pr-4 pb-3 mr-5">
                <button type="button" class="btn btn-outline-primary px-4" data-dismiss="modal">
                    Cancel
                </button>

                <button type="button" class="btn btn-primary px-4" wire:click="saveUser">
                    {{ $isEditMode ? 'Save changes' : 'Create user' }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script data-navigate-once>
        document.addEventListener('open-user-modal', () => {
            $('#userModal').modal('show');
        });

        window.addEventListener('user:create-success', () => {
            // optional success modal or toast
            // $('#userCreateSuccessModal').modal('show');
        });

        window.addEventListener('user:edit-success', () => {
            // optional success modal or toast
            // $('#userEditSuccessModal').modal('show');
        });

        document.addEventListener('livewire:navigated', () => {
            const el = document.getElementById('user-list');
            if (!el) return;
            const top = el.getBoundingClientRect().top + window.pageYOffset - 80;
            window.scrollTo({
                top,
                behavior: 'smooth'
            });
        });
    </script>
@endpush
