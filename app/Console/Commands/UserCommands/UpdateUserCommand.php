<?php

namespace App\Console\Commands\UserCommands;

use App\Adapters\ViewModels\CliViewModel;
use App\UseCases\UserUseCases\UpdateUserUseCase\UpdateUserInputPort;
use App\UseCases\UserUseCases\UpdateUserUseCase\UpdateUserRequestModel;
use Illuminate\Console\Command;

class UpdateUserCommand extends Command
{
    protected $signature = 'update:user {id} {name} {full_name} {email} {department_id}';

    protected $description = 'Updates an user';

    public function __construct(
        private UpdateUserInputPort $interactor
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $viewModel = $this->interactor->updateUser(
            App()->makeWith(
                UpdateUserRequestModel::class,
                ['attributes' => ['id' => $this->argument('id'),
                    'name' => $this->argument('name'),
                    'full_name' => $this->argument('full_name'),
                    'email' => $this->argument('email'),
                    'department_id' => $this->argument('department_id')],
                ]
            )
        );
        if ($viewModel instanceof CliViewModel) {
            return $viewModel->handle($this);
        }

        return self::SUCCESS;
    }
}
