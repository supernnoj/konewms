<?php

namespace App\Livewire\System\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // list filters/search
    public string $searchInput = '';
    public string $search = '';
    public string $roleFilter = '';
    public string $statusFilter = '';

    // modal state
    public ?int $editingUserId = null;   // null = create, id = edit
    public bool $isEditMode = false;

    // form fields
    public string $first_name = '';
    public ?string $middle_name = null;
    public string $last_name = '';
    public string $name = '';
    public string $email = '';
    public string $employee_id = '';
    public string $role = '';
    public string $password = '';        // will default to kwms2026

    public function submitFilters(): void
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['searchInput', 'search', 'roleFilter', 'statusFilter']);
        $this->resetPage();
        $this->dispatch('user-filters-cleared');
    }

    public function getActiveFilterCountProperty(): int
    {
        $count = 0;
        if ($this->roleFilter !== '')
            $count++;
        if ($this->statusFilter !== '')
            $count++;
        return $count;
    }

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:191'],
            'middle_name' => ['nullable', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => [
                'required',
                'email',
                'max:191',
                Rule::unique('users', 'email')->ignore($this->editingUserId),
            ],
            'employee_id' => [
                'required',
                'string',
                'max:191',
                Rule::unique('users', 'employee_id')->ignore($this->editingUserId),
            ],
            'role' => ['required', 'in:user,admin'],
        ];
    }

    protected function syncFullName(): void
    {
        $parts = [$this->first_name];
        if ($this->middle_name) {
            $parts[] = $this->middle_name;
        }
        $parts[] = $this->last_name;
        $this->name = trim(implode(' ', $parts));
    }

    public function openCreateUserModal(): void
    {
        $this->resetValidation();
        $this->reset([
            'editingUserId',
            'first_name',
            'middle_name',
            'last_name',
            'name',
            'email',
            'employee_id',
            'role',
        ]);

        $this->isEditMode = false;
        $this->password = 'kwms2026';
        $this->role = 'user';

        $this->dispatch('open-user-modal');
    }

    public function openEditUserModal(int $userId): void
    {
        $this->resetValidation();

        $user = User::findOrFail($userId);

        $this->editingUserId = $user->id;
        $this->first_name = $user->first_name;
        $this->middle_name = $user->middle_name;
        $this->last_name = $user->last_name;
        $this->name = $user->name ?? ($user->first_name . ' ' . $user->last_name);
        $this->email = $user->email;
        $this->employee_id = $user->employee_id;
        $this->role = $user->role ?: 'user';
        $this->password = ''; // not shown/edited by default

        $this->isEditMode = true;

        $this->dispatch('open-user-modal');
    }

    public function saveUser(): void
    {
        $this->syncFullName();

        $this->validate();

        if ($this->editingUserId) {
            // update
            $user = User::findOrFail($this->editingUserId);

            $user->first_name = $this->first_name;
            $user->middle_name = $this->middle_name;
            $user->last_name = $this->last_name;
            $user->name = $this->name;
            $user->email = $this->email;
            $user->employee_id = $this->employee_id;
            $user->role = $this->role;

            // optional: allow resetting password if user typed something
            if (trim($this->password) !== '') {
                $user->password = Hash::make($this->password);
            }

            $user->save();

            $this->dispatch('user:edit-success');
        } else {
            // create
            $user = User::create([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'name' => $this->name,
                'email' => $this->email,
                'employee_id' => $this->employee_id,
                'role' => $this->role ?: 'user',
                'password' => Hash::make($this->password ?: 'kwms2026'),
            ]);

            $this->editingUserId = $user->id;

            $this->dispatch('user:create-success');
        }
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search !== '', function ($q) {
                $term = '%' . $this->search . '%';
                $q->where(function ($sub) use ($term) {
                    $sub->where('name', 'like', $term)
                        ->orWhere('first_name', 'like', $term)
                        ->orWhere('last_name', 'like', $term)
                        ->orWhere('employee_id', 'like', $term)
                        ->orWhere('email', 'like', $term);
                });
            })
            ->when($this->roleFilter !== '', function ($q) {
                $q->where('role', $this->roleFilter);
            })
            ->when($this->statusFilter !== '', function ($q) {
                if ($this->statusFilter === 'active') {
                    $q->whereNull('deleted_at');
                } elseif ($this->statusFilter === 'inactive') {
                    $q->onlyTrashed();
                }
            })
            ->orderBy('name')
            ->paginate(10);

        $roleOptions = User::select('role')
            ->whereNotNull('role')
            ->where('role', '!=', '')
            ->distinct()
            ->orderBy('role')
            ->pluck('role');

        return view('livewire.system.users.user-management', [
            'users' => $users,
            'roleOptions' => $roleOptions,
        ]);
    }
}
