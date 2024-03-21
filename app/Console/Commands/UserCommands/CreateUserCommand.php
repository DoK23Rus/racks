<?php

namespace App\Console\Commands\UserCommands;

use App\Adapters\ViewModels\CliViewModel;
use App\UseCases\UserUseCases\CreateUserUseCase\CreateUserInputPort;
use App\UseCases\UserUseCases\CreateUserUseCase\CreateUserRequestModel;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'user:create 
                            {name : User name} 
                            {full_name : User full name} 
                            {email : User email} 
                            {department_id : Department ID}';

    /**
     * @var string
     */
    protected $description = 'Creates an user';

    /**
     * @param  CreateUserInputPort  $interactor
     */
    public function __construct(
        private CreateUserInputPort $interactor
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
        $password = $this->ask('Password');
        $confirm = $this->ask('Confirm password');

        if ($password != $confirm) {
            $this->error("Password confirmation doesn't match.");

            return self::FAILURE;
        }

        $viewModel = $this->interactor->createUser(
            App()->makeWith(
                CreateUserRequestModel::class,
                ['attributes' => ['name' => $this->argument('name'),
                    'full_name' => $this->argument('full_name'),
                    'email' => $this->argument('email'),
                    'password' => $password,
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
