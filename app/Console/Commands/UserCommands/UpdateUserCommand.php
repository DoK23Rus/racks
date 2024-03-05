<?php

namespace App\Console\Commands\UserCommands;

use App\Adapters\ViewModels\CliViewModel;
use App\UseCases\UserUseCases\UpdateUserUseCase\UpdateUserInputPort;
use App\UseCases\UserUseCases\UpdateUserUseCase\UpdateUserRequestModel;
use Illuminate\Console\Command;

class UpdateUserCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'user:update 
                            {id : User ID} 
                            {name : User name} 
                            {full_name : User full name} 
                            {email : User email} 
                            {department_id : Department ID}';

    /**
     * @var string
     */
    protected $description = 'Updates an user';

    /**
     * @param  UpdateUserInputPort  $interactor
     */
    public function __construct(
        private UpdateUserInputPort $interactor
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
