<?php

namespace App\Livewire\System\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $searchInput = '';
    public $search = '';

    public $dateFrom = '';
    public $dateTo = '';

    // modal state
    public ?int $viewProjectId = null;
    public string $view_name = '';
    public string $view_address = '';
    public ?int $view_created_by = null;

    public bool $isEditing = false;
    public bool $isCreating = false;

    public function submitFilters()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['searchInput', 'search', 'dateFrom', 'dateTo']);
        $this->resetPage();

        $this->dispatch('project-filters-cleared');
    }

    public function getActiveFilterCountProperty()
    {
        $count = 0;

        if ($this->search !== '') {
            $count++;
        }
        if ($this->dateFrom !== '' || $this->dateTo !== '') {
            $count++;
        }

        return $count;
    }

    protected function loadProject(int $projectId): void
    {
        $project = Project::with('creator')->findOrFail($projectId);

        $this->viewProjectId = $project->id;
        $this->view_name = $project->name;
        $this->view_address = $project->address ?? '';
        $this->view_created_by = $project->created_by;
    }

    public function openViewProjectModal(int $projectId): void
    {
        $this->isCreating = false;
        $this->isEditing = false;
        $this->resetValidation();

        $this->loadProject($projectId);

        $this->dispatch('open-project-view-modal');
    }

    public function openCreateProjectModal(): void
    {
        $this->resetValidation();
        $this->reset([
            'viewProjectId',
            'view_name',
            'view_address',
            'view_created_by',
        ]);

        $this->isCreating = true;
        $this->isEditing = true; // creating = editable

        $this->dispatch('open-project-view-modal');
    }

    public function enableEdit(): void
    {
        if (!$this->viewProjectId) {
            return;
        }

        $this->isEditing = true;
        $this->isCreating = false;
        $this->resetValidation();
    }

    public function cancelEdit(): void
    {
        if ($this->viewProjectId) {
            $this->loadProject($this->viewProjectId);
        }

        $this->isEditing = false;
    }

    public function saveProject(): void
    {
        $this->validate([
            'view_name' => ['required', 'string', 'max:191'],
            'view_address' => ['nullable', 'string', 'max:500'],
        ]);

        if ($this->isCreating) {
            $project = Project::create([
                'name' => $this->view_name,
                'address' => $this->view_address ?: null,
                'created_by' => auth()->id(),
            ]);

            $this->viewProjectId = $project->id;
            $this->isCreating = false;
            $this->isEditing = false;
        } else {
            if (!$this->viewProjectId) {
                return;
            }

            $project = Project::findOrFail($this->viewProjectId);
            $project->name = $this->view_name;
            $project->address = $this->view_address ?: null;
            $project->save();

            $this->isEditing = false;
        }

        $this->dispatch('project:save-success');
    }

    public function render()
    {
        $projects = Project::query()
            ->when($this->search !== '', function ($query) {
                $search = '%' . $this->search . '%';

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', $search)
                        ->orWhere('address', 'like', $search);
                });
            })
            ->when($this->dateFrom !== '', function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo !== '', function ($query) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            })
            ->with('creator')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.system.projects.project-management', [
            'projects' => $projects,
        ]);
    }
}
