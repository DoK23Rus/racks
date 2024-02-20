<?php

namespace App\Console\Commands\RegionCommands;

use App\Adapters\ViewModels\CliViewModel;
use App\UseCases\RegionUseCases\UpdateRegionUseCase\UpdateRegionInputPort;
use App\UseCases\RegionUseCases\UpdateRegionUseCase\UpdateRegionRequestModel;
use Illuminate\Console\Command;

class UpdateRegionCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'update:region {id} {name}';

    /**
     * @var string
     */
    protected $description = 'Updates a region';

    /**
     * @param  UpdateRegionInputPort  $interactor
     */
    public function __construct(
        private readonly UpdateRegionInputPort $interactor
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
        $viewModel = $this->interactor->updateRegion(
            App()->makeWith(UpdateRegionRequestModel::class, ['attributes' => $attributes])
        );

        if ($viewModel instanceof CliViewModel) {
            return $viewModel->handle($this);
        }

        return self::SUCCESS;
    }
}
