<?php

namespace App\Console\Commands\RegionCommands;

use App\Adapters\ViewModels\CliViewModel;
use App\UseCases\RegionUseCases\DeleteRegionUseCase\DeleteRegionInputPort;
use App\UseCases\RegionUseCases\DeleteRegionUseCase\DeleteRegionRequestModel;
use Illuminate\Console\Command;

class DeleteRegionCommand extends Command
{
    protected $signature = 'delete:region {id}';

    protected $description = 'Deletes a region';

    public function __construct(
        private readonly DeleteRegionInputPort $interactor
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $attributes = [
            'id' => $this->argument('id'),
        ];
        $viewModel = $this->interactor->deleteRegion(
            App()->makeWith(DeleteRegionRequestModel::class, ['attributes' => $attributes])
        );

        if ($viewModel instanceof CliViewModel) {
            return $viewModel->handle($this);
        }

        return self::SUCCESS;
    }
}
