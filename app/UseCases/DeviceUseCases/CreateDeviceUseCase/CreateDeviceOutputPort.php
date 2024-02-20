<?php

namespace App\UseCases\DeviceUseCases\CreateDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateDeviceOutputPort
{
    /**
     * @param  CreateDeviceResponseModel  $response
     * @return ViewModel
     */
    public function deviceCreated(CreateDeviceResponseModel $response): ViewModel;

    /**
     * @param  CreateDeviceResponseModel  $response
     * @return ViewModel
     */
    public function noSuchUnits(CreateDeviceResponseModel $response): ViewModel;

    /**
     * @param  CreateDeviceResponseModel  $response
     * @return ViewModel
     */
    public function unitsAreBusy(CreateDeviceResponseModel $response): ViewModel;

    /**
     * @param  CreateDeviceResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function creationFailed(CreateDeviceResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  CreateDeviceResponseModel  $response
     * @return ViewModel
     */
    public function noSuchRack(CreateDeviceResponseModel $response): ViewModel;

    /**
     * @param  CreateDeviceResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToCreateDevice(CreateDeviceResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  CreateDeviceResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(CreateDeviceResponseModel $response): ViewModel;
}
