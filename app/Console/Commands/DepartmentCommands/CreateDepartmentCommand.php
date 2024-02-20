<?php

namespace App\Console\Commands\DepartmentCommands;

use App\Adapters\ViewModels\CliViewModel;
use App\UseCases\DepartmentUseCases\CreateDepartmentUseCase\CreateDepartmentInputPort;
use App\UseCases\DepartmentUseCases\CreateDepartmentUseCase\CreateDepartmentRequestModel;
use Illuminate\Console\Command;

class CreateDepartmentCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'create:department {name} {region_id}';

    /**
     * @var string
     */
    protected $description = 'Creates a department';

    /**
     * @param  CreateDepartmentInputPort  $interactor
     */
    public function __construct(
        private readonly CreateDepartmentInputPort $interactor
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
            'name' => $this->argument('name'),
            'region_id' => $this->argument('region_id'),
        ];
        $viewModel = $this->interactor->createDepartment(
            App()->makeWith(CreateDepartmentRequestModel::class, ['attributes' => $attributes])
        );

        if ($viewModel instanceof CliViewModel) {
            return $viewModel->handle($this);
        }

        return self::SUCCESS;
    }
}
