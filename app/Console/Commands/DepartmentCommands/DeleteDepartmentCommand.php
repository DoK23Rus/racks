<?php

namespace App\Console\Commands\DepartmentCommands;

use App\Adapters\ViewModels\CliViewModel;
use App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase\DeleteDepartmentInputPort;
use App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase\DeleteDepartmentRequestModel;
use Illuminate\Console\Command;

class DeleteDepartmentCommand extends Command
{
    protected $signature = 'delete:department {id}';

    protected $description = 'Deletes a department';

    public function __construct(
        private readonly DeleteDepartmentInputPort $interactor
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $attributes = [
            'id' => $this->argument('id'),
        ];
        $viewModel = $this->interactor->deleteDepartment(
            App()->makeWith(DeleteDepartmentRequestModel::class, ['attributes' => $attributes])
        );

        if ($viewModel instanceof CliViewModel) {
            return $viewModel->handle($this);
        }

        return self::SUCCESS;
    }
}
