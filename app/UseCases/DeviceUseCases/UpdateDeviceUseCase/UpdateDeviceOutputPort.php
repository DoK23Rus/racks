<?php

namespace App\UseCases\DeviceUseCases\UpdateDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateDeviceOutputPort
{
    /**
     * @param  UpdateDeviceResponseModel  $response
     * @return ViewModel
     */
    public function deviceUpdated(UpdateDeviceResponseModel $response): ViewModel;

    /**
     * @param  UpdateDeviceResponseModel  $response
     * @return ViewModel
     */
    public function noSuchUnits(UpdateDeviceResponseModel $response): ViewModel;

    /**
     * @param  UpdateDeviceResponseModel  $response
     * @return ViewModel
     */
    public function unitsAreBusy(UpdateDeviceResponseModel $response): ViewModel;

    /**
     * @param  UpdateDeviceResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function updateFailed(UpdateDeviceResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  UpdateDeviceResponseModel  $response
     * @return ViewModel
     */
    public function noSuchDevice(UpdateDeviceResponseModel $response): ViewModel;

    /**
     * @param  UpdateDeviceResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToUpdateDevice(UpdateDeviceResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  UpdateDeviceResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(UpdateDeviceResponseModel $response): ViewModel;
}
