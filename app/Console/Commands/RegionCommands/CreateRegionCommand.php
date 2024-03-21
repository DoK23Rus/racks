<?php

namespace App\Console\Commands\RegionCommands;

use App\Adapters\ViewModels\CliViewModel;
use App\UseCases\RegionUseCases\CreateRegionUseCase\CreateRegionInputPort;
use App\UseCases\RegionUseCases\CreateRegionUseCase\CreateRegionRequestModel;
use Illuminate\Console\Command;

class CreateRegionCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'region:create {name : Region name}';

    /**
     * @var string
     */
    protected $description = 'Creates a region';

    /**
     * @param  CreateRegionInputPort  $interactor
     */
    public function __construct(
        private readonly CreateRegionInputPort $interactor
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
        ];
        $viewModel = $this->interactor->createRegion(
            App()->makeWith(CreateRegionRequestModel::class, ['attributes' => $attributes])
        );

        if ($viewModel instanceof CliViewModel) {
            return $viewModel->handle($this);
        }

        return self::SUCCESS;
    }
}
