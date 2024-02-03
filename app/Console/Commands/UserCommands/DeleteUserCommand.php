<?php

namespace App\Console\Commands\UserCommands;

use App\Adapters\ViewModels\CliViewModel;
use App\UseCases\UserUseCases\DeleteUserUseCase\DeleteUserInputPort;
use App\UseCases\UserUseCases\DeleteUserUseCase\DeleteUserRequestModel;
use Illuminate\Console\Command;

class DeleteUserCommand extends Command
{
    protected $signature = 'delete:user {id}';

    protected $description = 'Deletes an user';

    public function __construct(
        private DeleteUserInputPort $interactor
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $viewModel = $this->interactor->deleteUser(
            App()->makeWith(
                DeleteUserRequestModel::class,
                ['attributes' => ['id' => $this->argument('id')]]
            )
        );
        if ($viewModel instanceof CliViewModel) {
            return $viewModel->handle($this);
        }

        return self::SUCCESS;
    }
}
