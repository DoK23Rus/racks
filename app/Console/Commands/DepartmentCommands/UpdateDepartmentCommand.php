<?php

namespace App\Console\Commands\DepartmentCommands;

use App\Adapters\ViewModels\CliViewModel;
use App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase\UpdateDepartmentInputPort;
use App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase\UpdateDepartmentRequestModel;
use Illuminate\Console\Command;

class UpdateDepartmentCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'update:department {id} {name}';

    /**
     * @var string
     */
    protected $description = 'Updates a department';

    /**
     * @param  UpdateDepartmentInputPort  $interactor
     */
    public function __construct(
        private readonly UpdateDepartmentInputPort $interactor
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
            'name' => $this->argument('name'),
        ];
        $viewModel = $this->interactor->updateDepartment(
            App()->makeWith(UpdateDepartmentRequestModel::class, ['attributes' => $attributes])
        );

        if ($viewModel instanceof CliViewModel) {
            return $viewModel->handle($this);
        }

        return self::SUCCESS;
    }
}
