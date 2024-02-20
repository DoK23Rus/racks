<?php

namespace App\Console\Commands\DepartmentCommands;

use App\Adapters\ViewModels\CliViewModel;
use App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase\DeleteDepartmentInputPort;
use App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase\DeleteDepartmentRequestModel;
use Illuminate\Console\Command;

class DeleteDepartmentCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'delete:department {id}';

    /**
     * @var string
     */
    protected $description = 'Deletes a department';

    /**
     * @param  DeleteDepartmentInputPort  $interactor
     */
    public function __construct(
        private readonly DeleteDepartmentInputPort $interactor
    ) {
        parent::__construct();
    }

    /**
     * @return int
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
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
