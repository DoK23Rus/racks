<?php

namespace App\Console\Commands\RegionCommands;

use App\Adapters\ViewModels\CliViewModel;
use App\UseCases\RegionUseCases\UpdateRegionUseCase\UpdateRegionInputPort;
use App\UseCases\RegionUseCases\UpdateRegionUseCase\UpdateRegionRequestModel;
use Illuminate\Console\Command;

class UpdateRegionCommand extends Command
{
    protected $signature = 'update:region {id} {name}';

    protected $description = 'Updates a region';

    public function __construct(
        private readonly UpdateRegionInputPort $interactor
    ) {
        parent::__construct();
    }

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
