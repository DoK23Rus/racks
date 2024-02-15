<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        \App\Domain\Interfaces\UserInterfaces\UserFactory::class => \App\Factories\UserModelFactory::class,
        \App\Domain\Interfaces\UserInterfaces\UserRepository::class => \App\Repositories\UserDatabaseRepository::class,
        \App\Domain\Interfaces\RackInterfaces\RackFactory::class => \App\Factories\RackModelFactory::class,
        \App\Domain\Interfaces\RackInterfaces\RackRepository::class => \App\Repositories\RackDatabaseRepository::class,
        \App\Domain\Interfaces\DeviceInterfaces\DeviceFactory::class => \App\Factories\DeviceModelFactory::class,
        \App\Domain\Interfaces\DeviceInterfaces\DeviceRepository::class => \App\Repositories\DeviceDatabaseRepository::class,
        \App\Domain\Interfaces\RegionInterfaces\RegionFactory::class => \App\Factories\RegionModelFactory::class,
        \App\Domain\Interfaces\RegionInterfaces\RegionRepository::class => \App\Repositories\RegionDatabaseRepository::class,
        \App\Domain\Interfaces\DepartmentInterfaces\DepartmentFactory::class => \App\Factories\DepartmentModelFactory::class,
        \App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository::class => \App\Repositories\DepartmentDatabaseRepository::class,
        \App\Domain\Interfaces\SiteInterfaces\SiteFactory::class => \App\Factories\SiteModelFactory::class,
        \App\Domain\Interfaces\SiteInterfaces\SiteRepository::class => \App\Repositories\SiteDatabaseRepository::class,
        \App\Domain\Interfaces\BuildingInterfaces\BuildingFactory::class => \App\Factories\BuildingModelFactory::class,
        \App\Domain\Interfaces\BuildingInterfaces\BuildingRepository::class => \App\Repositories\BuildingDatabaseRepository::class,
        \App\Domain\Interfaces\RoomInterfaces\RoomFactory::class => \App\Factories\RoomModelFactory::class,
        \App\Domain\Interfaces\RoomInterfaces\RoomRepository::class => \App\Repositories\RoomDatabaseRepository::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */
        $this->app
            ->when(\App\Console\Commands\UserCommands\CreateUserCommand::class)
            ->needs(\App\UseCases\UserUseCases\CreateUserUseCase\CreateUserInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\UserUseCases\CreateUserUseCase\CreateUserInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\UserPresenters\CreateUserCliPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Console\Commands\UserCommands\UpdateUserCommand::class)
            ->needs(\App\UseCases\UserUseCases\UpdateUserUseCase\UpdateUserInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\UserUseCases\UpdateUserUseCase\UpdateUserInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\UserPresenters\UpdateUserCliPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Console\Commands\UserCommands\DeleteUserCommand::class)
            ->needs(\App\UseCases\UserUseCases\DeleteUserUseCase\DeleteUserInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\UserUseCases\DeleteUserUseCase\DeleteUserInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\UserPresenters\DeleteUserCliPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Console\Commands\UserCommands\ResetUserPasswordCommand::class)
            ->needs(\App\UseCases\UserUseCases\ResetUserPasswordUseCase\ResetUserPasswordInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\UserUseCases\ResetUserPasswordUseCase\ResetUserPasswordInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\UserPresenters\ResetUserPasswordCliPresenter::class),
                    ]);
            });

        /*
        |--------------------------------------------------------------------------
        | RACK
        |--------------------------------------------------------------------------
        */
        $this->app
            ->when(\App\Http\Controllers\RackControllers\CreateRackController::class)
            ->needs(\App\UseCases\RackUseCases\CreateRackUseCase\CreateRackInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\RackUseCases\CreateRackUseCase\CreateRackInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\RackPresenters\CreateRackJsonPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\RackControllers\GetRackController::class)
            ->needs(\App\UseCases\RackUseCases\GetRackUseCase\GetRackInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\RackUseCases\GetRackUseCase\GetRackInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\RackPresenters\GetRackJsonPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\RackControllers\DeleteRackController::class)
            ->needs(\App\UseCases\RackUseCases\DeleteRackUseCase\DeleteRackInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\RackUseCases\DeleteRackUseCase\DeleteRackInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\RackPresenters\DeleteRackJsonPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\RackControllers\UpdateRackController::class)
            ->needs(\App\UseCases\RackUseCases\UpdateRackUseCase\UpdateRackInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\RackUseCases\UpdateRackUseCase\UpdateRackInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\RackPresenters\UpdateRackJsonPresenter::class),
                ]);
            });

        /*
        |--------------------------------------------------------------------------
        | DEVICE
        |--------------------------------------------------------------------------
        */
        $this->app
            ->when(\App\Http\Controllers\DeviceControllers\GetDeviceController::class)
            ->needs(\App\UseCases\DeviceUseCases\GetDeviceUseCase\GetDeviceInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\DeviceUseCases\GetDeviceUseCase\GetDeviceInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\DevicePresenters\GetDeviceJsonPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\DeviceControllers\CreateDeviceController::class)
            ->needs(\App\UseCases\DeviceUseCases\CreateDeviceUseCase\CreateDeviceInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\DeviceUseCases\CreateDeviceUseCase\CreateDeviceInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\DevicePresenters\CreateDeviceJsonPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\DeviceControllers\UpdateDeviceController::class)
            ->needs(\App\UseCases\DeviceUseCases\UpdateDeviceUseCase\UpdateDeviceInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\DeviceUseCases\UpdateDeviceUseCase\UpdateDeviceInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\DevicePresenters\UpdateDeviceJsonPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\DeviceControllers\DeleteDeviceController::class)
            ->needs(\App\UseCases\DeviceUseCases\DeleteDeviceUseCase\DeleteDeviceInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\DeviceUseCases\DeleteDeviceUseCase\DeleteDeviceInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\DevicePresenters\DeleteDeviceJsonPresenter::class),
                ]);
            });

        /*
        |--------------------------------------------------------------------------
        | REGION
        |--------------------------------------------------------------------------
        */
        $this->app
            ->when(\App\Http\Controllers\RegionControllers\GetRegionController::class)
            ->needs(\App\UseCases\RegionUseCases\GetRegionUseCase\GetRegionInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\RegionUseCases\GetRegionUseCase\GetRegionInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\RegionPresenters\GetRegionJsonPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Console\Commands\RegionCommands\CreateRegionCommand::class)
            ->needs(\App\UseCases\RegionUseCases\CreateRegionUseCase\CreateRegionInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\RegionUseCases\CreateRegionUseCase\CreateRegionInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\RegionPresenters\CreateRegionCliPresenter::class),
                    ]);
            });

        $this->app
            ->when(\App\Console\Commands\RegionCommands\DeleteRegionCommand::class)
            ->needs(\App\UseCases\RegionUseCases\DeleteRegionUseCase\DeleteRegionInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\RegionUseCases\DeleteRegionUseCase\DeleteRegionInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\RegionPresenters\DeleteRegionCliPresenter::class),
                    ]);
            });

        $this->app
            ->when(\App\Console\Commands\RegionCommands\UpdateRegionCommand::class)
            ->needs(\App\UseCases\RegionUseCases\UpdateRegionUseCase\UpdateRegionInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\RegionUseCases\UpdateRegionUseCase\UpdateRegionInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\RegionPresenters\UpdateRegionCliPresenter::class),
                    ]);
            });

        /*
        |--------------------------------------------------------------------------
        | DEPARTMENT
        |--------------------------------------------------------------------------
        */
        $this->app
            ->when(\App\Http\Controllers\DepartmentControllers\GetDepartmentController::class)
            ->needs(\App\UseCases\DepartmentUseCases\GetDepartmentUseCase\GetDepartmentInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\DepartmentUseCases\GetDepartmentUseCase\GetDepartmentInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\DepartmentPresenters\GetDepartmentJsonPresenter::class),
                    ]);
            });

        $this->app
            ->when(\App\Console\Commands\DepartmentCommands\CreateDepartmentCommand::class)
            ->needs(\App\UseCases\DepartmentUseCases\CreateDepartmentUseCase\CreateDepartmentInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\DepartmentUseCases\CreateDepartmentUseCase\CreateDepartmentInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\DepartmentPresenters\CreateDepartmentCliPresenter::class),
                    ]);
            });

        $this->app
            ->when(\App\Console\Commands\DepartmentCommands\DeleteDepartmentCommand::class)
            ->needs(\App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase\DeleteDepartmentInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase\DeleteDepartmentInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\DepartmentPresenters\DeleteDepartmentCliPresenter::class),
                    ]);
            });

        $this->app
            ->when(\App\Console\Commands\DepartmentCommands\UpdateDepartmentCommand::class)
            ->needs(\App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase\UpdateDepartmentInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase\UpdateDepartmentInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\DepartmentPresenters\UpdateDepartmentCliPresenter::class),
                    ]);
            });

        /*
        |--------------------------------------------------------------------------
        | SITE
        |--------------------------------------------------------------------------
        */
        $this->app
            ->when(\App\Http\Controllers\SiteControllers\CreateSiteController::class)
            ->needs(\App\UseCases\SiteUseCases\CreateSiteUseCase\CreateSiteInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\SiteUseCases\CreateSiteUseCase\CreateSiteInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\SitePresenters\CreateSiteJsonPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\SiteControllers\GetSiteController::class)
            ->needs(\App\UseCases\SiteUseCases\GetSiteUseCase\GetSiteInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\SiteUseCases\GetSiteUseCase\GetSiteInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\SitePresenters\GetSiteJsonPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\SiteControllers\DeleteSiteController::class)
            ->needs(\App\UseCases\SiteUseCases\DeleteSiteUseCase\DeleteSiteInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\SiteUseCases\DeleteSiteUseCase\DeleteSiteInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\SitePresenters\DeleteSiteJsonPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\SiteControllers\UpdateSiteController::class)
            ->needs(\App\UseCases\SiteUseCases\UpdateSiteUseCase\UpdateSiteInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\SiteUseCases\UpdateSiteUseCase\UpdateSiteInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\SitePresenters\UpdateSiteJsonPresenter::class),
                ]);
            });

        /*
        |--------------------------------------------------------------------------
        | BUILDING
        |--------------------------------------------------------------------------
        */
        $this->app
            ->when(\App\Http\Controllers\BuildingControllers\GetBuildingController::class)
            ->needs(\App\UseCases\BuildingUseCases\GetBuildingUseCase\GetBuildingInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\BuildingUseCases\GetBuildingUseCase\GetBuildingInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\BuildingPresenters\GetBuildingJsonPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\BuildingControllers\CreateBuildingController::class)
            ->needs(\App\UseCases\BuildingUseCases\CreateBuildingUseCase\CreateBuildingInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\BuildingUseCases\CreateBuildingUseCase\CreateBuildingInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\BuildingPresenters\CreateBuildingJsonPresenter::class),
                    ]);
            });

        $this->app
            ->when(\App\Http\Controllers\BuildingControllers\DeleteBuildingController::class)
            ->needs(\App\UseCases\BuildingUseCases\DeleteBuildingUseCase\DeleteBuildingInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\BuildingUseCases\DeleteBuildingUseCase\DeleteBuildingInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\BuildingPresenters\DeleteBuildingJsonPresenter::class),
                    ]);
            });

        $this->app
            ->when(\App\Http\Controllers\BuildingControllers\UpdateBuildingController::class)
            ->needs(\App\UseCases\BuildingUseCases\UpdateBuildingUseCase\UpdateBuildingInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\BuildingUseCases\UpdateBuildingUseCase\UpdateBuildingInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\BuildingPresenters\UpdateBuildingJsonPresenter::class),
                    ]);
            });

        /*
        |--------------------------------------------------------------------------
        | ROOM
        |--------------------------------------------------------------------------
        */
        $this->app
            ->when(\App\Http\Controllers\RoomControllers\GetRoomController::class)
            ->needs(\App\UseCases\RoomUseCases\GetRoomUseCase\GetRoomInputPort::class)
            ->give(function ($app) {
                return $app->make(\App\UseCases\RoomUseCases\GetRoomUseCase\GetRoomInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\RoomPresenters\GetRoomJsonPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\RoomControllers\CreateRoomController::class)
            ->needs(\App\UseCases\RoomUseCases\CreateRoomUseCase\CreateRoomInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\RoomUseCases\CreateRoomUseCase\CreateRoomInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\RoomPresenters\CreateRoomJsonPresenter::class),
                    ]);
            });

        $this->app
            ->when(\App\Http\Controllers\RoomControllers\DeleteRoomController::class)
            ->needs(\App\UseCases\RoomUseCases\DeleteRoomUseCase\DeleteRoomInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\RoomUseCases\DeleteRoomUseCase\DeleteRoomInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\RoomPresenters\DeleteRoomJsonPresenter::class),
                    ]);
            });

        $this->app
            ->when(\App\Http\Controllers\RoomControllers\UpdateRoomController::class)
            ->needs(\App\UseCases\RoomUseCases\UpdateRoomUseCase\UpdateRoomInputPort::class)
            ->give(function ($app) {
                return $app
                    ->make(\App\UseCases\RoomUseCases\UpdateRoomUseCase\UpdateRoomInteractor::class, [
                        'output' => $app
                            ->make(\App\Adapters\Presenters\RoomPresenters\UpdateRoomJsonPresenter::class),
                    ]);
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
