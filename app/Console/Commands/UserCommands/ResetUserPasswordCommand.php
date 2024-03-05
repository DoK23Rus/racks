<?php

namespace App\Console\Commands\UserCommands;

use App\Adapters\ViewModels\CliViewModel;
use App\UseCases\UserUseCases\ResetUserPasswordUseCase\ResetUserPasswordInputPort;
use App\UseCases\UserUseCases\ResetUserPasswordUseCase\ResetUserPasswordRequestModel;
use Illuminate\Console\Command;

class ResetUserPasswordCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'user:reset_password {id : User ID}';

    /**
     * @var string
     */
    protected $description = 'User password reset';

    /**
     * @param  ResetUserPasswordInputPort  $interactor
     */
    public function __construct(
        private ResetUserPasswordInputPort $interactor
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
        $viewModel = $this->interactor->resetUserPassword(
            App()->makeWith(
                ResetUserPasswordRequestModel::class,
                ['attributes' => ['id' => $this->argument('id'), 'password' => $password]]
            )
        );
        if ($viewModel instanceof CliViewModel) {
            return $viewModel->handle($this);
        }

        return self::SUCCESS;
    }
}
